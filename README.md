# Mealing

![laravel tests workflow](https://github.com/JustinByrne/Mealing/actions/workflows/laravel_phpunit.yaml/badge.svg) ![GitHub](https://img.shields.io/github/license/JustinByrne/Mealing)

A simple Laravel application to allow users to add recipes, and create generated menus for a week. With the menu this can also produce a list of all ingredients needed for the week of recipes that can be used as a shopping list.

## Installation

1. Download the latest release
   - `git clone https://github.com/JustinByrne/Mealing.git`
2. Within the new directory run the following
   1. `composer install`
   2. `cp .env.example .env`
   3. `php artisan key:generate`
   4. `php artisan storage:link`
   5. `php artisan migrate`

During the installation process an admin account is created, this account has all permissions by default and any new ones as they are created.

email: `admin@example.com`<br>
password: `password`

> It is advised that these details are changed straight after installation.

## New registrations

> While the application is currently work in progress (WIP) all new registrations need to be approved before they can login.

During User registration the User will need to verify thier email address prior to being allowed to login.
