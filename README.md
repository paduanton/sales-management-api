# Overview

Sales Management is an open source project that implements a Market Sales System. It is developed in vanilla PHP with PostgresSQL. This repository is the Restful API backend only. The frontend is written in ReactJS and can be seen here:

[Sales Management Frontend](https://github.com/paduanton/sales-management-ui)

## Application Architecture
![](https://raw.githubusercontent.com/paduanton/sales-management-api/main/docs/Application-Architecture.png)

This API has the following entities: Users, FeedPreferences, OAuthAuthCodes, OAuthAccessTokens, OAuthRefreshTokens, OAuthClients, OAuthPersonalAccessClients and Migrations.
### ER Database Diagram
(click the image to zoom it or just download the image and zoom it by yourself so you can see better all tables relationships)

![](https://raw.githubusercontent.com/paduanton/sales-management-api/main/docs/ER-diagram.png)

#### Entity Relationship:
- Sales N - 1 Product (relationship based on a json colum os Sales entity)
- Product 1 - 1 ProductTypes

This application handles a couple of features such sales listing, sales preview, storing sales, storing products, storing products types, listing product type and products listing. Given a list of products it automatically calculates all the sales information you need, such as: taxes amount, total sale price, total price per product and tax percentage 

## System Requirements (Mac OS, Windows or Linux)
* [Docker](https://www.docker.com/get-started)
* [Docker Compose](https://docs.docker.com/compose/install)

## Project Setup

After clonning the repo, run the following commands on bash, inside the root directory:


Build postgres database and PGAdmin:
```
docker-compose build up --build
```

Install pgsql extension:

```
sudo apt install php-pgsql
```


Copy environment variables of the project:
```
cp .env.example .env
```

After creating a .env file you need to set the database properties on it. If you are using the docker-compose file mentioned in this project, please follow these steps below. Otherwise, just set the .env file and you are good to go to run the API. 

So, to set the DB_HOST variable you need to get the database container IP. In order to do so, after building the database containers, you need run the following command so you can get the ip address of the postgres server.

```
docker inspect pg_container | grep IPAddress
```

Then you need to copy the IP address and paste it on the DB_HOST variable.

To create a database you can access the PGAdmin on your browser a create a brand new one.

http://localhost:5050/browser/

**Important**

To create the database you have 2 ways

- 1 - Import the database_dump file on the root of the project (using pg_restore)
- 2 - Create all tables one by one using the database_tables.sql file

After setting the .env variables and create the database correctly you are good to go!

Run the API:
```
php -S localhost:8080
```

### Notes: 

- In **all** http requests you must provide the the headers `Accept:application/json`. In POST http requests you need to set the header `Content-Type:application/json`.

## Documentation

You can access the Restful API public documentation [clicking here](https://www.postman.com/paduanton/workspace/antonio-de-pdua-s-public-workspace/collection/5889563-5a60df56-a337-4bbb-bb12-9ab2387363f1?ctx=documentation). 


[Or you can download and import the Postman collection inside the docs folder](https://raw.githubusercontent.com/paduanton/sales-management-api/main/docs/sales-management-api.postman_collection.json). 



