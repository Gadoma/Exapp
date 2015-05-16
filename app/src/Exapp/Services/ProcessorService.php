<?php

namespace Exapp\Services;

use Exapp\Exceptions\RuntimeException;

class ProcessorService implements ProcessorServiceInterface
{
    /**
     * @var \Exapp\Repositories\CountryRepositoryInterface Country repository
     */
    private $countryRepo;

    /**
     * @var \Illuminate\Database\ConnectionInterface DB connection
     */
    private $dbConn;

    /**
     * @var array List of countries indexed by country code
     */
    private $countryList;

    /**
     * @var string SQL driver being used
     */
    private $sqlDriver;

    /**
     * Constructor.
     *
     * @param \Exapp\Repositories\CountryRepositoryInterface $countryRepo Country repository
     */
    public function __construct(\Exapp\Repositories\CountryRepositoryInterface $countryRepo)
    {
        $this->countryRepo = $countryRepo;

        $this->dbConn = \App::make('db')->connection();

        $config = \App::make('config');

        $this->countryList = $config->get('exapp.countries');

        $this->sqlDriver = $config->get('database.default');
    }

    /**
     * Process messages and generate country statistics.
     *
     * @return bool true
     */
    public function process()
    {
        $result = $this->dbConn->select($this->dbConn->raw($this->getSql()));

        foreach ($result as $row) {
            try {
                $stat = (array) $row;

                $stat['country_name'] = $this->countryList[$stat['country_code']];

                $this->countryRepo->storeOrUpdate(['country_code' => $stat['country_code']], $stat);
            } catch (\Exception $ex) {
                throw new RuntimeException($ex->getMessage());
            }
        }

        return true;
    }

    /**
     * Helper function returning the statistics sql string.
     *
     * @return string The sql for generating country stats
     */
    private function getSql()
    {
        return 'SELECT
                (
                    SELECT COUNT(*) FROM `messages` AS a
                    WHERE `a`.`originating_country`=`b`.`originating_country`
                    GROUP BY `originating_country`
                ) AS `message_count`,
                `originating_country` AS `country_code`,
                AVG(`rate`) AS `top_pair_avg_rate`,
                '.$this->getConcat('`currency_from`', "'/'", '`currency_to`').' AS `top_currency_pair`,
                COUNT(*) AS `top_pair_msg_cnt`
                FROM `messages` AS b
                GROUP BY '.$this->getConcat('`currency_from`', "'/'", '`currency_to`').', `originating_country`
                HAVING `top_pair_msg_cnt` = (
                    SELECT COUNT(*) AS `cnt`
                    FROM `messages` AS c
                    WHERE `c`.`originating_country`=`b`.`originating_country`
                    GROUP BY '.$this->getConcat('`currency_from`', "'/'", '`currency_to`').'
                    ORDER BY `cnt` DESC
                    LIMIT 1
                    )';
    }

    /**
     * Helper function returning the sql dialect specific concatenate clause.
     *
     * @param string $arg1 Concatenation operand
     * @param string $arg2 Concatenation operand
     * @param string ...    Concatenation operand
     *
     * @return string The sql clause for concatenation operation of arguments
     */
    private function getConcat($arg1, $arg2)
    {
        return ($this->sqlDriver == 'sqlite') ? implode('||', func_get_args()) : 'CONCAT('.implode(',', func_get_args()).')';
    }
}
