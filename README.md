




# EPCVIP Symfony practice test

## Summary

- [*About*](#about)
- [*Instruction*](#instruction)
- [*Parameters*](#parameters)
- [*Curl exemples*](#curl)
- [*Todo List*](#todo)

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

running locally with docker-compose (will initiate the project automatically)

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

#### API Authentication credential 

| Field       | Value                         |
|-------------|-------------------------------|
| URL         | http://localhost/login        |
| Username    | app                           |
| Password    | 123                           |

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

## Curl

- Authentication: /login (POST)

```
curl --location --request POST 'http://localhost/login' \
--header 'Content-Type: application/json' \
--data-raw '{
    "username": "app",
    "password": "123"
}'
```
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDM2NTMyODAsImV4cCI6MTYwMzY1Njg4MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYXBwIn0.pArjDUV5ciFMf7AHctcLMxSfYfcxrg4g7A_IjqNTLRoTSF6l10qRV1sWXzha961h24Lslc1cIKeZLmpTWDHTefdztFK2mbtbsq_tAmDcy41BBJ4hUDTvylDL3hopcQQhLuEOLIwpyad7sJlk1Ny9IvBpHz_IH_B9_hr-BVlpH0YwXDbGLiTf5dfAJUY66GCXn2KYtG01yLjjVHTxnlP5uo9Cx_rg_6Ilk7ay6JHBPLmzlGB-1SkfRRSXesmdiTxJcqlUQ_Qhitur5IzhrZCBNWL7Pi_gKKi8xUdCvRsf_hy2PfU3wYh9q-RjrqGIsFlYfV7q--Mf77y1Ibt-3DqrtkEymc-MyVbOeVDIfB3V8hMH2Usd19zmCuoCUy3SalNo6nFFI0f0lpHH7Xvxyj4_9tu3kwysttkxy43tuhSgJtlR5ZwIZJuGZog_HmhLAGnWv0a_M9pHckzAXxo29oXf8G3VrWekLDTyWQSJqniqc3jtGz-vMeRBHqo93yoOe-3eHsUPPwXGRV4aGsE3vLXiznnzklK4ZmfYCN28NbiRWSfPVR7deuZSMkZeQmqCbVEETbMaq3TbZBtVtBb9BU5gETDjKmrQta5gXVwlQIbDJ1vN_KHd4krldvSjMxT0j6lb2l09FmvbOEDEvdnNY5RL_FzwBI2V5B7i5_b1y68gWcw"
}
```

- New Customer: http://localhost/customers (POST)

```
curl --location --request POST 'http://localhost/customers' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDM2NTMyODAsImV4cCI6MTYwMzY1Njg4MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYXBwIn0.pArjDUV5ciFMf7AHctcLMxSfYfcxrg4g7A_IjqNTLRoTSF6l10qRV1sWXzha961h24Lslc1cIKeZLmpTWDHTefdztFK2mbtbsq_tAmDcy41BBJ4hUDTvylDL3hopcQQhLuEOLIwpyad7sJlk1Ny9IvBpHz_IH_B9_hr-BVlpH0YwXDbGLiTf5dfAJUY66GCXn2KYtG01yLjjVHTxnlP5uo9Cx_rg_6Ilk7ay6JHBPLmzlGB-1SkfRRSXesmdiTxJcqlUQ_Qhitur5IzhrZCBNWL7Pi_gKKi8xUdCvRsf_hy2PfU3wYh9q-RjrqGIsFlYfV7q--Mf77y1Ibt-3DqrtkEymc-MyVbOeVDIfB3V8hMH2Usd19zmCuoCUy3SalNo6nFFI0f0lpHH7Xvxyj4_9tu3kwysttkxy43tuhSgJtlR5ZwIZJuGZog_HmhLAGnWv0a_M9pHckzAXxo29oXf8G3VrWekLDTyWQSJqniqc3jtGz-vMeRBHqo93yoOe-3eHsUPPwXGRV4aGsE3vLXiznnzklK4ZmfYCN28NbiRWSfPVR7deuZSMkZeQmqCbVEETbMaq3TbZBtVtBb9BU5gETDjKmrQta5gXVwlQIbDJ1vN_KHd4krldvSjMxT0j6lb2l09FmvbOEDEvdnNY5RL_FzwBI2V5B7i5_b1y68gWcw' \
--header 'Content-Type: application/json' \
--header 'Cookie: sf_redirect=%7B%22token%22%3A%225708aa%22%2C%22route%22%3A%22app_customer_new%22%2C%22method%22%3A%22POST%22%2C%22controller%22%3A%7B%22class%22%3A%22App%5C%5CController%5C%5CCustomerController%22%2C%22method%22%3A%22new%22%2C%22file%22%3A%22%5C%2Fvar%5C%2Fwww%5C%2Fsrc%5C%2FController%5C%2FCustomerController.php%22%2C%22line%22%3A38%7D%2C%22status_code%22%3A201%2C%22status_text%22%3A%22Created%22%7D' \
--data-raw '{
    "firstName": "Omar",
    "lastName": "SADEK",
    "dateOfBirth": "1988-07-22"
}'
```
```
{
    "data": {
        "uuid": "3e58db1e-16f7-11eb-944f-0242ac130005",
        "firstName": "Omar",
        "lastName": "SADEK",
        "dateOfBirth": "1988-07-22T00:00:00+00:00",
        "status": "new",
        "createdAt": "2020-10-25T19:21:12+00:00",
        "updatedAt": "2020-10-25T19:21:12+00:00",
        "deletedAt": null,
        "products": []
    }
}
```

- New Product: http://localhost/products (POST)
```
curl --location --request POST 'http://localhost/products' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2MDM2NTMyODAsImV4cCI6MTYwMzY1Njg4MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYXBwIn0.pArjDUV5ciFMf7AHctcLMxSfYfcxrg4g7A_IjqNTLRoTSF6l10qRV1sWXzha961h24Lslc1cIKeZLmpTWDHTefdztFK2mbtbsq_tAmDcy41BBJ4hUDTvylDL3hopcQQhLuEOLIwpyad7sJlk1Ny9IvBpHz_IH_B9_hr-BVlpH0YwXDbGLiTf5dfAJUY66GCXn2KYtG01yLjjVHTxnlP5uo9Cx_rg_6Ilk7ay6JHBPLmzlGB-1SkfRRSXesmdiTxJcqlUQ_Qhitur5IzhrZCBNWL7Pi_gKKi8xUdCvRsf_hy2PfU3wYh9q-RjrqGIsFlYfV7q--Mf77y1Ibt-3DqrtkEymc-MyVbOeVDIfB3V8hMH2Usd19zmCuoCUy3SalNo6nFFI0f0lpHH7Xvxyj4_9tu3kwysttkxy43tuhSgJtlR5ZwIZJuGZog_HmhLAGnWv0a_M9pHckzAXxo29oXf8G3VrWekLDTyWQSJqniqc3jtGz-vMeRBHqo93yoOe-3eHsUPPwXGRV4aGsE3vLXiznnzklK4ZmfYCN28NbiRWSfPVR7deuZSMkZeQmqCbVEETbMaq3TbZBtVtBb9BU5gETDjKmrQta5gXVwlQIbDJ1vN_KHd4krldvSjMxT0j6lb2l09FmvbOEDEvdnNY5RL_FzwBI2V5B7i5_b1y68gWcw' \
--header 'Content-Type: application/json' \
--header 'Cookie: sf_redirect=%7B%22token%22%3A%2261140f%22%2C%22route%22%3A%22app_product_new%22%2C%22method%22%3A%22POST%22%2C%22controller%22%3A%7B%22class%22%3A%22App%5C%5CController%5C%5CProductController%22%2C%22method%22%3A%22new%22%2C%22file%22%3A%22%5C%2Fvar%5C%2Fwww%5C%2Fsrc%5C%2FController%5C%2FProductController.php%22%2C%22line%22%3A38%7D%2C%22status_code%22%3A201%2C%22status_text%22%3A%22Created%22%7D' \
--data-raw '{
    "issn": "1c34-o421",
    "name": "my product",
    "status": "pending",
    "customer": "3e58db1e-16f7-11eb-944f-0242ac130005"
}'
```
```
{
    "data": {
        "id": 7,
        "issn": "1c34-o421",
        "name": "my product",
        "status": "pending",
        "createdAt": "2020-10-25T19:22:29+00:00",
        "updatedAt": "2020-10-25T19:22:29+00:00",
        "deletedAt": null,
        "customer": {
            "uuid": "3e58db1e-16f7-11eb-944f-0242ac130005",
            "firstName": "Omar",
            "lastName": "SADEK",
            "dateOfBirth": "1988-07-22T00:00:00+00:00",
            "status": "new",
            "createdAt": "2020-10-25T19:21:12+00:00",
            "updatedAt": "2020-10-25T19:21:12+00:00",
            "deletedAt": null
        }
    }
}
```


## Todo

- General Exception
- swagger
- tests
