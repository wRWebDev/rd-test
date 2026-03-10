# RD Test

## Requirements

To install this repository locally, you'll need to be running the following:
  - `PHP ^8.2`
  - `composer ^2.0`
  - `npm ^10`

## Installation

Run the following from the root directory of the project:
```bash
composer setup
php artisan db:seed
```

And then to view the project, run:
```bash
php artisan serve
```

## Tests

To run the project's tests, use:
```
composer test
```

## About

This project conforms to the given brief and extends it in some areas:

### Going further

#### Ordering Products

I've allowed for a greater quantity of products to be ordered than the available stock from the warehouse with the greatest quantity. Due to time constraints, I've made the trade-off of not chunking the query for warehouses, making the assumption that we would cross that bridge as and when it becomes an issue.

#### Caching

I took the decision to cache the stats which apply to the products (total quantity, physical quantity, quantity allocated to orders which are still in the warehouses, the stock threshold for each product, and the amount which is available for new orders). This was to speed up the loading of the products page which displays these statistics for all the products. If these statistics weren't cached, the queries which need to join database tables etc. would clog up the database and cause slow low times as the app scales up.

The cached statistics are then cleared when a product is added to an order, or if the order status changes (handled by `OrderObserver`).

#### Geo Locations

To make use of the `geo_location` attribute of each warehouse, I've included a little link to view the location of each warehouse on Google Maps. It doesn't marry up to the fake address data generated, but that's somewhat above and beyond the scope of this project.

#### Validation

There is backend validation on the available quantities for each product. If a quantity which exceeds the product's `immediateDespatch` stat is passed to `OrderController@store`, it will return you to the form and tell you what the error was.

#### Opinionated Formatting

I like when one file looks like another. I have opinions about code formatting, but just so long as within a single project, all files conform to a set of rules, I'm happy. To do this, I utilised Laravel's `pint` package, adding a rules file in the root directory `pint.json`, and then set up a `.vscode/settings.json` file which is set to be hidden in the `.gitignore`, but essentially runs the linter any time we save a `.php` file.

The linter can be run using:
```bash
composer lint
```

#### Static Analysis

I've used PHPStan via the Larastan package to perform some static analysis, help catch unforseen issues and to reduce the amount of redundant code in the codebase. I haven't gone so far as to insist on strict typing, but this is a good starting point if the project were to go in that direction. I believe that in CI/CD environments, things like this are essentials as if they're set up as hooks, either locally or as GitHub actions, they can save a lot of problems down the line.

To run the analysis, use the composer command:
```bash
composer static-analysis
```
or the alias
```bash
composer static
```

### Next Steps

Here are some things that I'd do if I had more time to spend on this project:

1. Handle cancelled orders - do the products come back into stock, and if so, in which warehouse?
2. Create more tests to ensure everything continues to work as planned as the application expands, including tthe frontend of the site.
3. Account for scaling up of the number of warehouses in the system.
4. Make the frontend responsive, and pivot to a reactive framework/use JS to allow for a more dynamic form
5. Create frontend views for orders & warehouses.

## Screenshots

### Order Form
URL: `/`
<img width="100%" alt="Order form screenshot" src="https://github.com/user-attachments/assets/b7c754d7-44f5-40ed-9ec1-589372b5bb46" />

### Products Index
URL: `/products`
<img width="100%" alt="Products index screenshot" src="https://github.com/user-attachments/assets/690938c0-2428-40b8-a860-281cf074efa3" />

### Individual Product
URL: `/products/{product_uuid}`
<img width="100%" alt="Individual product screenshot" src="https://github.com/user-attachments/assets/ac07f2e0-775f-4fa8-a5ad-eb5c9b8fafc2" />
