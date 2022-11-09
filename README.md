• Clone the repository
> git clone git@github.com:jinxxx666/central_wallet_system.git

• Install all the dependencies using composer
> composer install

• Copy the example env file and make the required configuration changes in the .env file
> cp .env.example .env

• Generate a new application key
> php artisan key:generate

• Run the database migrations (Set the database connection in .env before migrating)
> php artisan migrate

• Start the local development server
> php artisan serve


**POSTMAN**

• REST API route:
>/api/balance

• POST
• PUT
• GET

**_Login_**
>/api/login

**_Register_**
>/api/register
