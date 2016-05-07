# php-ddd
PHP Symfony Doctrine Domain-driven Design

Dormer Calculation examples:
* https://gist.github.com/webdevilopers/5ac1f30d88102e24df87
* https://gist.github.com/yvoyer/a778ac744ddf10012864
* https://github.com/yvoyer/calculation-example

Feel free to post general questions as an Issue. E.g.:
* https://github.com/yvoyer/calculation-example/issues/2

More examples will be posted in my blog:
* http://blog.webdevilopers.net/category/php/ddd/

## CQRS

### Command

#### Immutable
* https://github.com/matthiasnoback/convenient-immutability @matthiasnoback

## Use case example

Domain requirements:

Mr. Smith is the proud owner of the restaurant Smith's Pizzeria. He wish to have a site to manage it's company and promote it's products on the Web. Here are the requirement he wishes you to implement.

* The owner is the only employee granted to create new or delete recipes.
* Recipes have ingredients that can be categorized with allergens
* a cashier takes the orders of phone, drive through or take out customers
* a delivery boy (or girl) delivers prepared meals to the customers who ordered by phone
* a waitress takes orders to seated clients
* waitress serve the meals to in house customers.
* performance bonus are alloted to each trimester based on waiting time of customers. Lower it is greater the bonus.
* bonus are calculated according to the following chart, based on type of client and average time to serve clients (todo)
* recipes are not available to customers as long as they have not been released.
* recipes can be back ordered which means that no customers can order them.
* retired recipes no longer appears on the menu, they have been removed from production.
* front desk, drive through and in house customers do not keep order history, they are considered anonymous customer, while Web and phone customers are identified with their phone number to track their orders.
* delivery boy pickup the customer order at an hour, and are expected to deliver it in order of priority based on ordered at time.
* Waitress should serve all meals of the customer table at the same time, but for bonus reason, the clock start ticking when the first table customer order is entered to the last meal served
* cashier make the customer pay on order, while delivery boy make them pay when order delivered, and waitress make them pay at end of diner.
