<?php

// Den här filen innehåller funtioner som är nödvändiga för funktionen hos Loke

//Default exeption handler

function tangoExeptionHandler($exception) {
  echo "tango: Uncaught exception: <p>" . $exception->getMessage() . "</p><pre>" . $exception->getTraceAsString(), "</pre>";
}
set_exception_handler('tangoExeptionHandler');

// set_exeption_handler initierar standardhanteringen för fel som ej fångas

/**
 * Autoloader for classes.
 *
 */
function tangoAutoloader($class) {
  $path = TANGO_INSTALL_PATH . "/src/{$class}/{$class}.php";
  if(is_file($path)) {
    include($path);
  }
  else {
    throw new Exception("Classfile '{$class}' does not exists.");
  }
}
spl_autoload_register('tangoAutoloader');

