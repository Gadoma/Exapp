Feature: processor
  As a country consumer
  I want to be able to generate statistics from messages
  So that they can be fetched using the api



### generate statistics and fetch country data

Scenario: Check generated statistics
  Given I have test data for messages
  And I call the processor command
  When I send a GET request to "countries"
  Then the response code should be 200
  And the response should contain json:
    """
    {
    "data": {
        "countryCode": "GB",
        "countryName": "United Kingdom",
        "messageCount": 3,
        "topCurrencyPair": "EUR/GBP",
        "topCurrencyPairMsgCnt": 3,
        "topCurrencyPairAvgRate": 0.8,
        "topCurrencyPairMsgShare": "100%"
        }
    }
    """