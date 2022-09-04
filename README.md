# Restaurant/Snooker Club Management System

[![GitHub Stars](https://img.shields.io/github/stars/IlyasKohistani/laravel-snooker.svg)](https://github.com/IlyasKohistani/laravel-snooker/stargazers) [![GitHub Issues](https://img.shields.io/github/issues/IlyasKohistani/laravel-snooker.svg)](https://github.com/IlyasKohistani/laravel-snooker/issues) [![Current Version](https://img.shields.io/badge/version-1.0.0-green.svg)](https://github.com/IlyasKohistani/laravel-snooker)

A management system built for snooker club. You can manage all your users, products, orders, tables, users, and income. You can have a graphical beautiful report with multiple options Yearly, Monthly, and Daily. You can use the same system for a restaurant and ignore snooker tables. You are 100% allowed to use this webpage for both personal and commercial use, but NOT to claim it as your own. 


![Snapshot](https://github.com/IlyasKohistani/laravel-snooker/blob/main/public/img/snapshot.png)

---

## Buy me a coffee

Whether you use this project, have learned something from it, or just like it, please consider supporting it by buying me a coffee, so I can dedicate more time on open-source projects like this :)

<a href="https://www.buymeacoffee.com/ilyaskohistani" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: auto !important;width: auto !important;" ></a>

---

## Features

-   User Management
-   Users Group Management
-   Products Management
-   Product's Categories Management
-   Table Management
-   Store Management
-   Order Management
-   Graphical Reporting

---

## Setup

-   After you clone this repo to your desktop, go to its root directory using `cd laravel-snooker` command on your cmd or terminal.
-   run `composer install` on your cmd or terminal to install dependencies.
-   Copy .env.example file to .env on the root folder using `copy .env.example .env` if using command prompt Windows or `cp .env.example .env` if using terminal, Ubuntu.
-   Open your .env file and change the database name (DB_DATABASE) to whatever you have, Username (DB_USERNAME), and Password (DB_PASSWORD) fields correspond to your configuration.
-   Run `php artisan key:generate` to generate new key.
-   Run `php artisan migrate:fresh` to publishe all our schema to the database and seed your database.
-   Run `php artisan serve` to start project.
-   Open http://localhost:8000/ in your browser.

---

## Usage

After you are done with the setup open http://localhost:8000/ in your browser. You can play with it and change anything you want. Enjoy!

---

## License

> You can check out the full license [here](https://github.com/IlyasKohistani/laravel-snooker/blob/master/LICENSE)
> This project is licensed under the terms of the **MIT** license.
