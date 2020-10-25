




# EPCVIP Symfony practice test

## Summary

- [*About*](#about)
- [*Instruction*](#instruction)
- [*Parameters*](#parameters)
- [*Todo List*](#todo-list)

## About

1. Use latest version of Symfony 4 and install a new application

2. Create a one-to-many relationship using the following tables:
  
  - Customers (Fields: uuid, firstName, lastName, dateOfBirth, status, createdAt, updatedAt, deletedAt, products).
  
  - Products (Fields: issn, name, status, createdAt, updatedAt, deletedAt, customer).

3. Create basic CRUD API methods using a RESTful approach. Make sure to authenticate the API requests and implement good Exception handling.

4. Design and implement the ability of having API requests and responses logged in a file as well as in a database table.

5. Use Doctrine fixtures to load some sample data

6. Allowed values on the “status” field: new, pending, in review, approved, inactive, deleted. Please make sure all new records have default values “new”.

7. Create a Command to look for products on “pending” for a week or more and send some sort of notification.

8. Implement forms and validation for both entities. (BONUS: or create a single form with prototyping to allow adding multiple products to the customer).

9. Upload the application to a GitHub repository and share the code with us.

Feel free to use any approach you consider it’s the best and reliable. We encourage you to use the Symfony documentation as your primary resource to accomplish this task.

## Instruction

running locally with docker-compose

```
sudo docker-compose up;
```

## Parameters

#### website

| Application     | Port | Internal Port | URL                               |
|-----------------|------|---------------|-----------------------------------|
| api             | 80   | 80            | http://127.0.0.1/                 |
| mysql           | 3306 | 3306          | 127.0.0.1                         |
| adminer         | 8080 | 8080          | http://127.0.0.1:8080/            |

#### Mailtrap

| Field       | Value                         |
|-------------|-------------------------------|
| URL         | https://mailtrap.io/          |
| Username    | omar.ysadek@gmail.com         |
| Password    | app123                        |


#### Database

| Field       | Value        |
|-------------|--------------|
| System      | MySQL 8      |
| Server/IP   | mysql        |
| Username    | root         |
| Password    | 123          |
| Database    | dev          |


Then upload it here : https://app.vagrantup.com/
## Todo Lis

- General Exception
- swagger
- tests