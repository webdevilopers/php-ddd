Feature:
  In order to help me make money
  As a owner
  I need to manage the store

  Background:
    Given 'John' is the store owner
    And 'John' already employs 'Jake' as 'delivery boy'
    And 'John' already employs 'Judy' as 'waitress'
    And 'John' already employs 'Mark' as 'cashier'

  Scenario: Hiring new cashier to help customer pay for meals
    Given 'Jane' postulate on a job offering
    When 'John' hires 'Jane' as the new 'cashier'
    Then 'John' should have 4 employees
    And There should be 2 employees with 'cashier' title
    # todo cashier receives payment from customer for order
    # todo Should be in sale context

  Scenario: Hiring new cook to cook meals
    Given 'Luke' postulate on a job offering
    When 'John' hires 'Luke' as the new 'cook'
    Then 'John' should have 4 employees
    And There should be 1 employees with 'cook' title
    # todo cook prepare order of customer
    # todo Should be in sale context

  Scenario: Hiring new waitress to take order from customer
    Given 'Leia' postulate on a job offering
    When 'John' hires 'Leia' as the new 'waitress'
    Then 'John' should have 4 employees
    And There should be 2 employees with 'waitress' title
    # todo waitress take order from customer (create order)
    # todo Should be in sale context

  Scenario: Hiring new delivery boy to deliver meals
    Given 'Han' postulate on a job offering
    When 'John' hires 'Han' as the new 'delivery boy'
    Then 'John' should have 4 employees
    And There should be 2 employees with 'delivery boy' title
    # todo delivery boy deliver meal to customer
    # todo Should be in shipping context
