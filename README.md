## CSRF Shield

[![Build Status](https://travis-ci.org/programarivm/csrf-shield.svg?branch=master)](https://travis-ci.org/programarivm/csrf-shield)
[![Packagist](https://img.shields.io/packagist/dt/programarivm/csrf-shield.svg)](https://packagist.org/packages/programarivm/csrf-shield)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

![CSRF Shield](/resources/csrf-shield.jpg?raw=true)

This is a simple, framework-agnostic library that helps you protect your PHP web apps from CSRF attacks.  CSRF Shield is built on the idea of **sending tokens with the POST method only**; otherwise the server will respond with a `405` status code (`Method Not Allowed`).

> **Remember**: It is encouraged not to disclose CSRF tokens in URLs. For further information on disclosing tokens in URLs, please visit OWASP's <a href="https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF)_Prevention_Cheat_Sheet#Disclosure_of_Token_in_URL">Cross-Site Request Forgery CSRF Prevention Cheat Sheet</a>.

### 1. Install

Via composer:

    $ composer require programarivm/csrf-shield

### 2. Instantiation

Make sure that a PHP session is been started already and then use a `CsrfShield\Protection` object as it is shown below.

To create/store a new CSRF token into the session:

```php
<?php
use CsrfShield\Protection;

session_start();
// ...
(new Protection)->startToken();
```

To protect a PHP code snippet that responds to a POST request:

```php
<?php
use CsrfShield\Protection;

session_start();
// ...
(new Protection)->validateToken();
```

### 3. `CsrfShield\Protection` Methods

#### 3.1. `startToken()`

Creates and stores a new CSRF token into the session.

```php
(new Protection)->startToken();
```

> **Side Note**: The name of the CSRF session variable is `_csrf_shield_token` by default.

#### 3.2. `getToken()`

Gets the current CSRF token from the session.

```php
(new Protection)->getToken();
```

#### 3.3. `validateToken()`

Validates the incoming CSRF token against the current session's token.

```php
(new Protection)->validateToken();
```

The token can be read either through `$_POST['_csrf_shield_token']`, or through `$_SERVER['HTTP_X_CSRF_TOKEN']` if an AJAX call is made with an `X-CSRF-Token` header.

If the token is not valid the server will send a `403` response (`Forbidden`).

#### 3.4. `htmlInput()`

HTML input tag with the embedded value of the current CSRF token.

```php
(new Protection)->htmlInput();
```

Here is an example:

    <input type="hidden" name="_csrf_shield_token" id="_csrf_shield_token" value="5b18469018952acd17039f62f310426ceac16d3f" />

### 4. Hello World

Run the `auto-processing-form.php` example with PHP's built-in server to see `CsrfShield\Protection` in action:

    cd examples
    php -S localhost:8000

And then visit:

    http://localhost:8000/auto-processing-form.php

### 5. License

The GNU General Public License.

### 6. Contributions

Would you help make this library better? Contributions are welcome.

- Feel free to send a pull request
- Drop an email at info@programarivm.com with the subject "CSRF Shield Contributions"
- Leave me a comment on [Twitter](https://twitter.com/programarivm)
- Say hello on [Google+](https://plus.google.com/+Programarivm)

Many thanks.
