# EXAPP #
[![Build Status](https://travis-ci.org/Gadoma/Exapp.svg?branch=master)](https://travis-ci.org/Gadoma/Exapp) [![Coverage Status](https://coveralls.io/repos/Gadoma/Exapp/badge.svg?branch=master)](https://coveralls.io/r/Gadoma/Exapp?branch=master)

## Objective ##
Build a market trade processor which consumes trade messages via an endpoint, processes those messages in some way and delivers a frontend of processed information based on the consumed messages.

## Solution ##
The core of the provided solution is a RESTful API powered by a monolithic Laravel 4.2 app of layered architecture. 

The API offers 2 resources:
- _MESSAGES_ - a write only endpoint for storing message data
- _COUNTRIES_ - a read only endpoint for accessing country statistics

The statistics are computed by the _PROCESSOR_ service that is called by a CLI command.

The frontend is a separate component that fetches the statistics from the API and displays them.

For the purpose of this exercise the API does not include any authentication or authorization mechanisms. 

**The main accent of the solution is put on the following aspects:**

### API Design ###
The API operates in a RESTful manner and both of the available resources are self-discoverable (via OPTIONS request) and CORS-enabled. The API offers detailed error messages and appropriate HTTP status codes accounting for different situations (success, validation failure, errors etc.).

### Extensibility ###
The application structure is designed with SOLID principles in mind and uses PSR-4 autoloading. The code is PSR-1/2 compliant and thoroughly commented (PHPDoc).

### Testing ###
The solution is developed in StoryBDD style, thus the main functionalities (_MESSAGES_ endpoint, _COUNTRIES_ endpoint and the _PROCESSOR_) are shaped and verified by Behat tests (30 scenarios/65 steps). 

Most of Exapp specific classes have corresponding PHPUnit test cases (55 tests/55 assertions) providing 88% code coverage. 

Commits and pull requests are built and unit tested with Travis-CI whereas the coverage is calculated with Coveralls service. 

## Components ##
### Message Consumption ###
The consumption endpoint is located under the _MESSAGES_ resource and accepts data in JSON format as body of a POST request.
```
http://exapp-base-url/v1/messages
```
Example input: 
```json
{
	"userId": "134256", 
	"currencyFrom": "EUR", 
	"currencyTo": "GBP", 
	"amountSell": 1000, 
	"amountBuy": 747.10, 
	"rate": 0.7471, 
	"timePlaced" : "24­-JAN-­15 10:27:44", 
	"originatingCountry" : "GB"
}
```
Data posted to the endpoint is validated and upon passing validation it is stored in a MySql (or alternatively SQLite) database. The allowed countries of origin and currencies are defined in the following config file: 
```
/exapp-installation-path/app/config/exapp.php
```

### Message Processor ###
The _PROCESSOR_ calculates message statistics grouped by country of origin for all received and stored messages, offering the following per country metrics:
- Total message count  
- Top currency pair
- Top currency pair message count
- Top currency pair average exchange rate
- The share of top currency pair’s messages in the total volume of messages (represented as percentage)

The _PROCESSOR_ service is run as a separate process in form of a Laravel Artisan command that is invoked in CLI every 1 minute with CRON. The command can of course be executed manually by running
```
php /exapp-installation-path/artisan exapp:process
```
The calculated statistics are available in JSON format under the _COUNTRIES_ resource and can be fetched via a GET request.
```
http://exapp-base-url/v1/countries
```
Example output:
```json
{
    "data":[
        {
            "countryCode":"DE",
            "countryName":"Germany",
            "messageCount":6,
            "topCurrencyPair":"EUR\/CHF",
            "topCurrencyPairMsgCnt":3,
            "topCurrencyPairAvgRate":0.7471,
            "topCurrencyPairMsgShare":"50%"
        },
        {
            "countryCode":"CH",
            "countryName":"Switzerland",
            "messageCount":3,
            "topCurrencyPair":"EUR\/CHF",
            "topCurrencyPairMsgCnt":2,
            "topCurrencyPairAvgRate":0.7471,
            "topCurrencyPairMsgShare":"66.67%"
        }
    ]
}
```

### Message Frontend ###
The frontend component is a static HTML page that upon loading fetches the precomputed message statistics (using a jQuery AJAX call) from the _COUNTRIES_ resource and plots them on a world map (via Google GeoChart API). 
```
http://exapp-base-url/frontend.html
```
The colour of each country corresponds to the ‘Total message count’ metric whereas detailed statistics are displayed in a tooltip upon hovering the mouse cursor over the area of a country (only if there were any messages originating from that country). The map can be manually refreshed by pressing the ‘Refresh chart’ button.  
