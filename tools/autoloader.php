<?php
// Or, using an anonymous function as of PHP 5.3.0
spl_autoload_register(function ($namespacedClassName) {
  //include 'classes/' . $namespacedClassName . '.class.php';
  //echo 'namespacedClassName '.$namespacedClassName.PHP_EOL;
  $path = 'src/' . str_replace('\\', '/', $namespacedClassName) . '.php';
  if(file_exists($path)) {
    include_once($path);
  } else {
    echo "U requested inexistent class: " . $namespacedClassName . ' - ' . $path . PHP_EOL;
  }
});