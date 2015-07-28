<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 12:30
 */

function autoload($className)
{
    //class directories
    $directories = array(
        'config/',
        'models/',
        'controllers/',
        'components/',
    );

    foreach($directories as $dir) {
        $class_path = dirname(__FILE__).'/'.$dir . $className.'.php';
        if(file_exists($class_path)) {
            include $class_path;
        }
    }
}
spl_autoload_register('autoload');