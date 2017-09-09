<?php
/*
 *
 * Copyright (c) 2003 by Hiro SAKAI (http://wellwine.zive.net/)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting
 * source code which is considered copyrighted (c) material of the
 * original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA
 */

// defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

$moduleDirName = basename(dirname(__DIR__));

if (false !== ($moduleHelper = Xmf\Module\Helper::getHelper($moduleDirName))) {
} else {
    $moduleHelper = Xmf\Module\Helper::getHelper('system');
}


$pathIcon32 = \Xmf\Module\Admin::menuIconPath('');
//$pathModIcon32 = $moduleHelper->getModule()->getInfo('modicons32');

$moduleHelper->loadLanguage('modinfo');

$adminmenu              = [];
$i                      = 0;
'title' =>  _AM_MODULEADMIN_HOME,
'link' =>  'admin/index.php',
'icon' =>  $pathIcon32 . '/home.png',
++$i;
'title' =>  _MI_WEBLOG_CATMANAGER,
'link' =>  'admin/catmanager.php',
'icon' =>  $pathIcon32 . '/category.png',
++$i;
'title' =>  _MI_WEBLOG_PRIVMANAGER,
'link' =>  'admin/privmanager.php',
'icon' =>  $pathIcon32 . '/manage.png',
++$i;
'title' =>  _MI_WEBLOG_MYGROUPSADMIN,
'link' =>  'admin/groupperm_global.php',
'icon' =>  $pathIcon32 . '/permissions.png',
++$i;
'title' =>  _MI_WEBLOG_DBMANAGER,
'link' =>  'admin/dbmanager.php',
'icon' =>  $pathIcon32 . '/list.png',
//++$i;
//'title' =>  _MI_WEBLOG_MYBLOCKSADMIN ,
//'link' =>  "admin/myblocksadmin.php" ,
//$adminmenu[$i]["icon"]  = $pathIcon32 . '/block.png';
//++$i;
//'title' =>  _MI_WEBLOG_TEMPLATE_MANEGER ,
//'link' => templates" ,
//$adminmenu[$i]["icon"]  = $pathIcon32 . '/watermark.png';
++$i;
'title' =>  _AM_MODULEADMIN_ABOUT,
'link' =>  'admin/about.php',
'icon' =>  $pathIcon32 . '/about.png',
