<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 12:31
 */

define('CONST_ROOT_DIR', dirname(__FILE__).'/..');
define('CONST_INFOLDER', 'stroyka');

if (!function_exists('mb_ucfirst') && extension_loaded('mbstring'))
{
    /**
     * mb_ucfirst - преобразует первый символ в верхний регистр
     * @param string $str - строка
     * @param string $encoding - кодировка, по-умолчанию UTF-8
     * @return string
     */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = mb_ereg_replace('^[\ ]+', '', $str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}

class Helper {

    private static $limitException=0;

    private static $layout = 'layouts/main.php';

    public static function HException($message, $code=404) {

        self::$limitException++;

        if(self::$limitException < 2) {
            try {
                throw new Exception($message, $code);
            } catch(Exception $e) {
                self::renderStatic('exception', array(
                    'code' => $e->getCode(),
                    'message' => $e->getMessage(),
                ));
            }
        } else {
            echo $code.': ';
            echo $message;
        }
        exit;
    }

    public function render($filename, array $params=array()) {
        return self::renderStatic($filename, $params);
    }

    public static function renderStatic($filename, array $params=array()) {

        $view_dir = CONST_ROOT_DIR.'/views/';

        $layout = $view_dir.self::$layout;

        if(!is_file($layout)) {
            self::HException("Layout '".self::$layout."' does not exist.");
        }

        $file_path = $view_dir.$filename.'.php';

        if(!is_file($file_path)) {
            self::HException("The template file '$filename' does not exist.");
        }

        extract($params,EXTR_PREFIX_SAME,'params');

        ob_start();
        ob_implicit_flush(false);

        include($file_path);

        $params = array('content' => ob_get_clean());

        extract($params,EXTR_PREFIX_SAME,'params');

        ob_start();
        ob_implicit_flush(false);

        include($layout);

        echo ob_get_clean();

        return true;
    }
}