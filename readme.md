# BanguBank

BanguBank is a simple yet functional banking application built using the MVC (Model-View-Controller) architecture. It offers dedicated features tailored for **Admin** and **Customer** roles.

## Features
- **Admin:** Manage and oversee customer accounts, transactions, and banking services.
- **Customer:** Access personal account information, perform transactions, and manage funds efficiently.

## Installation

### Step 1: Clone the Repository
Clone the project from GitHub to your local machine:
```bash
git clone https://github.com/Athiqul/banking-app-mysql
cd banking-app-mysql
```

### Step 2: Configure the Application
Define the necessary configuration settings in the `config/app.php` file:
```php
define('db', 'sql'); // Use 'sql' for MySQL or 'file' for file storage
define('DB_NAME', 'banking_app'); // Database name
define('DB_HOST', 'localhost');   // Database host
define('DB_USER', 'root');        // Database user
define('DB_PASS', '');            // Database password
define('App_Url', 'http://localhost:90/'); // Application base URL
```

### Step 3: Run Database Migrations and Seeding (MySQL)
To set up the database schema and seed initial data, execute the following commands:
1. Run migrations to create the necessary database tables:
   ```bash
   php database/migrate.php
   ```
2. Seed the database with initial data:
   ```bash
   php database/seed.php
   ```
After seeding, use the following credentials for testing:

#### Admin Account
- **Email:** `admin@info.com`
- **Password:** `12345678`

#### Customer Accounts
1. **Email:** `test@info.com`  
   **Password:** `12345678`  
2. **Email:** `jbc.athiqul@gmail.com`  
   **Password:** `12345678`


### Step 4: Start the Server
Run the application using PHP's built-in server:
```bash
php -S localhost:90
```
