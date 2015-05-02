Feature: messages
  As a message producer
  I want to save the messages using the api 
  So that the api can store and process them

### check HTTP verbs

Scenario: List accepted http methods
   When I request preflight options from "messages"
   Then the allowed methods should be "OPTIONS,POST"
  
Scenario: Check that GET request method is forbidden
  When I send a GET request to "messages"
  Then the response code should be 405

Scenario: Check that PUT request method is forbidden
  When I send a PUT request to "messages"
  Then the response code should be 405

Scenario: Check that PATCH request method is forbidden
  When I send a PATCH request to "messages"
  Then the response code should be 405

Scenario: Check that DELETE request method is forbidden
  When I send a DELETE request to "messages"
  Then the response code should be 405



### check payload validation

Scenario: Check payload is a valid JSON object
When I send a POST request to "messages" with body:
  """
  ["something" = "wrong"]
  """
  Then the response code should be 400



### check userId validation

Scenario: Check userId is required
  When I send a POST request to "messages" with body:
  """
  {"currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check userId value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "ABCD", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422



### check currencyFrom validation

Scenario: Check currencyFrom is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check currencyFrom value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "ABCD", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422

  

### check currencyTo validation

Scenario: Check currencyTo is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check currencyTo value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "ABCD", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422



### check amountSell validation

Scenario: Check amountSell is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check amountSell value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": "ABCD", "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422



### check amountBuy validation

Scenario: Check amountBuy is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check amountBuy value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": "ABCD", "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422



### check rate validation

Scenario: Check rate is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check rate value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": "ABCD", "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422



### check timePlaced validation

Scenario: Check timePlaced is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "originatingCountry" : "FR"}
  """
  Then the response code should be 422
  
Scenario: Check timePlaced value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24ABCD­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 422



### check originatingCountry validation

Scenario: Check originatingCountry is required
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44"}
  """
  Then the response code should be 422
  
Scenario: Check originatingCountry value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "ABCD"}
  """
  Then the response code should be 422



### check valid request

Scenario: Check originatingCountry value is valid  
  When I send a POST request to "messages" with body:
  """
  {"userId": "134256", "currencyFrom": "EUR", "currencyTo": "GBP", "amountSell": 1000, "amountBuy": 747.10, "rate": 0.7471, "timePlaced" : "24­JAN­15 10:27:44", "originatingCountry" : "FR"}
  """
  Then the response code should be 201
