# epcvip-symfony-practice-test

1. Use latest version of Symfony 4 and install a new application

2. Create a one-to-many relationship using the following tables:
  a. Customers (Fields: uuid, firstName, lastName, dateOfBirth, status, createdAt, updatedAt, deletedAt, products).
  b. Products (Fields: issn, name, status, createdAt, updatedAt, deletedAt, customer).

3. Create basic CRUD API methods using a RESTful approach. Make sure to authenticate the API requests and implement good Exception handling.

4. Design and implement the ability of having API requests and responses logged in a file as well as in a database table.

5. Use Doctrine fixtures to load some sample data

6. Allowed values on the “status” field: new, pending, in review, approved, inactive, deleted. Please make sure all new records have default values “new”.

7. Create a Command to look for products on “pending” for a week or more and send some sort of notification.

8. Implement forms and validation for both entities. (BONUS: or create a single form with prototyping to allow adding multiple products to the customer).

9. Upload the application to a GitHub repository and share the code with us.

Feel free to use any approach you consider it’s the best and reliable. We encourage you to use the Symfony documentation as your primary resource to accomplish this task.
