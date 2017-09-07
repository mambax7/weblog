<?php
/*
 *
 * Copyright (c) 2003 by Jeremy N. Cowgar <jc@cowgar.com>
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

defined('XOOPS_ROOT_PATH') || exit('Restricted access.');

$moduleDirName = basename(dirname(__DIR__));
if (!preg_match('/^(\D+)(\d*)$/', $moduleDirName, $regs)) {
    die('invalid dirname: ' . htmlspecialchars($moduleDirName));
}
$mydirnumber = $regs[2] === '' ? '' : (int)$regs[2];

eval('
function blog' . $mydirnumber . '_info($category, $item_id)
{
    return blog_info_base( "' . $moduleDirName . '", $category, $item_id ) ;
}
');

//function blog'.$mydirnumber.'_info_base( $moduleDirName , $category, $item_id )
function blog_info_base($moduleDirName, $category, $item_id)
{
    global $xoopsModule, $xoopsModuleConfig, $xoopsConfig;

    if (empty($xoopsModule) || $xoopsModule->getVar('dirname') != $moduleDirName) {
        /** @var XoopsModuleHandler $moduleHandler */
        $moduleHandler = xoops_getHandler('module');
        $module        = $moduleHandler->getByDirname($moduleDirName);
        $configHandler = xoops_getHandler('config');
        $config        = $configHandler->getConfigsByCat(0, $module->getVar('mid'));
    } else {
        $module =& $xoopsModule;
        $config =& $xoopsModuleConfig;
    }

    require_once XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/language/' . $xoopsConfig['language'] . '/main.php';

    if ($category == 'global') {
        $item['name'] = '';
        $item['url']  = '';

        return $item;
    }

    global $xoopsDB;
    if ($category == 'blog') {
        // Assume we have a valid forum id
        $sql          = 'SELECT uname FROM ' . $xoopsDB->prefix('users') . ' WHERE uid = ' . $item_id;
        $result       = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = sprintf(_BL_WHOS_BLOG, $result_array['uname']);
        $item['url']  = XOOPS_URL . '/modules/' . $module->getVar('dirname') . '/index.php?user_id=' . $item_id;

        return $item;
    } elseif ($category == 'blog_entry') {
        // Assume we have a valid forum id
        $sql          = 'SELECT title FROM ' . $xoopsDB->prefix($moduleDirName) . ' WHERE blog_id = ' . $item_id;
        $result       = $xoopsDB->query($sql); // TODO: error check
        $result_array = $xoopsDB->fetchArray($result);
        $item['name'] = $result_array['title'];
        $item['url']  = XOOPS_URL . '/modules/' . $moduleDirName . '/details.php?blog_id=' . $item_id;

        return $item;
    }
}
