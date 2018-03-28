<?php
use CsrfShield\Protection;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$csrfProtection = new Protection;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ...
}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $csrfProtection->getCsrfSession()->startToken(); ?>

    <!doctype html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>CSRF Shield</title>
            <meta name="description" content="CSRF Shield">
            <meta name="author" content="CSRF Shield">
        </head>
        <body>
            <form method="post">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="user_name">
                </div>
                <div>
                    <label for="mail">E-mail:</label>
                    <input type="email" id="mail" name="user_mail">
                </div>
                <div>
                    <label for="msg">Message:</label>
                    <textarea id="msg" name="user_message"></textarea>
                </div>
                <?php echo $csrfProtection->getHtml()->input(); ?>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </form>
        </body>
    </html>

<?php
}
