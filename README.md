# CampusConnect — College Event Management System

A beginner-friendly Web Technology mini project using HTML, CSS, JavaScript, PHP, MySQL, and XAMPP. It does not use a separate API, React, or Node.js.

## Features
- Home page with event cards
- Events page with JavaScript search and category filter
- Student event registration saved to MySQL
- Admin page to add/delete events and view registrations
- Responsive CSS styling

## Run with XAMPP
1. Install and open XAMPP.
2. Start **Apache** and **MySQL**.
3. Copy the `CampusConnect` folder into `C:\xampp\htdocs\`.
4. Open `http://localhost/phpmyadmin`.
5. Choose **Import**, select `database.sql`, and click **Go**.
6. Open `http://localhost/CampusConnect/`.

## Database settings
The default local XAMPP settings are in `db.php`:
- host: `localhost`
- username: `root`
- password: empty
- database: `campusconnect`

If your MySQL password is different, update `db.php`.

## Important learning/demo note
This is a classroom prototype. The admin page is not protected with a login, so do not deploy it publicly as-is. A production version should add admin authentication, CSRF protection, and stricter validation.
