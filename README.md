# CoolRockz Web Store

**CoolRockz** is an e-commerce website for selling **Cool Rockz** and **Cool Standz**.

It supports:
- User registration and profile management
- Shopping cart and order processing
- Admin product/user management
- Secure contact messaging
- Product search functionality

---

## Setup Instructions

### Requirements

- PHP (8.0+ recommended)  
- MySQL  
- Apache (e.g., via XAMPP, MAMP)  
- A local environment (e.g., http://localhost/shopping_site)  
- A love of rocks 🪨💖

---

## Folder Structure

Cool-Rockz/
| Path                  | Description                               |
|-----------------------|-------------------------------------------|
| `admin/`              | Admin pages (inventory management, messages) |
| `catalogue/`          | Product catalogue and search pages        |
| `css/`                | Stylesheets                               |
| `images/`             | Product images                            |
| `includes/`           | Header, DB connection, logout logic       |
| `js/`                 | JavaScript for interactivity              |
| `php/`                | Backend form handlers and logic           |
| `account.php`         | User account page                         |
| `admin.php`           | Admin dashboard (admins only)             |
| `cart.php`            | Shopping cart (logged-in users)           |
| `contact.php`         | Contact form (logged-in users)            |
| `index.php`           | Homepage                                  |
| `login.php`           | Login page                                |
| `profile.php`         | Edit user information                     |
| `readme.md`           | Project README file                       |
| `register.php`        | User registration                         |
| `shopping_site.sql`   | MySQL database schema                     |


## Key Components

### Admin Dashboard
Accessible only to logged-in admins.  
Allows:
- Adding, editing, and deleting products
- Managing users
- Viewing contact messages

### Product Pages
Dynamic layout for product categories like `rocks` and `stands`, loaded from the database.

### Cart & Checkout
Cart is stored in the PHP session. Orders are saved to the database on checkout.

---

## Installation Steps

1. Clone or download the project folder.
2. Import `shopping_site.sql` into your MySQL database.
3. (Optional) Update `includes/db.php` with your own database credentials.
4. Start Apache & MySQL using XAMPP, MAMP, or similar.
5. Open your browser and go to:  
   `http://localhost/shopping_site`

---

## Security Measures Implemented

- **Force HTTPS**  
  Ensures all traffic is encrypted.

- **Session Timeout Handling**  
  Automatically logs out users after 20 minutes of inactivity.

- **Session-based Access Control**  
  Validates `$_SESSION['user_id']` and `$_SESSION['is_admin']` on restricted pages.

- **Password Hashing**  
  Uses `password_hash()` to store passwords securely.

- **SQL Injection Protection**  
  All queries use prepared statements (via PDO).

- **CSRF Protection**  
  Tokens are generated and verified for forms that modify data.

- **Output Escaping**  
  Uses `htmlspecialchars()` to prevent XSS when rendering user-submitted content.

---

## Test Accounts


```text
Admin User:
  Email: joejoe@example.com
  Password: Password

Regular User:
  Email: john@example.com
  Password: Password
