<?php
use CsrfShield\Protection;

require_once __DIR__ . '/../../vendor/autoload.php';

session_start();

(new Protection)->validateToken();
echo 'This request was successfully protected against CSRF attacks.';
