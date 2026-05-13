🍔 Fast Food Simple (Grocery Ordering App)
A PHP-based grocery/fast food ordering system featuring user accounts, cart logic, admin tools, and unit-tested backend classes.

This project originally began as a simple fast‑food ordering demo, but over time it evolved into a more complete grocery-style ordering system. The repo name reflects the original concept.

⭐ Overview
This is a procedural + object‑oriented PHP application that uses:

standalone PHP pages for each feature (index.php, cart.php, login.php, etc.)

reusable backend classes in src/Classes

shared form templates in src/forms

layout/partials in includes

PHPUnit tests in src/tests

The app simulates a real ordering workflow: users can register, log in, browse items, add them to a cart, and place orders. Admins can manage menu items and types.

🔧 Tech Stack
Languages
PHP

JavaScript

SQL

HTML

CSS

Backend
Sessions for authentication + cart

Password hashing

Prepared statements

Input sanitization

Validation

Cron job email script (SendGrid originally, being replaced)

Database abstraction via custom classes

External API integration (Random Meal API)

Frontend
Bootstrap for layout + styling

DOM Manipulation with vanilla JavaScript

Vue.js (light usage for the grocery add form)

Responsive UI components

Form templates in src/forms

Testing
PHPUnit

Unit tests for:

Cart

Menu

Password

Query

RandomMeal (API wrapper tests)

User

📂 Project Structure
Code
.
├── includes/              # Shared layout + message partials (header, footer, nav, messages)
├── src/
│   ├── Classes/           # Core backend classes (Cart, User, Menu, Database, Email, etc.)
│   └── forms/             # Form templates used by main pages
├── tests/                 # PHPUnit tests
├── images/                # Product images
├── js/                    # Frontend JavaScript
├── add_item.php           # Admin: add menu item
├── cart.php               # Cart page
├── index.php              # Home page
├── login.php              # Login page
├── logout.php             # Logout handler
├── register.php           # Registration page
├── summary.php            # Order summary
├── types.php              # Manage item types
├── vue_groceries_add.php  # Vue.js-based add form (experimental)
├── cron_job_email.php     # Cron job for sending emails
├── database_seed.sql      # Seed data
└── .env_example           # Example environment config
📦 Features
User Features
Add items to your personal cart

Two different ways to search for items

Update quantities in the cart

Remove items from the cart

Purchase items (logged in the database with user, price, and date)

Password recovery emails (currently being updated)

Generate random meals using an external API

Admin Features
All user features

Add/Edit/Delete items

Add/Edit/Delete types

Security
URL manipulation protections

Admins cannot delete types that are in use

Admins cannot delete items that exist in user carts

HTTPS enabled on production domain

Sanitized input

Prepared SQL statements

Password hashing

🧠 Architecture Style
This project is not MVC and does not use controllers or a router.

Instead, it uses:

Page-based routing (each feature is its own PHP file)

Object-oriented backend classes for reusable logic

Form partials to avoid duplicated markup

Includes for shared layout

Unit tests for backend reliability

It’s a natural evolution from simple PHP scripts into a more structured maintainable application.

📝 Email Note
The project originally used SendGrid for password reset and order emails.
Due to SendGrid’s API changes, email functionality is currently being refactored and will be replaced with Resend API.

🚀 Future Improvements
Replace SendGrid with Resend

Add order history

Add product categories

Improve UI styling

Add search + filtering

Add admin dashboard

Expand API usage (Random Meal API)

📫 Contact
GitHub: https://github.com/KizeKaze

LinkedIn: https://www.linkedin.com/in/raymond-williams-16405a242/

Email: Ray337@pm.me

Portfolio: (Rebuilding)
