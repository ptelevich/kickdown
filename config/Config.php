<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 12:30
 */

$params = array(
    'db' => array(
        'DB_HOSTNAME' => '192.168.90.6',
        'DBUSER' => 'ivan',
        'DBPASS' => 'ivan',
        'DBNAME' => 'tecdoc',
    ),
);

class Config {

    private static $params;

    public function setParams($params) {
        self::$params = $params;
    }

    public static function getParam($path) {

        $name_path = explode('::', trim($path));

        $param = self::$params;

        foreach($name_path as $nPath) {

            $param = $param[$nPath];
        }

        return $param;
    }
}
$config = new Config();
$config->setParams($params);