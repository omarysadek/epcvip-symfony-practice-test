# EPCVIP Symfony practice test

1. (OK) Use latest version of Symfony 4 and install a new application

2. (OK) Create a one-to-many relationship using the following tables:
  
  - Customers (Fields: uuid, firstName, lastName, dateOfBirth, status, createdAt, updatedAt, deletedAt, products).
  
  - Products (Fields: issn, name, status, createdAt, updatedAt, deletedAt, customer).

3. (OK) Create basic CRUD API methods using a RESTful approach. Make sure to authenticate the API requests and implement good Exception handling.

4. (OK) Design and implement the ability of having API requests and responses logged in a file as well as in a database table.

5. (OK) Use Doctrine fixtures to load some sample data

6. (OK) Allowed values on the “status” field: new, pending, in review, approved, inactive, deleted. Please make sure all new records have default values “new”.

7. (OK) Create a Command to look for products on “pending” for a week or more and send some sort of notification.

8. (OK) Implement forms and validation for both entities. (BONUS: or create a single form with prototyping to allow adding multiple products to the customer).

9. (OK) Upload the application to a GitHub repository and share the code with us.

Feel free to use any approach you consider it’s the best and reliable. We encourage you to use the Symfony documentation as your primary resource to accomplish this task.

TODO
- Init database with docker
- instructions : mailtrap.io
- General Exception
- swagger
- tests