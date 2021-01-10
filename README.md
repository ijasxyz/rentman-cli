# Rentman CLI

## Prerequisites

* PHP > 7.4
* MySQL 5.7
* Composer

## Getting started

### Install project

1. `git clone git@github.com:ijasxyz/rentman-cli.git`
2. `cd rentman-cli`
3. `cp .env.example .env`
4. Create new database
5. Update the database credentials in the `.env`
6. `composer install`
7. `php rentman-cli db:seed`
8. `php rentman-cli migrate`

### Seed additional data (Optional)

1. Seed 100 thousand equipments : `NUMBER_OF_RECORDS=100000 php rentman-cli db:seed --class=EquipmentSeeder`

2. Seed 1 million planning : `NUMBER_OF_RECORDS=1000000 php rentman-cli db:seed --class=PlanningSeeder`

### Check equipment availability

* `php rentman-cli equipment:availability`

### Check equipment shortage

* `php rentman-cli equipment:shortage`

## Assumptions
* Since the time is not involved in the `start` date & `end` date of `planning`, the equipment returned will be available in stocks on the next day of `end` date.

## Improvements
* Indexed the following columns to improve the query performance & tested with **100 thousand equipment**  and **1 million planning** records.
    * `equipment.stock`
    * `planning.equipment`
    * `planning.quantity`
    * `planning.start` & `planning.start`
    
  


