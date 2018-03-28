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
$csrfShield = new CsrfShield;
```
All action takes place through the `$csrfShield` object.

### 3. CSRF Shield Methods

#### 3.1. `generate()`

Creates and stores a new CSRF token into the PHP session.

```php
$csrfShield = (new CsrfShield)->generate();
```

> **Side note**. The name of the CSRF session variable is `_csrf_shield_token` by default.

#### 3.2. `getToken()`

Gets the CSRF token stored into the session.

The following will create and get a new token -- both steps at the same time:

```php
$token = (new CsrfShield)->generate()->getToken();
```

On the other hand, this will get an existing token only:


```php
$token = $csrfShield->getToken();
```

#### 3.3. `validate()`

Compares the given string against the current CSRF token.

```php
$isValid = $csrfShield->validate($token);
```

#### 3.4. `getHtmlInput()`

Gets the html input according to the current CSRF token.

```php
$htmlInput = $csrfShield->getHtmlInput();
```

Here is an example:

    <input type="hidden" name="_csrf_shield_token" id="_csrf_shield_token" value="5b18469018952acd17039f62f310426ceac16d3f" />

### 4. Hello World

Run PHP's built-in server:

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
