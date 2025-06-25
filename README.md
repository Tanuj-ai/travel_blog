# Travel Blog - Laravel Project

A modern travel blog application built with Laravel 12, featuring destination information, weather integration, and more.

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM (or Bun)
- SQLite (default) or other database system

## Installation

### Option 1: Standard Installation

1. Clone the repository:
   ```
   git clone <repository-url>
   cd <project-folder>
   ```

2. Install PHP dependencies:
   ```
   composer install
   ```

3. Install JavaScript dependencies:
   ```
   npm install
   ```

4. Create environment file:
   ```
   cp .env.example .env
   ```

5. Generate application key:
   ```
   php artisan key:generate
   ```

6. Create SQLite database:
   ```
   touch database/database.sqlite
   ```

7. Run migrations and seed the database:
   ```
   php artisan migrate --seed
   ```

8. Build assets:
   ```
   npm run build
   ```

9. Start the development server:
   ```
   composer run dev
   ```

### Option 2: Using Laravel Herd (macOS/Windows)

1. Install [Laravel Herd](https://herd.laravel.com/) for your operating system
2. Clone the repository into your Herd parked directory:
   ```
   cd ~/Herd  # macOS
   # or
   cd %USERPROFILE%\Herd  # Windows
   
   git clone <repository-url>
   cd <project-folder>
   ```

3. Follow steps 2-8 from the standard installation
4. Open the site in your browser:
   ```
   herd open
   ```

### Option 3: Using Laravel Sail (Docker)

1. Clone the repository and navigate to the project folder
2. Install Sail:
   ```
   composer require laravel/sail --dev
   php artisan sail:install
   ```

3. Start Sail:
   ```
   ./vendor/bin/sail up -d
   ```

4. Run the remaining setup commands with Sail:
   ```
   ./vendor/bin/sail artisan key:generate
   ./vendor/bin/sail artisan migrate --seed
   ./vendor/bin/sail npm install
   ./vendor/bin/sail npm run build
   ```

## Development

Start all development services with a single command:
```
composer run dev
```

This will concurrently run:
- Laravel development server
- Queue worker
- Log viewer (Laravel Pail)
- Vite development server

## Admin Access

Default admin credentials:
- Email: yamansharmarakta@gmail.com
- Password: 123456789

## Features

- Destination information for popular travel locations
- Weather integration
- Responsive design with Tailwind CSS
- Alpine.js for interactive UI components

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).