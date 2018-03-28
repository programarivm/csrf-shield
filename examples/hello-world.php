<?php
use CsrfShield\CsrfShield;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$csrfShield = new CsrfShield;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($csrfShield->validate($_POST['_csrf_shield_token'])) {
        echo 'The token is valid';
    } else {
        echo 'Whoops! The token is not valid';
    }

}

elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $csrfShield->generate(); ?>

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
                <?php echo $csrfShield->getHtmlInput(); ?>
                <div>
                    <input type="submit" value="Submit">
                </div>
            </form>
        </body>
    </html>

<?php
}
