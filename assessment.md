# Availability assessment
  
One of the core activities of Rentman customers is renting out equipment. Two key questions Rentman helps answering are:

- Is the equipment the customer want to hire available in a certain period?
- Where in the planning are equipment shortages (more planned than the stock)?

The goal of this assignment is to write PHP code that is able to answer those questions. 

## Database

Together with this assessment you get a sql file with the current equipment planning of a company. The database consists of two tables:
  
equipment
- id         (int)      Primary key
- name       (text)     The name of the equipment
- stock      (int)      How much the company has of a certain equipment
  
planning:
- id         (int)      Primary key
- equipment  (int)      Refers to the equipment table
- quantity   (int)      How many items are planned in this timeframe
- start      (datetime) When is the start of the rental period
- end        (datetime) When does the equipment come back


## Assessment

The goal of this assessment is to write PHP code that is able to do answer the two questions listed before. These
questions are formulated as two methods in the attached EquimentAvailabilityHelper classas first class of your project. 
The goal of this assessment is to implement those methods:

`isAvailable` 
This method should find out if the quantity asked for is available in the period passed in the parameters.

`getShortages`
This method should find all shortages in the passed period.

 
An item is short if the number of items planned at the same moment exceeds the number of items in stock (stock 
field in equipment table). The shortage in a given time period `p` for one equipment item `m` is defined as stock minus 
the maximum concurrent planned items in that period.

## Important notes


- If anything is unclear, just ask!
- Focus on the code that is aked for (implement the class and the functions). Do not spend time in putting it in docker
  containers or frameworks. Leave all the logic related to the logic of calculating shortage within the given class. It 
  is no problem to create additional methods.
- Don't spend time on UI, it is a back-end assessment. You can just create a script where you do some fixed calls to the 
  methods  you need to implement or pass the values via the url.
- Think about how you do it, considering that a real database would have way more records (efficiency)
- If you want to make changes to the database of see how we can improve things there, just do it and describe very 
  quickly what/why