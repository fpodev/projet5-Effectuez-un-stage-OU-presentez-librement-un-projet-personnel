<?php
require 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('Librairies/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => 'Librairies/compilation_cache',
]);
