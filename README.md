## CSRF Shield

[![Build Status](https://travis-ci.org/programarivm/csrf-shield.svg?branch=master)](https://travis-ci.org/programarivm/csrf-shield)
[![Packagist](https://img.shields.io/packagist/dt/programarivm/csrf-shield.svg)](https://packagist.org/packages/programarivm/csrf-shield)
[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

![CSRF Shield](/resources/csrf-shield.jpg?raw=true)

This is a simple, framework-agnostic library that helps you protect your PHP web apps from CSRF attacks.

### 1. Install

Via composer:

    $ composer require programarivm/csrf-shield

### 2. Instantiation

Just make sure that a PHP session is been started already and then use a `CsrfShield\Protection` object as it is shown below.

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

> **Side Note**: CSRF Shield encourages not to disclose CSRF tokens in URLs. For further information on disclosing tokens in URLs, please visit OWASP's <a href="https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF)_Prevention_Cheat_Sheet#Disclosure_of_Token_in_URL">Cross-Site Request Forgery CSRF Prevention Cheat Sheet</a>.

> **Remember**: The ideal solution is to only include the CSRF token in POST requests and modify server-side actions that have state changing affect to only respond to POST requests. This is in fact what the [RFC 2616](https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.1.1) requires for GET requests. If sensitive server-side actions are guaranteed to only ever respond to POST requests, then there is no need to include the token in GET requests.*

### 3. `CsrfShield\Protection` Methods

#### 3.1. `startToken()`

Creates and stores a new CSRF token into the session.

```php
(new Protection)->startToken();
```

> The name of the underlying CSRF session variable is `_csrf_shield_token` by default.

#### 3.2. `getToken()`

Gets the current CSRF token from the session.

```php
(new Protection)->getToken();
```

#### 3.3. `validateToken()`

Validates the incoming CSRF token against the current session's token, assuming the token is sent through the $_POST['_csrf_shield_token'] value.

```php
(new Protection)->validateToken();
```

> CSRF Shield is built on the idea of protecting POST requests only.

#### 3.4. `htmlInput()`

HTML input tag with the value of the current CSRF token embedded.

```php
(new Protection)->htmlInput();
```

Here is an example:

    <input type="hidden" name="_csrf_shield_token" id="_csrf_shield_token" value="5b18469018952acd17039f62f310426ceac16d3f" />

### 4. Hello World

Run the `hello-world.php` example through PHP's built-in server to see `CsrfShield\Protection` in action:

    cd examples
    php -S localhost:8000

And then visit:

    http://localhost:8000/hello-world.php

### 5. License

The GNU General Public License.

### 6. Contributions

Would you help make this library better? Contributions are welcome.

- Feel free to send a pull request
- Drop an email at info@programarivm.com with the subject "CSRF Shield Contributions"
- Leave me a comment on [Twitter](https://twitter.com/programarivm)
- Say hello on [Google+](https://plus.google.com/+Programarivm)

Many thanks.
