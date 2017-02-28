<?php
/**
 * Bootstrap for PHPExcelForm classes.
 *
 * Copyright (c) 2017+ PHPExcelForm
 *
 * @category   PhpExcelForm
 * @author Iurii Bell <ds@inbox.ru>
 * @copyright  Copyright (c) 2017+ PhpExcelForm 
 * @license    MIT
 */

$paths = [
    __DIR__ . '/../vendor/autoload.php', // In case PHPExcelForm is cloned directly
    __DIR__ . '/../../../autoload.php', // In case PHPExcelForm is a composer dependency.
];
foreach ($paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        return;
    }
}
throw new \Exception('Composer autoloader could not be found. Install dependencies with `composer install` and try again.');