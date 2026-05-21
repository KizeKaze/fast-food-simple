# 🍔 Fast Food Simple (Grocery Ordering App)

A PHP-based grocery/fast food ordering system featuring user accounts, cart logic, admin tools, and unit-tested backend classes.

This project originally began as a simple fast‑food ordering demo, but over time it evolved into a more complete grocery-style ordering system. The repo name reflects the original concept.

---

## ⭐ Overview

This is a **procedural + object‑oriented PHP application** that uses:

- standalone PHP pages for each feature (`index.php`, `cart.php`, `login.php`, etc.)
- reusable backend classes in `src/Classes`
- shared form templates in `src/forms`
- layout/partials in `includes`
- PHPUnit tests in `src/tests` 


The app simulates a real ordering workflow: users can register, log in, browse items, add them to a cart, and place orders. Admins can manage menu items and types.

### Continuous Integration
- [![Coverage](https://codecov.io/gh/KizeKaze/fast-food-simple/branch/main/graph/badge.svg)](https://codecov.io/gh/KizeKaze/fast-food-simple)


---

## 🔧 Tech Stack

### **Languages**
- PHP  
- JavaScript  
- SQL  
- HTML  
- CSS  

### **Backend**
- Sessions for authentication + cart  
- Password hashing  
- Prepared statements  
- Input sanitization  
- Validation  
- Cron job email script (SendGrid originally, being replaced)  
- Database abstraction via custom classes  
- **External API integration (Random Meal API)**  

### **Frontend**
- **Bootstrap** for layout + styling  
- **DOM Manipulation** with vanilla JavaScript  
- **Vue.js** (light usage for the grocery add form)  
- Responsive UI components  
- Form templates in `src/forms`  

### **Testing**
- PHPUnit  
- Unit tests for:
  - Cart  
  - Menu  
  - Password  
  - Query  
  - RandomMeal (API wrapper tests)  
  - User  

---

## 📂 Project Structure

```
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
├── summary.php            # Project summary
├── types.php              # Manage item types
├── vue_groceries_add.php  # Vue.js-based add form (experimental)
├── cron_job_email.php     # Cron job for sending emails
├── database_seed.sql      # Seed data
└── .env_example           # Example environment config
```

---

## 📦 Features

### **User Features**
- Add items to your personal cart  
- Two different ways to search for items  
- Update quantities in the cart  
- Remove items from the cart  
- Purchase items (logged in the database with user, price, and date)  
- Password recovery emails via Resend API
- **Generate random meals using an external API**  

### **Admin Features**
- All user features  
- Add/Edit/Delete items  
- Add/Edit/Delete types  

### **Security**
- URL manipulation protections  
- Admins cannot delete types that are in use  
- Admins cannot delete items that exist in user carts  
- HTTPS enabled on production domain  
- Sanitized input  
- Prepared SQL statements  
- Password hashing  

---

## 🧠 Architecture Style

This project is **not MVC** and does **not** use controllers or a router.

Instead, it uses:

- **Page-based routing** (each feature is its own PHP file)  
- **Object-oriented backend classes** for reusable logic  
- **Form partials** to avoid duplicated markup  
- **Includes** for shared layout  
- **Unit tests** for backend reliability  

It’s a natural evolution from simple PHP scripts into a more structured, maintainable application.


---

## 🚀 Future Improvements  
- Add order history  
- Add product categories  
- Improve UI styling  
- Add search + filtering  
- Add admin dashboard  
- Expand API usage (Random Meal API, Resend API)  

---

## 📫 Contact

- **GitHub:** https://github.com/KizeKaze  
- **LinkedIn:** https://www.linkedin.com/in/raymond-williams-16405a242/  
- **Email:** Ray337@pm.me  
- **Portfolio:** (Rebuilding)
<hr>

## Requirements
- PHP: 8.1+ (tested on 8.1.17)
- Composer: required
- Database: MySQL or MariaDB

### Web server options:
- PHP built‑in server (recommended)
- Apache or Nginx (optional)

## PHP extensions
- pdo_mysql
- mbstring
- openssl
- json

## Installation
1. Clone the repository

```
git clone https://github.com/KizeKaze/fast-food-simple.git
cd fast-food-simple
```

2. Install dependencies

```
composer install

```

3. Environment Files

This project supports two environment files:

- **.env.local** — developer‑specific settings (highest priority)
- **.env** — fallback environment file

The repository includes **.env_example**, which serves as a template.  
To get started, copy it to `.env.local`:

```
cp .env_example .env.local
```

If `.env.local` is missing, the project will automatically fall back to `.env`.

Then open .env.local and fill in:
- MYSQL_DATABASE
- MYSQL_USER
- MYSQL_PASSWORD

MYSQL_HOST is already set to localhost.
APP_URL is set to http://localhost:9001 as default

4. Create and seed the database

```
mysql -u root -p fast_food < database_seed.sql
```

## Running the Project

### Option A — PHP Built‑In Server (Recommended)
Since index.php is in the project root:

```
php -S localhost:9001
```

Then in your preferred browser open:

```
http://localhost:9001
```

### Option B — Apache (Optional)
- Point DocumentRoot to the project root
- Ensure .htaccess is enabled:

```
AllowOverride All
```

### Option C — Nginx (Optional)
- Point root to the project root
- Configure PHP‑FPM normally

## Local Email Setup
This project supports two email methods. Resend API if you happen to use them otherwise SMTP is what you need

### Option A — Resend API (Optional)
In .env.local:

```
EMAIL_PROVIDER=resend
RESEND_API_KEY=your_key_here
```

### Option B — Papercut (Local SMTP Testing)

 **Download Papercut SMTP:**
 <a href="https://www.papercut-smtp.com/" target="_blank">https://www.papercut-smtp.com/</a>

- Install Papercut
- Start Papercut
- Update .env.local:

```
EMAIL_PROVIDER=smtp
SMTP_HOST=localhost
SMTP_PORT=25
```

In your email class, comment out Resend and add call to SMTP:

```
// $email->sendResend($to, $subject, $body);
$email->sendSMTP($to, $subject, $body);
```

After shopping as a user and clicking purchase in cart or filling out "forgot password" in login.php run:
```
php cron_job_email.php
```
This command will fire off any emails. Emails will pop up in Papercut right away.

## Running Tests
This project includes PHPUnit tests for core backend classes.

Run the full test suite:
```
vendor/bin/phpunit
```

Or run a specific test file:
```
vendor/bin/phpunit tests/CartTest.php
```


## Troubleshooting

### Email verification
- order_complete.email_sent will default to 0 and update to 1 if cron_job_email.php has run successfully
- password_reset.password_sent will default to 0 and update to 1 if cron_job_email.php has run successfully

### Checking PHP Extensions

Run the following to list installed extensions:

```
php -m
```

Required extensions:
- mbstring
- openssl
- pdo_mysql
- json

If any are missing, enable them in your `php.ini`.


### Database connection errors
- Check .env.local values
- Ensure the database exists
- Confirm database_seed.sql imported correctly

### Blank page / 500 error
- Enable error display in development
- Check PHP version and extensions