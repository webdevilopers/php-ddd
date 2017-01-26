Feature:
  In order to help me make money
  As a owner
  I need to manage the store

  Background:
    Given 'John' is the store owner
    And 'John' already employs 'Jake' as 'delivery boy'
    And 'John' already employs 'Judy' as 'waitress'
    And 'John' already employs 'Mark' as 'cashier'
    And 'John' already employs 'Esther' as 'cook'
    And 'John' has created the recipe 'All dressed pizza' with price of '10.00$' each
    And 'John' has released the recipe 'All dressed pizza'
    And 'John' has created the recipe 'Small fries' with price of '5.00$' each
    And 'John' has released the recipe 'Small fries'

  Scenario: Hiring new cashier to help customer pay for recipes
    Given 'Jane' postulate on a job offering
    When 'John' hires 'Jane' as the new 'cashier'
    Then 'John' should have 5 employees
    And There should be 2 employees with 'cashier' title
    # todo cashier receives payment from customer for order
    # todo Should be in sale context

  Scenario: Hiring new cook to cook recipes
    Given 'Luke' postulate on a job offering
    When 'John' hires 'Luke' as the new 'cook'
    Then 'John' should have 5 employees
    And There should be 2 employees with 'cook' title
    # todo cook prepare order of customer
    # todo Should be in sale context

  Scenario: Hiring new waitress to take order from customer
    Given 'Leia' postulate on a job offering
    When 'John' hires 'Leia' as the new 'waitress'
    Then 'John' should have 5 employees
    And There should be 2 employees with 'waitress' title
    # todo waitress take order from customer (create order)
    # todo Should be in sale context

  Scenario: Hiring new delivery boy to deliver recipes
    Given 'Han' postulate on a job offering
    When 'John' hires 'Han' as the new 'delivery boy'
    Then 'John' should have 5 employees
    And There should be 2 employees with 'delivery boy' title
    # todo delivery boy deliver recipe to customer
    # todo Should be in shipping context

  Scenario: Cashier serves a phone customer who wishes its order to be delivered
    # todo address must be in range of delivery
    Given 'Billy' never ordered meals to the shop
    And 'Billy' gives his phone number '555-5555' and home address '1 main street'
    When 'Mark' starts the order '333' of 'Billy'
    And 'Billy' order 2 meal 'All dressed pizza' on order '333'
    And 'Billy' order 1 meal 'Small fries' on order '333'
    And 'Mark' confirms that 'Billy' order confirmation number is '333' at '18:00:00'
    And 'Esther' finishes to cook the order '333' at '18:10:00'
    And 'Jake' delivers the order '333' at '18:30:00'
    And 'Billy' pays '12.00$' to 'Jake'
    Then Order '333' should be closed at '18:30:00'
    And The order '333' should have an income of '25.00$'
    And The order '333' should registers a tip of '3.00$'
    And The order '333' should have taken '0:30:00' to complete

#  Scenario: Cashier serves a front desk customer

#  Scenario: Cashier serves a drive-in customer
