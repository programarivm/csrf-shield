## CSRF Shield

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

This is a simple, framework-agnostic library that helps you protect your PHP web apps from CSRF attacks.

### 1. Install

Via composer:

    $ composer require programarivm/csrf-shield

### 2. Instantiation

Just instantiate and use a `CsrfShield` object as it is shown below:

```php
<?php
use CsrfShield\CsrfShield;

session_start();
// ...
$token = CsrfShield::getInstance()->generate()->getToken();
```
All action takes place through the `CsrfShield::getInstance()` object. The call to the `generate()` method creates a new CSRF token storing it into the PHP session on the server side.

> **Side note**. The name of the CSRF session variable is `csrf_shield_token` by default.


### 3. CSRF Shield Methods

#### 3.1. `generate()`

Creates and stores a new CSRF token into the PHP session.

```php
$csrfShield = CsrfShield::getInstance()->generate();
```

#### 3.2. `getToken()`

Gets the CSRF token stored into the session.

The following will create and get a new token -- all at the same time:

```php
$token = CsrfShield::getInstance()->generate()->getToken();
```

On the other hand, this will get an existing token only:


```php
$token = CsrfShield::getInstance()->getToken();
```

#### 3.3. `validate()`

Compares the given string against the current CSRF token.

```php
$isValid = CsrfShield::getInstance()->validate($token);
```

#### 3.4. `getHtmlInput()`

Gets the html input according to the current CSRF token.

```php
$htmlInput = CsrfShield::getInstance()->getHtmlInput();
```

Here is an example:

    <input type="hidden" name="_csrf_shield_token" id="_csrf_shield_token" value="5b18469018952acd17039f62f310426ceac16d3f" />

### 4. Hello World

Run PHP's built-in server:

    cd examples
    php -S localhost:8000

And then visit:

    http://localhost:8000/hello-world.php
