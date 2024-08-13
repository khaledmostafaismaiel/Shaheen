<p align="center">
    <img src="public/images/shaheen.png" alt="Shaheen Logo">
</p>

## About Shaheen

Shaheen is a sophisticated web application designed to enhance productivity by seamlessly integrating with Jira instances.
Its primary function is to facilitate the management of active sprints through the generation of Gantt charts,
providing a visual representation of sprint progress and dependencies.

## Tech Stack

- **[Laravel (^11.9)](https://laravel.com/)**
- **[Composer (V2)](https://getcomposer.org/)**
- Mysql (8.0.39)
- PHP (^8.2)
- npm (^10.8.1)

## Essential Packages

- Admin panel **[Filament Panel Builder (^3.2)](https://filamentphp.com/docs/3.x/panels/installation)**
- Gantt chart **[dhtmlxgantt](https://docs.dhtmlx.com/gantt/)**
- Authentication **[laravel/ui (^4.5)](https://github.com/laravel/ui)**

## Features

- Integrate Jira Instances (Server/Cloud Based)
- Assign Teams to Specific Jira Instances
- Establish Boards for Each Team
- Enumerate Active Sprints Within Each Board
- Generate Gantt Charts for Active Sprints
- Display Issues Alongside Their Sub-Tasks
- Enable Drag-and-Drop Functionality for Issue Start and End Date Adjustments
- Set Up Dependencies Among Sub-Tasks

## Installation Steps

Install Dependencies
```bash
composer install
npm install
```

Environment Configuration
```bash
cp .env.example .env # Edit .env to set the environment settings, especially the database configuration.
```

Generate Application Key
```bash
php artisan key:generate
```

Run Migrations
```bash
php artisan migrate
```

Compile Assets
```bash
# Local
npm run dev
```
or
```bash
# Production
npm run build
```

Usage

```bash
# Local
php artisan serve
```
or
```bash
# Production
configuer your web server
```

> **Note:**
> Now you can log in using an existing superuser (username: super@shaheen.com, password: 12345678)
> /login for shaheen login 
> and /admin/login for admin login



