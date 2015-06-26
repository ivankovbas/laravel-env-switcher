# Laravel Environment Switcher

Environment Switcher helps you to managing multiple .env of your Laravel 5 / Lumen 5 app.

The problem of **dotenv** is that you can't keep `.env` files for all your environments under version controll.
This package trys to help you with it. For more details see [Usage](#usage-section) section.

(#some-markdown-heading)

## Installation

**Environment Switcher** can be installed globally or per project, with **Composer**:

* **Globally**:

        composer global require composer require ikovbas/laravel-env-switcher

* **Per project**:

        composer require ikovbas/laravel-env-switcher

## Laravel Integration

Open your Laravel config file `config/app.php` and add the service provider for this package in the `$providers` array:

    'IKovbas\EnvSwitcher\EnvSwitcherServiceProvider'

## Lumen Integration

Open your `bootstrap/app.php` file and add the following line to **Register Service Providers** section:

    $app->register('IKovbas\EnvSwitcher\EnvSwitcherServiceProvider');

## <a id="usage-section"></a>Usage

* Show the current environment:

  ```bash
  $ php artisan env:switch
  Current application environment: production
  ```

* Save the current `.env` file to `.$APP_ENV.env`:

  ```bash
  $ php artisan env:switch --save
  Environmental config was successfully saved to .env.production
  ```

* Switch to another environment:

  ```bash
  $ php artisan env:switch development
  Successfully switched from production to development
  ```
  **Note:** `.env.development` should exist before calling the command.

## Copyright and license

    The MIT License
    
        Copyright (c) 2015 Ivan Kovbas

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in
    all copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    THE SOFTWARE.