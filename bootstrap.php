<?php

# Require AutoLoader 
require __DIR__ . '/vendor/autoload.php';
# Require Nette AutoLoader for Dirs
$loader = new Nette\Loaders\RobotLoader;
$loader->addDirectory(__DIR__ . '/src/');
$loader->setTempDirectory(__DIR__ . '/src/temp');
$loader->register();

$logger   = new Logger();
$database = new Database($logger);