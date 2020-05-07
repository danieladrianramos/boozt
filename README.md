# Boozt test

This repo contains my solution for the test. 

## Test

In the root folder you could see the PDF with the goal.

## Design

MVC pattern with data providers and autoloading without using external PHP libraries and composer.

- **index.php:** entry point of the app (front controller).
- **Controller/:** it contains the "Dashboard" controller + the "MainController" (abstract class) that that force its childrens to have an index method as a default method.
- **Provider/** it contains the data providers + the interface "Countable". 
- **Model/** it contains classes that are a kind of POJO + the interface "Jsonable".
- **Lib/** it contains the class for connecting the DB using PDO + a class for rendering the views.
- **Helper/** it contains classes for facilitate the tasks related dates and data for the chart.


**Note:** It uses Bootsrap 4 and Jquery for achieving the goal.

## Database

The file "db.sql" contains the script for creating the DB. Before execute it, please create the DB "test" in mysql.

## Running the app

```
php -S localhost:8080 index.php
```
