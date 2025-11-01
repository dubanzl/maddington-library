<?php 

require __DIR__ . '/vendor/autoload.php';

use Core\CLI\ConsoleUI;
use Core\CLI\Menu; 

ConsoleUI::title(title: "Starting Library System...");
ConsoleUI::progressDemo(message: "Initializing modules", steps: 8);

Menu::run();