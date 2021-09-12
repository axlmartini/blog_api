# BLOG API

## Summary

| Project      | PHP     | MySQL   | Laravel       |
|--------------|---------|---------|---------------|
| blog_api     | 8.0.10  | 8.0.26  | 7.30.4        |

## Pre-requisite
This project is running PHP's default web server. So make sure the following setup are in your local machine.
- PHP
- MySQL
- Composer

Local should have a running MySQL server. [Install MySQL](https://flaviocopes.com/mysql-how-to-install/) \
Make sure also to prepare and your database in advance. \
Database name: blog_api

## Setup configuration files

1) Go to your project directory
```
cd ~/blog_api/
```

2) Configure the project's env file

```
cp .env.dist .env
```
**NOTE:** Update your .env db credentials accordingly

3) Generate your app key

```
php artisan key: generate
```

4) Install project libraries and dependencies

```
composer install
npm install
```

5) Clear cache:
```
php artisan config:cache
```

6) Run migrations and seeders
```
php artisan migrate
php artisan db:seed
```

7) Run php web server
```
php artisan serve
```

## Access on browser 
**Note:** This project is mainly focused on API. \
Browser will only have a bare layout for projects home directory. \
With laravel's Authentication feature, user can login, register user and logout too.
* [http://localhost:8000/](http://localhost:8000/)


## REST API Endpoints

You can use Postman to test the API endpoints \
Just import the [collection file](https://github.com/axlmartini/blog_api/tree/master/postman) to your Postman. \
And update request payloads of your preference 
### Login
  URL: http://localhost:8000/api/login \
  Method: POST \
  Request Payload:
  ```
  {
    "email": "api_user@email.com",
    "password": "api_user"
  }
  ```
  
### Register
  URL: http://localhost:8000/api/register \
  Method: POST \
  Request Payload:
  ```
  {
    "email": "api_user2@email.com",
    "password": "api_user2",
    "password_confirmation": "api_user2"
  }
  ```
  
### Logout
  URL: http://localhost:8000/api/logout \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted

### Get All Posts
  URL: http://localhost:8000/api/posts \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted
  
### Get Single Post
  URL: http://localhost:8000/api/posts/1 \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted
  
### Create Post
  URL: http://localhost:8000/api/posts/1 \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted \
  Request Payload:
  ```
  {
    "title": "New Posts",
    "content": "New post content here..."
  }
  ```
### Update Post
  URL: http://localhost:8000/api/posts/5 \
  Method: PUT \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted \
  Request Payload:
  ```
  {
    "title": "Updated post 5",
    "content": "Updated content of post 5"
  }
  ```
  
### Delete Post
  URL: http://localhost:8000/api/posts/5 \
  Method: DELETE \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted \
  Note: Cannot delete post with assoicated comment/s.
  
### Get All Comments
  URL: http://localhost:8000/api/comments \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted
  
### Get Single Comments
  URL: http://localhost:8000/api/comments/1 \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted
  
### Create Comments
  URL: http://localhost:8000/api/comments/1 \
  Method: POST \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted \
  Request Payload:
  ```
  {
    "title": "New Posts",
    "content": "New post content here..."
  }
  ```
### Update Comments
  URL: http://localhost:8000/api/comments/5 \
  Method: PUT \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted \
  Request Payload:
  ```
  {
    "post_id": 2,
    "content": "New post content here update"
  }
  ```
  
### Delete Comments
  URL: http://localhost:8000/api/comments/5 \
  Method: DELETE \
  Authorization: Bearer Token (add token from login) \
  Note: Unauthorized user is restricted


## Running Test
```
php artisan test
```

## Access MySQL service
**Note** Credentials are found in env file. You should have running MySQL server on your local.
```
mysql -u root -p
password: [enter your mysql pass]
show databases;
use blog_api;
show tables;
```

## Some useful commands
```
Will create entity, migration 
    - php artisan make:model Post -m
Migrate all
    - php artisan migrate
Rollback last batch of migration
    - php artisan migrate:rollback
Rollback all migration
    - php artisan migrate:reset
Rollback all migration (drop all table)
    - php artisan migrate:refresh
Rollback all migration and run seeders
    - php artisan migrate:refresh --seed
Create seeder
    - php artisan make:seeder PostsTableSeeder
Run specificities seeder file
    - php artisan db:seed --class=PostsTableSeeder
Create controller
    - Php artisan make:controller PostController
Check list of artisan commands
    - php artisan list
Check laravel version
    - php artisan —version
Create a test in the Feature directory
    - php artisan make:test UserTest
Create a test in the Unit directory
    - php artisan make:test UserTest --unit
Generate factory with model it belongs to
    - php artisan make:factory PostFactory --model=Post
```
