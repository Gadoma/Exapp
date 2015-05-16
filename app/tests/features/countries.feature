Feature: countries
  As a country consumer
  I want to get the country statistics using the api 
  So that they can be displayed

### check HTTP verbs

Scenario: List accepted http methods
   When I request preflight options from "countries"
   Then the allowed methods should be "OPTIONS,GET"
  
Scenario: Check that POST request method is forbidden
  When I send a POST request to "countries"
  Then the response code should be 405

Scenario: Check that PUT request method is forbidden
  When I send a PUT request to "countries"
  Then the response code should be 405

Scenario: Check that PATCH request method is forbidden
  When I send a PATCH request to "countries"
  Then the response code should be 405

Scenario: Check that DELETE request method is forbidden
  When I send a DELETE request to "countries"
  Then the response code should be 405

### check valid request

Scenario: Check valid get request
  Given I have test data for countries
  When I send a GET request to "countries"
  Then the response code should be 200
  And the response should contain json:
    """
    {
    "data": [
        {
           "countryCode": "DE",
           "countryName": "Germany",
           "messageCount": 30,
           "topCurrencyPair": "CHF/EUR",
           "topCurrencyPairMsgCnt": 20,
           "topCurrencyPairAvgRate": 0.1234,
           "topCurrencyPairMsgShare": "66.67%"
        },
        {
           "countryCode": "GB",
           "countryName": "United Kingdom",
           "messageCount": 20,
           "topCurrencyPair": "GBP/EUR",
           "topCurrencyPairMsgCnt": 20,
           "topCurrencyPairAvgRate": 0.1234,
           "topCurrencyPairMsgShare": "100%"
           
        },
        {
           "countryCode": "PL",
           "countryName": "Poland",
           "messageCount": 40,
           "topCurrencyPair": "PLN/CHF",
           "topCurrencyPairMsgCnt": 20,
           "topCurrencyPairAvgRate": 0.1234,
           "topCurrencyPairMsgShare": "50%"
        }
    ]
    }
    """