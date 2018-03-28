<?php
use CsrfShield\Protection;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$csrfProtection = new Protection;

// ...
