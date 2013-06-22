<?php
function error_to_exception($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}

set_error_handler("error_to_exception");

function autoload_by_namespace($class) {
    $file_path = str_replace(
        "\\",
        DIRECTORY_SEPARATOR,
        $class
    ) . '.php';
    try {
        include_once($file_path);
    } catch (ErrorException $e) {
        $path_elements = explode("\\", $class);
        array_pop($path_elements);
        $path_elements[] = ucfirst(end($path_elements));
        $file_path = implode(
            DIRECTORY_SEPARATOR,
            $path_elements
        ) . '.php';
        include_once $file_path;
    }
}

spl_autoload_register('autoload_by_namespace');
