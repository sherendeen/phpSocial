# phpSocial
Really very simple php-based, semi-anonymous message board.

![Desktop version](https://i.imgur.com/CKyY1wV.png)

![Mobile version](https://i.imgur.com/l2RHlgU.jpg)

# Features
- Supports some videos
- Fits your screens
- lightweight, no javascript
- simple

# Deployment
Pretty sure PHP 7 or greater. I used MySQL for the database. WWW directory needs to have an [uploads] director so that users may upload images. 

Lines 16-18 should be modified:
    $dsn = "mysql:host=localhost;dbname=";
    $dbUsername = '';
    $dbPassword = '';
dbname in $dsn should be equal to the name of your MySQL database for your site. $dbUsername should be equal to whatever username you use to connect to your MySQL database. $dbPassword is your database connection password.

# Licenses
All files are licensed as MIT, excecpt for new_style.css, style_n11.css, privacy.html, and rules.html, which are public domain CC0. 
