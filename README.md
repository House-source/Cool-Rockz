# CoolRockz Web Store

CoolRockz is an e-commerce website for selling Cool Rockz and Cool Standz.
It supports user registration/modification, shopping cart functionality, admin product management, secure contact messaging, and search.


Setup Instructions.

Requirements:

PHP (8.0+ recommended)
MySQL
Apache (e.g., via XAMPP, MAMP)
A local environment (e.g., http://localhost/shopping_site)
A love of rocks


Folder Structure:

shopping_site/
│
├── admin/           			# Admin pages (manage inventory form front-end, view messages)
├── catalogue/           		# Full catalogue with search
├── css/                 		# Stylesheet
├── images/           			# Image files
├── includes/            		# Header, database connection, logout
├── js/                  		# JavaScript for interactivity
├── php/                 		# Backend scripts (form handlers, delete logic)
├── account.php            		# Account page to track orders/view history (registered users only) 
├── admin.php            		# Admin dashboard (Admin only)
├── cart.php					# Shopping cart page (registered users only) 
├── contact.php					# Contact form (registered users only) 
├── index.php            		# Homepage
├── login.php 					# Login for existing users
├── profile.php					# Edit user information
├── readme.md					 
├── register.php 				# Register new users
├── shopping_site.sql           # MySQL database


Key Components:

- Admin Dashboard
  Accessible only to logged-in admins. Allows adding and editing products and users. Also viewing users' messages.

- Product Pages
  Uses dynamic layout for product categories (rocks, stands, etc.) fetched from the DB.

- Cart & Checkout
  Stores cart in session and processes order creation in the database.


Installation Steps:

Clone or download the project folder.
Import the shopping_site.sql database into MySQL.
Update includes/db.php with your database credentials. (optional, database is initialized with user and credentials are included in includes/db.php)
Start Apache & MySQL in XAMPP (or similar).
Access via https://localhost/shopping_site.


Security Measures Implemented:

- Force HTTPS: Ensures all traffic is encrypted via HTTPS.
- Session Timeout Handling: Automatically logs out inactive users after 20 minutes.
- Session-based Access Control: Authenticated pages check $_SESSION['user_id'] and/or $_SESSION['is_admin'] before granting access.
- Password Hashing: All user passwords are hashed using password_hash() before storage.
- SQL Injection Protection: All database queries use prepared statements.
- CSRF Protection: Tokens are generated and verified for all form submissions that change data.
- Output Escaping: Data rendered from the database is sanitized using htmlspecialchars() to prevent XSS.