## Requirements
1. php 8
2. laravel 9
3. vue 3
4. Elastic Search

## Starting the project
Please run the below commands after cloning this project
1. connect to your DB in .env
2. composer install
3. npm install
4. php artisan migrate
5. php artisan db:seed //seeds data for users & books from given api
6. php artisan serve (open the url in the browser http://127.0.0.1:8000/)
7. npm run dev --watch

8. php artisan storage:link (for linking storage & public folder)

## credentials
1. admin credentials
    username: admin@gmail.com
    password: admin 

2. customer login
   username: customer@gmail.com
    password: customer

(password is hashed and cannot be identified from the DB)

## apis
written in web.php

Used laravel auth for login / register (so it has inbuilt Auth routes)

/home : this route open the list of books (admin will get the data in table format and can perform crud operations).
        Customers will view this page in grid view and will have an option to search
        views returned by this route is different based on their role

/customer-view : This route is only for admin. This route returns the view in which the customers view the books list.

/get-books : gets all books based on search and pagination results

/books : this is a resource controller route which has crud operations based on the url and method of the route
used soft deletes for deleting of books


/migrate-books :  migrates all books data from DB to elastic search
/search-books : search books from elastic search



## Controller

BookController:
It is a resource controller which has all crud operations of a book.
All methods except getBooks() (retrieving of books list) are secured by admin middleware as Admin can only have access to perform crud operations

Images are stored in public folder in the same application

ElastiSearchController:
has code for inserting data into elastic search and retreiving
