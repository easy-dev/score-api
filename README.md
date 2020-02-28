### Score Api

#### Goal:

The goal of this task is to create an REST API endpoint for frontend app to read data about scores taken from 3rd party service via backend app.
<br>

#### Architectural drivers:

● Performance

● Scalability

● Failure impact

● Well-tested

#### Requirements:

● allow to read data in JSON format, but should be open to extend

● allow to sort by date / score

3 party service url

[https://private-b5236a-jacek10.apiary-mock.com/results/games/1](https://private-b5236a-jacek10.apiary-mock.com/results/games/1)

- - -

#### How to run

```
composer install
```

```
 docker-compose build
```

```
 docker-compose up -d
```

#### Running tests
Full stack BDD
<br>
unit

```
make test-spec
```

functional

```
make test-behat
```

#### Available endpoints

```
GET http://localhost:8080/scores/1?field={field}&order={order}
```

order - [ASC, DESC]
field - [finishedAt, score]

### Notes

* Sorting is implemented in code, I made this decision because moving it to mongo side would require using aggregates and Doctrine ODM would loose hydration. I would go with doing it with aggregate if data set of scores would be very big to avoid computation on php side.
* For performance and fail proof results are cached in mongodb if all players finished games

### TODO

* C4 architecture diagrams
* Cache partial results for external API failures
* API docs with swagger
* execute tests inside container