# Meal Recommendation System API
## Description

This repository implemented a meal recommendation system REST API with the following features:
1. The system should operate on three Allergies: 
    1. Nut Allergy
    2. ShellFish Allergy
    3. SeaFood Allergy
2. Every user on the system should be able to pick their allergies (ranging from zero to all the allergies provided by the system).
3. The system should be able to accommodate at least 50 meals (Each meal should have a main item & at least 2 side items) at any time (with allergies for these meals)
4. The system should have the ability to recommend meals to users based on their allergies.
    1. For better clarity, this means:
        1. Every user has the ability to fetch meal recommendations at any time.
5. The system should also be able to fetch meal recommendations for more than one user at a time. (example: fetch meal recommendations for 10 users at a time)

## Table of Content

- [Installation](#installation)
- [Documentation](#documentation)
- [Testing](#testing)
## Installation
The entity relationship diagram is available [here](https://dbdiagram.io/d/610d504d2ecb310fc3c0cf9b).

#### Step 1: Clone the repository

```bash
git clone https://github.com/ayodeleoniosun/meal-recommendation-api.git
```
#### Step 2: Switch to repo folder

```bash
cd meal-recommendation-api
```
#### Step 3: Install all dependencies using composer

```bash
composer install
```
#### Step 4: Setup environment variables

- Copy `.env.example` to `.env` i.e `cp .env.exaample .env`
- Update DB\_ variables to your database configuration details
- Update other variables as needed

#### Step 5: Generate a new application key

```bash
php artisan key:generate
```
#### Step 6: Run database migration and seeder

```bash
php artisan migrate:fresh --seed
```

#### Step 6: Start development server

```bash
php artisan serve
```

You can now access the api locally at http://localhost:8000/api/v1

You can now access the api remotely [here](https://ayodele-meals-recommendation.herokuapp.com/api/v1).
## Documentation

Publish the swagger documentation by running this
```bash
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

After starting the project in development mode, you can import the postman collection [here](https://github.com/ayodeleoniosun/meal-recommendation-api/blob/develop/app/Meal%20Recommendation%20API.postman_collection.json).

The API documentation is available locally [here](http://localhost:8000).

The API documentation is available remotely [here](https://ayodele-meals-recommendation.herokuapp.com).
## Testing
#### Run test

```bash
vendor/bin/phpunit tests/Feature
```