<?php
/**
 * Created by PhpStorm.
 * User: 张鑫
 * Date: 2018/8/2
 * Time: 13:37
 */
class word
{
    static public function start()
    {
        ob_start();
        echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
        xmlns:w="urn:schemas-microsoft-com:office:word"
        xmlns="http://www.w3.org/TR/REC-html40">';
    }
    static public function save($path)
    {

        echo "</html>";
        $data = ob_get_contents();
        ob_end_clean();
        self::wirtefile($path,$data);
    }

    static public function wirtefile ($fn,$data)
    {
        $fp=fopen($fn,"wb");
        fwrite($fp,$data);
        fclose($fp);
    }
}