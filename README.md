## Installing

Склонить репозиторий

* Перейти в папку с проектом и запустить ```docker-compose up -d```

* Запустить комманду composer install
```docker-compose exec app composer install```

* Запустить комманду миграции

```docker-compose exec app php bin/console doctrine:migrations:migrate --no-interaction```


* Доступные юзеры для для эндпоинта логина
``root``

``user``



## Что сделано?

* ```POST /api/v1/document/``` - credting draft of the document

* ```GET /api/v1/document/{id}``` - getting document by id

* ```PATCH /api/v1/document/{id}``` - edit document

* ```POST /api/v1/document/{id}/publish``` - publish document

* ```PATCH /api/v1/login``` - get new token


If document is not found, 404 NOT Found must be returned

If document is already published, and user tries to update it, return 400.

Try to publish arelady published document should return 200

PATCH is sending in the body of JSON document, all fields except payload are ignored. If payload is not sent/defined, then return 400.

### Options tasks 

* Each time a user logs in, he receives a new token.

* If the user sends any request with a nonexistent token or with an expired token, then the response with the code 401 should be returned.


* An anonymous person can see a list of published documents, as well as download a specific published document.

* An anonymous person will receive an error 401 when trying to access PATCH and POST requests.

* Only an authorized user can create a document.


* The duration of the token is 1 hour.

