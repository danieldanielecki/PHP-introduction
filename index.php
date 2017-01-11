<?php
// Start Session.
session_start(); // Right now it'll run for every page.

require 'config.php';

require 'classes/Bootstrap.php';
require 'classes/Controller.php';
require 'classes/Messages.php';
require 'classes/Model.php';

// Controllers plural names, models singular names.
require 'controllers/home.php';
require 'controllers/shares.php';
require 'controllers/users.php';
require 'models/home.php';
require 'models/share.php';
require 'models/user.php';

$bootstrap = new Bootstrap($_GET); // Superglobal variable passed to script via URL.
$controller = $bootstrap->createController();

if ($controller) {
  $controller->executeAction();
}
