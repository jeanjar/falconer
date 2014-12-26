<?php
define('PHPUnit_MAIN_METHOD', 'PHPUnit_TextUI_Command::main');
require 'vendor/autoload.php';
require 'boot.php';
PHPUnit_TextUI_Command::main();
