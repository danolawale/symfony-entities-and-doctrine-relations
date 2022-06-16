# symfony-entities-and-doctrine-relations
- Navigate to the root of the project and run
** docker-compose up -d **

Run the migrations
** symfony console doctrine:migrations:migrate **

- Navigate to phpmyadmin on localhost:8081 and login. Username should be root and password is password - unless this is changed in the docker-compose file

- Create a test database called **ecommerceDataStorageTest**. The dev database as seen in the docker-compose file is called **ecommerceDataStorage**. If this is changed, then the test database also needs to change to the same name with a suffix `Test`

-Once the test database is created, copy the structure (i.e structure only) of the tables to the test database

-Now you can run the tests
** symfony php bin/phpunit tests **
** symfony php bin/phpunit tests/ProductsTest.php ** //to run ProductsTest

The tests use Symfony Data fixtures to set initial values in the database before each test.