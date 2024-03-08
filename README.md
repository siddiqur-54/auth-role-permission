# Laravel Project with Breeze and Spatie Permission Package
This Laravel project implements authentication using Laravel Breeze and role-based access control using Spatie Permission package. It allows you to manage users, roles, and permissions in your application.

## Getting Started
Follow these instructions to get a copy of the project running on your local machine.

### Prerequisites
Before you begin, make sure you have the following installed on your machine:
- PHP (>= 7.4)
- Composer
- Node.js (with npm or yarn)
- MySQL or any other database supported by Laravel

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/yourusername/auth-role-permission.git
2. **Navigate into the project directory:**
   ```bash
   cd auth-role-permission

3. **Install PHP dependencies:**
   ```bash
   composer install

4. **Install JavaScript dependencies:**
   ```bash
   npm install

5. **Create a copy of the .env.example file and rename it to .env:**
   ```bash
   cp .env.example .env

6. **Generate an application key:**
   ```bash
   php artisan key:generate

7. **Configure your database connection in the .env file:**
   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_username
   DB_PASSWORD=your_database_password

8. **Run database migrations and seed the database:**
   ```bash
   php artisan migrate --seed

9. **Start the Laravel development server:**
   ```bash
   php artisan serve

### Default User Credentials
After seeding the database, a default admin user is created with the following credentials:
- Email: admin@example.com
- Password: password
