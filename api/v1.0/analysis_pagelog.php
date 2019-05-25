<?php
/**
 * Created by PhpStorm.
 * User: wangming
 * Date: 2019/3/28
 * Time: 19:51
 */

require_once '../../init.php';

$action = safeCheck($_POST['action'], 0);
$path = safeCheck($_POST['path'], 0);
$uionid = safeCheck($_COOKIE['uionid'], 0);
if (!$uionid) {
    $uionid = safeCheck($_POST['finger'],0);
}

switch ($action) {
    case 'add':
        $attrs = array(
            'path' => $path,
            'starttime' => time(),
            'endtime' => time(),
            'uionid' => $uionid,
            'entercount' => 0
        );
        $rs = pagelog::add($attrs);

        echo action_msg($rs, 200);
        break;
    case 'update':
        $page_res = pagelog::getLatestInfoByPath($path,$uionid);
        $attrs = array(
            'endtime'=>time()
        );

        pagelog::update($page_res[0]['id'], $attrs);

        echo action_msg('ok', 200);

        break;
    case 'entercount':
        $page_res = pagelog::getLatestInfoByPath($path,$uionid);
        $attrs = array(
            'entercount' => $page_res[0]['entercount'] + 1,
        );

        pagelog::update($page_res[0]['id'], $attrs);
        echo action_msg('ok', 200);
        break;




}