<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$routes = app('router')->getRoutes();
foreach ($routes as $route) {
    $name = $route->getName();
    if ($name && str_contains($name, 'profile')) {
        echo $name . ' => ' . $route->uri() . PHP_EOL;
    }
}