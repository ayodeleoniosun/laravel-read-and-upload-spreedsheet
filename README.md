# Upload Spreadsheet API
## Description

This repository implemented a REST API that allows us to upload and then search and consume data.
It consists of:
1. An endpoint to allow users to upload a .xls with data for treatment. The data always follows the same structure/format and that format can be seen on the linked file above. It handles concurrent uploads. The uploaded data is imported into a Postgres database containing all columns necessary for the storage of data as per the xls and respective operations detailed below. 
2. An endpoint to query the status of processing the uploaded xls and adding it to the database. 
3. An endpoint to query/search data from the database based on: date (dataCelebracaoContrato in xls), amount (range) (precoContratual in xls), winning company (adjudicatarios in the xls). 
4. An endpoint to get all data for a given contract as long as provided with an ID. This marks row as ‘read’.
5. An endpoint to check if a certain contract (row) was ever read or not.
## Table of Content

- [Installation](#installation)
- [Documentation](#documentation)
- [Testing](#testing)
## Installation
#### Step 1: Clone the repository

```bash
git clone https://github.com/ayodeleoniosun/laravel-read-upload-spreedsheet.git
```
#### Step 2: Switch to repo folder

```bash
cd laravel-read-upload-spreedsheet
```
#### Step 3: Install all dependencies using composer

```bash
composer install
```
#### Step 4: Setup environment variables

- Copy `.env.example` to `.env` i.e `cp .env.example .env`
- Update DB\_ variables to your database configuration details
- Update other variables as needed

#### Step 5: Generate a new application key

```bash
php artisan key:generate
```
#### Step 6: Run database migration and seeder

```bash
php artisan migrate
```

#### Step 6: Start development server

```bash
php artisan serve
```

You can now access the api locally at http://localhost:8000/api/v1

You can now access the api remotely [here](https://ayodele-laravel-read-upload-spreedsheet.com/api/v1).
## Documentation

Publish the swagger documentation by running this
```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

After starting the project in development mode, you can import the postman collection [here](https://github.com/ayodeleoniosun/laravel-read-upload-spreedsheet/blob/master/app/Upload%20Spreadsheet.postman_collection.json).

The API documentation is available locally [here](http://localhost:8000).

The API documentation is available remotely [here](https://ayodele-laravel-read-upload-spreedsheet.herokuapp.com).
## Testing
#### Run test

```bash
vendor/bin/phpunit
```