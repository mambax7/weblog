<?php
/*
 *
 *
 * Copyright (c) 2003 by Jeremy N. Cowgar <jc@cowgar.com>
 *
 */

use Xmf\Module\Helper;

// defined('XOOPS_ROOT_PATH') || exit('XOOPS root path not defined');
require_once __DIR__ . '/../../mainfile.php';
// $moduleDirName  / $mydirnumber are critical GLOBALS.
$moduleDirName = basename(__DIR__);
//$moduleDirName = basename(__DIR__);
$moduleHelper = Helper::getHelper($moduleDirName);

if (!isset($mydirnumber)) {
    if (preg_match("/^(\D+)(\d+)$/", $moduleDirName, $match)) {
        $mydirnumber = (string)$match[2];
    } else {
        $mydirnumber = '';
    }
}
require_once XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/config.php';

// load language_main file
xoops_loadLanguage('main', $moduleDirName);
//if ( ! defined("WEBLOG_BL_LOADED") ) {
//  if ( file_exists( sprintf('%s/modules/%s/language/%s/main.php', XOOPS_ROOT_PATH ,$moduleDirName  , $xoopsConfig->language) ) ) {
//      require_once sprintf('%s/modules/%s/language/%s/main.php', XOOPS_ROOT_PATH , $moduleDirName  , $xoopsConfig->language) ;
//  } else {
//      require_once sprintf('%s/modules/%s/language/english/main.php', XOOPS_ROOT_PATH , $moduleDirName ) ;
//  }
//}
