
# Employee CRM System

A web-based Employee CRM (Customer Relationship Management) system built using Laravel and Filament. This system provides user-friendly CRUD operations for managing countries, states, cities, departments, and employees.

## 🧩 Features

- Manage hierarchical location data (Country > State > City)
- Create and manage departments
- CRUD interface for employees
- Admin panel powered by Filament
- Modern UI and user experience using Filament Admin Panel

## 🚀 Tech Stack

- Laravel (PHP Framework)
- Filament (Admin Panel)
- MySQL (or your preferred database)
- Tailwind CSS (via Filament)
- PHP 8.1+

## 📦 Installation

Follow the steps below to set up the project locally.

### 1. Clone the repository

```bash
git clone https://github.com/naderelsayedd/employee-CMS.git
cd employee-CMS
```

### 2. Install Dependencies

Make sure you have Composer and PHP installed.

```bash
composer install
```

### 3. Copy .env and Generate App Key

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Update your `.env` file with your local database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. (Optional) Seed the Database

If you have seeders:

```bash
php artisan db:seed
```

### 7. Serve the Application

```bash
php artisan serve
```

Then visit: [http://localhost:8000](http://localhost:8000)

## 🔐 Admin Panel Access

Filament provides an admin interface. After creating a user via `php artisan make:filament-user`, you can access it at:

```
http://localhost:8000/admin
```

## 🗂️ CRUD Modules

- Country
- State
- City
- Department
- Employee

Each module is available via the Filament Admin interface for easy management.

---

## 📬 Contribution

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## 📄 License

This project is open-source and available under the MIT License.
