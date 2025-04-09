# 🚀 Laravel Starter Project

This repository contains a web application built with **Laravel**, a powerful and elegant PHP framework designed to make web development faster and more enjoyable through clean code, built-in tools, and an expressive syntax.

## 📋 Prerequisites

To run this project locally, you’ll need to install the following tools:

- **[XAMPP](https://www.apachefriends.org/index.html)**: to provide a local Apache server and MySQL database.
- **[Composer](https://getcomposer.org/)**: the dependency manager for PHP.

# Clone the repository
git clone https://github.com/your-username/your-repository.git
cd your-repository

# Install PHP dependencies
composer install

# Copy environment file and configure
cp .env.example .env

# Generate application key
php artisan key:generate

# (Optional) Create database in XAMPP's phpMyAdmin, then update .env file:
# DB_DATABASE=your_database_name
# DB_USERNAME=root
# DB_PASSWORD=

# Run database migrations
php artisan migrate

# Start Laravel development server
php artisan serve

