# basket
Just an exercise 
It is just an exercise.

# Docker

Run docker-compose
/usr/local/bin/docker-compose -f docker-compose.yml up -d


## Installation

Use composer install inside the docker /var/www/html# composer install
```bash
composer install
```

## Usage

localhost:8080
```
composer test
```
```php
   $basketToken = '123'; // from db, from sessions...
   $customer = new Customer(1, 'Larissa', 12); // or get it from the db
   $product =new Product('P001', 'Photography Package', 200);
    //create a basket
   $basket = new Basket($basketToken, $customer, new OfferForContractLength);
   //add to the basket
   $basket->add($product, 1);
  //remove from the basket
   $basket->remove($product);
  //total to pay
  $basket->getTotalAmount();
    
```
more in tests
