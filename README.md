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
- [![Coverage](https://codecov.io/gh/KizeKaze/fast-food-simple/branch/master/graph/badge.svg)](https://codecov.io/gh/KizeKaze/fast-food-simple)


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

# 🐳 Docker Development Environment

This project includes a complete Dockerized PHP + Apache + MySQL environment to ensure consistent behavior across machines.

Download Docker at <a href="https://www.docker.com/" target="_blank">https://www.docker.com/</a>

## PHP Container

The PHP container mounts a custom development configuration file:

```
php-config/dev.ini → /usr/local/etc/php/conf.d/dev.ini
```

This allows the project to override PHP settings *without* modifying the base image.

## MySQL Container

MySQL initializes automatically using the `database_seed.sql` file in the project root.

---

# 🧩 PHP Error Display (Development Mode)

To provide a clean and stable development experience, the Docker environment disables PHP warnings and notices **in the browser**, while still logging them internally.

This prevents non‑critical warnings from interrupting redirects or HTML output — a common issue when working with legacy PHP applications.

All errors continue to be logged normally by PHP.

You can modify this behavior by editing:

```
php-config/dev.ini
```

---

# 🚀 Running the Project

Start the full stack:

```bash
docker compose up --build
```

Then visit the application:

```
http://localhost:9001
```

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


## 🧪 Running Tests

This project includes PHPUnit tests for core backend classes.

Run the full test suite:

```
vendor/bin/phpunit
```

Or run a specific test file:

```
vendor/bin/phpunit tests/CartTest.php
```

---

## 🔐 Admin Access

Open your `users` table and update `user_role` from `0` → `1` to enable admin privileges.

---


### Email verification
- order_complete.email_sent will default to 0 and update to 1 if cron_job_email.php has run successfully
- password_reset.password_sent will default to 0 and update to 1 if cron_job_email.php has run successfully


