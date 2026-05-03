# Finance Management System

A lightweight, full-stack web application designed to help users track their income and expenses, manage their financial profiles, and analyze their spending habits.

## 🚀 Features

- **Secure User Authentication**: Registration and login with hashed passwords.
- **Transaction Tracking**: Easily add, edit, and delete daily income and expenses.
- **Dashboard & Analytics**: Visualize your financial standing.
- **Data Export**: Export your transaction history directly to CSV.
- **Profile Management**: Keep your user profile up to date.

## 🛠️ Tech Stack

- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Backend**: PHP
- **Database**: MySQL

## ⚙️ Local Setup Instructions

1. Clone this repository:
   ```bash
   git clone https://github.com/yourusername/finance-management-system.git
   ```
2. Move the project folder to your local server directory (e.g., `C:\xampp\htdocs\` for XAMPP).
3. Start **Apache** and **MySQL** via your XAMPP Control Panel.
4. Create a MySQL database named `finance_management`.
5. Import the provided `database.sql` file into your newly created database. *(Note: Make sure to create this file from your phpMyAdmin!)*
6. Update `php/db.php` if your local database credentials differ from the defaults.
7. Open your browser and navigate to `http://localhost/finance-management-system`.

## 🛡️ Security

This project implements standard security practices including:
- Prepared statements (`mysqli_stmt`) to prevent SQL Injection.
- Password hashing using `password_hash()` and `password_verify()`.
