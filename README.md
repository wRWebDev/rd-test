# RD Test

`/`
<img width="100%" alt="Screenshot 2026-03-10 at 13 58 24" src="https://github.com/user-attachments/assets/b7c754d7-44f5-40ed-9ec1-589372b5bb46" />

`/products`
<img width="100%" height="578" alt="Screenshot 2026-03-10 at 14 04 51" src="https://github.com/user-attachments/assets/690938c0-2428-40b8-a860-281cf074efa3" />

`/products/{product_uuid}`


## Requirements

To install this repository locally, you'll need to be running the following:
  - PHP ^8.2
  - composer ^2.0
  - npm ^10

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

### Next Steps

Here are some things that I'd do if I had more time to spend on this project:

1. Create more tests to ensure everything continues to work as planned as the application expands, including tthe frontend of the site.
2. Account for scaling up of the number of warehouses in the system.
3. Make the frontend responsive, and pivot to a reactive framework/use JS to allow for a more dynamic form
4. Create frontend views for orders & warehouses.
