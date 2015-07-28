<?php
/**
 * Created by PhpStorm.
 * User: pt
 * Date: 2/26/15
 * Time: 16:54
 */

class FilesValidator
{

    public function checkData($id=0)
    {
        $message = '';
        if(isset($_POST['files_name'])) {
            if(
                !empty($_FILES['files_file']) &&
                !empty($_FILES['files_file']['size']) &&
                empty($id)
            ) {
                preg_match('/\.([a-z]{3,4})$/i', $_FILES['files_file']['name'], $ext_name);
                if(!empty($ext_name[1])) {
                    $maxFileSize = Config::getParam('files::maxSize');
                    $acceptTypes = Config::getParam('files::acceptTypes');
                    $ext_name = strtolower($ext_name[1]);
                    if(($_FILES['files_file']['size']/1000) > $maxFileSize) {
                        $message = 'Размер файла больше допустимого';
                    } else if(
                        empty($acceptTypes[$ext_name]) ||
                        $acceptTypes[$ext_name] != $_FILES['files_file']['type']
                    ) {
                        $message = 'Не допустимый файл';
                    }
                } else {
                    $message = 'Не допустимый формат файла';
                }
            }
            if(empty($_POST['files_name'])) {
               $message = 'Не указано название файла';
            } else if(mb_strlen($_POST['files_name'],'UTF-8') > 255) {
               $message = 'Название слишком длинное, нужно укоротить';
            }
        }
        return $message;
    }
}