Feature: Scores API

  Scenario: User retrieves scores
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/scores/1"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    Then the JSON should be equal to:
    """
    [
          {
              "id": "5e58e7ce2851b0612a450b13",
              "user": {
                  "id": "5e58e7cf2851b0612a450b14",
                  "name": "Leona Everett"
              },
              "score": 5,
              "finished_at": "2020-02-27T11:25:00+00:00"
          },
          {
              "id": "5e58e7cf2851b0612a450b15",
              "user": {
                  "id": "5e58e7cf2851b0612a450b16",
                  "name": "Erica Harmon"
              },
              "score": 20,
              "finished_at": "2020-02-26T15:30:00+00:00"
          },
          {
              "id": "5e58e7cf2851b0612a450b17",
              "user": {
                  "id": "5e58e7cf2851b0612a450b18",
                  "name": "Nora Berry"
              },
              "score": 2,
              "finished_at": "2020-02-27T10:39:00+00:00"
          },
          {
              "id": "5e58e7cf2851b0612a450b19",
              "user": {
                  "id": "5e58e7cf2851b0612a450b1a",
                  "name": "Kristina Byrd"
              },
              "score": 100,
              "finished_at": "2020-02-27T11:20:00+00:00"
          },
          {
              "id": "5e58e7cf2851b0612a450b1b",
              "user": {
                  "id": "5e58e7cf2851b0612a450b1c",
                  "name": "Scarlett Harvey"
              },
              "score": 5,
              "finished_at": "2020-02-27T09:12:00+00:00"
          }
     ]
     """

  Scenario: User retrieves scores
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/scores/69"
    Then the response status code should be 404


  Scenario: User retrieves SORTED descending scores
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/scores/1?field=score&order=DESC"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    Then the JSON should be equal to:
    """
    {
          "3": {
              "id": "5e58e7cf2851b0612a450b19",
              "user": {
                  "id": "5e58e7cf2851b0612a450b1a",
                  "name": "Kristina Byrd"
              },
              "score": 100,
              "finished_at": "2020-02-27T11:20:00+00:00"
          },
          "1": {
              "id": "5e58e7cf2851b0612a450b15",
              "user": {
                  "id": "5e58e7cf2851b0612a450b16",
                  "name": "Erica Harmon"
              },
              "score": 20,
              "finished_at": "2020-02-26T15:30:00+00:00"
          },
          "4": {
              "id": "5e58e7cf2851b0612a450b1b",
              "user": {
                  "id": "5e58e7cf2851b0612a450b1c",
                  "name": "Scarlett Harvey"
              },
              "score": 5,
              "finished_at": "2020-02-27T09:12:00+00:00"
          },
          "0": {
              "id": "5e58e7ce2851b0612a450b13",
              "user": {
                  "id": "5e58e7cf2851b0612a450b14",
                  "name": "Leona Everett"
              },
              "score": 5,
              "finished_at": "2020-02-27T11:25:00+00:00"
          },
          "2": {
              "id": "5e58e7cf2851b0612a450b17",
              "user": {
                  "id": "5e58e7cf2851b0612a450b18",
                  "name": "Nora Berry"
              },
              "score": 2,
              "finished_at": "2020-02-27T10:39:00+00:00"
          }
    }
    """

  Scenario: User retrieves SORTED ascending scores
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/scores/1?field=score&order=ASC"
    Then the response status code should be 200
    And the response should be in JSON
    And the header "Content-Type" should be equal to "application/json"
    Then the JSON should be equal to:
    """
    {
          "2": {
              "id": "5e58e7cf2851b0612a450b17",
              "user": {
                  "id": "5e58e7cf2851b0612a450b18",
                  "name": "Nora Berry"
              },
              "score": 2,
              "finished_at": "2020-02-27T10:39:00+00:00"
          },
          "4": {
              "id": "5e58e7cf2851b0612a450b1b",
              "user": {
                  "id": "5e58e7cf2851b0612a450b1c",
                  "name": "Scarlett Harvey"
              },
              "score": 5,
              "finished_at": "2020-02-27T09:12:00+00:00"
          },
          "0": {
              "id": "5e58e7ce2851b0612a450b13",
              "user": {
                  "id": "5e58e7cf2851b0612a450b14",
                  "name": "Leona Everett"
              },
              "score": 5,
              "finished_at": "2020-02-27T11:25:00+00:00"
          },
          "1": {
              "id": "5e58e7cf2851b0612a450b15",
              "user": {
                  "id": "5e58e7cf2851b0612a450b16",
                  "name": "Erica Harmon"
              },
              "score": 20,
              "finished_at": "2020-02-26T15:30:00+00:00"
          },
          "3": {
              "id": "5e58e7cf2851b0612a450b19",
              "user": {
                  "id": "5e58e7cf2851b0612a450b1a",
                  "name": "Kristina Byrd"
              },
              "score": 100,
              "finished_at": "2020-02-27T11:20:00+00:00"
          }
    }
    """

  Scenario: User retrieves SORTED scores with incorrect sorting direction
    When I add "Content-Type" header equal to "application/json"
    And I add "Accept" header equal to "application/json"
    And I send a "GET" request to "/scores/1?field=score&order=RANDOM"
    Then the response status code should be 400