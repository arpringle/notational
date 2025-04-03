# Notational: The Simple, Insecure-by-Design Note-Sharing Platform

## What is Notational?  
Notational is a lightweight web app where users can create and share text-based notes under a **6-character code** of their choice. Anyone who enters the same code can see and edit the notes associated with it—**no logins or accounts needed**.

---
**WARNING!** Notational is intentionally ***NOT SECURE***. Anyone with the same code as you can find your notes. All notes should be considered to be public; people can guess or brute-force your code!
---

## Features  
- Instantly create and edit notes under a shared code
- No accounts or authentication required  
- Simple, fast, and intentionally insecure  
- Self-hostable with minimal setup  

At this time, Notational does not support real-time collaboration on notes.

##  Requirements  
To run Notational, you need:  

- **PHP 7.4+** (or newer)  
- **MySQL 8/ MariaDB** (or another SQL database)  
- A web server (Apache, Nginx, or built-in PHP server)  


## Installation

### 0. Setup

- Be sure to install the dependencies.
- If using multiple domains on the server, be sure to set up the associated Virtual Hosts (Apache) or Server Blocks (Nginx). Point the configuration towards the directory where you intend to install Notational.

The web server configuration is mostly oustside the scope of this guide.

### 1. Clone the Repository

`cd` into the directory you wish to install Notational inside of. Then, run the following commands:

```bash
git clone https://github.com/arpringle/notational.git
cd notational
```

### 2. Set Up the Database

First, enter the database shell by invoking its command. Typically, simply typing `mysql` into the terminal will do the trick.

The easiest way to setup the database is by using the included setup SQL script instead. If you are in the `notational` directory you cloned earlier, you should be able to run `@setup.sql` inside the database shell to setup the database.

Otherwise, you can set up the database manually by copying and pasting the following into the database shell to create the Notational database:

```sql
CREATE DATABASE notational;
USE notational;

CREATE TABLE notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(6) NOT NULL CHECK (code REGEXP '^[A-Z0-9]{6}$'),
    title VARCHAR(255) NOT NULL,
    contents TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modified_at TIMESTAMP NOT NULL
);

CREATE INDEX idx_code ON notes(code);
```

### 3. Create a Database User

For security purposes, we don't want the Notational application to use the database root user account. Instead, we will create a user for Notational. To do so, we need a *username* and a *password*. ***BE SURE TO USE A STRONG PASSWORD!*** Once you have decided on a username and password, run the following inside the database shell, replacing "username" and "password" with your credentials:

```sql
CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
```

For example, if I wanted to name my user notational_user and my password was 1234 (a terrible password), the command would be:

```sql
CREATE USER 'notational_user'@'localhost' IDENTIFIED BY '1234';
```

Then we have to grant our user the ability to manipulate the Notational database:

```sql
GRANT INSERT, UPDATE, DELETE, SELECT ON notational TO 'username'@'localhost';
```

Exit the database shell:

```sql
EXIT
```

### 4. Configure the Database Connection
Rename `config.example.php` to `config.php` and update the example database credentials to the ones you just set up:
  
```php
<?php
$DB_HOST = "localhost";
$DB_USER = "username";
$DB_PASS = "password";
$DB_NAME = "notational";
?>
```

### 5. Use the app!

If you did all the steps correctly, navigating to the site's web address should now display the Notational home page.

## Usage  
1. Visit the homepage and enter any **6-character** code.
2. If no notes exist for that code, you can create new ones.  
3. If notes already exist, you can view and edit them.  
4. Share the code with others to collaborate!  

## Disclaimer  
To reiterate; Notational is **insecure by design**—anyone with the same code can view or edit notes. **Do not store sensitive information.**  

## License
This project is licensed under the GNU General Public License, Version 3 or later.