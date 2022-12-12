# PhpAPI

Simple PHP Api programm that responds in JSON format

## Installation

Place the repository on your webservers http root or vhost directory, and import the `db/phpAPI.sql` file to your database server.
 
## Configuration

In `config.php` change the following lines to your circumstances:
    
```PHP
// Change Database credentials
define('DB_HOST', 'localhost');
define('DB_DATABASE', 'phpAPI');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');

// Change API authorization key
define('API_KEY', "OTvMzrSE,IFgxClMfWFp:=gD~ICRI+ZSN+;vj,T'Lx");
```

## Make a request

Make sure to put your API-Key in the request headers: 
* Key: `X-API-KEY` 
* Value: `OTvMzrSE,IFgxClMfWFp:=gD~ICRI+ZSN+;vj,T'Lx`

### Available routes

* `/products`
  * GET, POST, PATCH, DELETE
* `/users`
  * GET, POST, PATCH, DELETE

Request URL (localhost) for collection of products:  
`http://127.0.0.1/products`

Request URL (localhost) for a specific product:  
`http://127.0.0.1/products/1`  

For POST or PATCH requests make sure to send the data in the request body in JSON format like this:

`Products`
```JSON
{
    "name": "testproduct",
    "size": 42,
    "is_available": 1
}
```
`Users`
```JSON
{
    "username": "testuser",
    "mail": "test@mail.mail",
    "password": "mySecretPassword"
}
```
