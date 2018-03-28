# Polling System
Realization of little polling-system using with my own micro php-framework.

# Task
Develop the system for creating and managing polls on any themes. 
Every poll can have non-limited count of questions, every question can have non-limited count of variants of answers.
Question can accept only one answer or several.

Polls can be in next statuses: draft, active or closed.
Only drafts can be edited from admin panel.
Any time only one poll can be in status active. Users see the active poll on home page and can answer on it.

After answering users can see results of the active poll. Administrator also can see results of closed polls.
Results shows how many people choose different variants of answers in poll.

Administrator can filter the results by any variants of answers.
For example, he can get answers only of users, who choose gender "male" and age "20-30".

# Realization
The main condition of this task - don't use any frameworks. I had to create my own micro framework.

First, in index.php, loading of AutoloaderClass who can search others classes by its namespace and name.

Second, loading of Container class, which realizes pattern singleton. It's my attempt to realize dependency inversion principe.

Then, the application gets exemplar of Request class and finds Controller which can to handle this request.

My framework realizes MVC structure. Connection to database is incapsulate in QueryBuilder class.
I didn't have much time to create true ORM and I tried to hide SQL queries in Repository layer.

My framework also has a system for requests validation.
