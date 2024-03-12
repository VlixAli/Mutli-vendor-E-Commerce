# Multi-Vendor E-Commerce website
<p align="center">
</p>

---

<li> Welcome to the multi-vendor E-Commerce application, designed  for allowing users to purchase products while allowing shop owners to add their products, sell them and access the admin dashboard sections that are allowed for them.</li>

##  📝Table of content

---
- [Built Using](#built).
- [Features](#features).
- [Requirements](#requirements).
- [Installation Steps](#installation).
- [Api documentation](#api).
- [concepts and patterns used](#concepts).
- [Acknowledgements](#acknowledgements).
- [Screenshots](#screens).


## ⛏️ Built Using <a name = "built"></a>

---
- [MySQL](https://www.mongodb.com/) - Database
- [PHP](https://www.php.net/) - Programming Language
- [Laravel](https://laravel.com/) - Web Framework
- [Tailwind Css](https://tailwindcss.com/) - Css Framework
- [Bootstrap](https://getbootstrap.com/) - Css Framework

## 🧐Features <a name = "features"></a>

---
- Login and Registration for users
- Login for admins
- 2 Factor Authentication for users
- api for products and for authentication using sanctum
- translating the header navbar 
- changing the currency
- adding products to the shopping cart
- checkout page
- payment page using stripe
- Oauth login with google 
- Admin dashboard for monitoring products, categories, roles, users and admins
- roles page in the admin dashboard to create , edit roles and add permissions to them
- Email Notifications
- Search Categories in the admin categories dashboard
- Soft deletes for categories

## 🔧Requirements <a name = "requirements"></a>

---
- PHP => 8
- Laravel => 10
- composer
- MySQL
- NodeJs

## 🚀 Installation Steps <a name = "installation"></a>

---

First clone this repository, install the dependencies, and setup your .env file.

```
git clone https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel.git
composer install
cp .env.example .env
```
add your Database credentials to your .env file and run this command to generate the app key, create and seed the database 

```
php artisan key:generate
php artisan migrate
```

run the project using the following command
```
php artisan serve
```
and in another terminal the following command

```
npm run dev
```

if you want to test the email notification feature you can add your email credentials to your .env file

### Admin dashboard credentials
- email : AdminEmail@example.com
- password : password

## ✍️ Api documentation <a name = "api"></a>

---
For how to use the products api and create access token view this link
[Mutli-Vendor E-Commerce](https://documenter.getpostman.com/view/23171948/2sA2xiVrUe)

## 🎈 concepts and patterns used <a name = "concepts"></a>

---
### Laravel concepts :
- Using Events (Order Created)
- Using Listeners 
- Using Jobs (delete expired orders)
- Exception handling (invalid Order exception)
- Notifications (Order Created Notification)
- custom Requests for validations 
- Resources for customizing api response
- observers (Cart Observer to add uuid to the cart)
- Facades (Cart facade class)
- Policies and roles for authorization
- Laravel Sanctum for api authentication
- Laravel fortify for web authentication
- Laravel socialite for Oauth social Authentication
- Integration with external apis (Currency Converter api)
- Model Factory and Database seeders
- adding lang file to translate the website
- blade template engine

### Design Patterns used :
- Repository Design Pattern
- Service Design Pattern
- Dependency Injection
- MVC Design Pattern

## 🎉 Acknowledgements <a name = "acknowledgements"></a>

---
That project was created with the help of this amazing tutorial [PHP Laravel 9 Course: Multi-Vendor Store Example](https://youtube.com/playlist?list=PL13Ag2mfco64zMLcFjPb5GVWCu-OAjTrx&si=sziOsFlBgOMOU8no)
on youtube (In Arabic).

## 📷 Screenshots <a name = "screens"></a>

---

### Home page 
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/home%20page.PNG?raw=true"/>
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/home%20page2.PNG?raw=true"/>
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/home%20page%203.PNG?raw=true"/>

### Cart
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/cart%20page.PNG?raw=true"/>

### Checkout
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/checkout%20page.PNG?raw=true"/>

### Payment
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/payment%20page.PNG?raw=true"/>

### Login
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/login.PNG?raw=true"/>

### Registration
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/registration.PNG?raw=true"/>

### Admin dashboard
<img src="https://github.com/VlixAli/Mutli-vendor-E-Commerce-using-laravel/blob/main/screenshots/admin%20dashboard%20page.PNG?raw=true"/>


