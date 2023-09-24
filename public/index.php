<?php
require_once __DIR__ . '/../core/Support/Helpers.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/web.php';


use Dotenv\Dotenv;


Dotenv::createImmutable(base_path())->load();

// App initialize
app()->run();
