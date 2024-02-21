# Kyte

Kyte is a lightweight framework for building web applications. This README provides a quick guide on how to get started with Kyte.

## Getting Started

Follow these steps to set up Kyte on your server:

### 1. Clone the Repository

First, clone the Kyte repository into your web server's document root (e.g., `/var/www/html` or another directory where your web files are served).

```bash
git clone https://github.com/keyqcloud/kyte.git /var/www/html/
```

### 2. Install Dependencies

Navigate to the Kyte directory and run Composer to install the necessary dependencies.

```bash
cd /var/www/html/
composer update
```

### 3. Configure Kyte

Copy the sample configuration file to config.php and edit it to add your database credentials.

```bash
cp vendor/keyqcloud/kyte-php/sample-config.php config.php
```

Open `config.php` in your favorite text editor and set your database credentials:

```php
/* DB INTEGRATION */
define('KYTE_DB_USERNAME', '');
define('KYTE_DB_PASSWORD', '');
define('KYTE_DB_HOST', '');
define('KYTE_DB_DATABASE', '');
define('KYTE_DB_CHARSET', 'utf8mb4');
```

### 4. Optional Configuration

You may want to make other configuration changes based on your application's requirements. Review the configuration options in config.php and adjust as necessary.