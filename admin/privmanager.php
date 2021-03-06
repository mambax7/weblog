<?php
/*
 *
 * Copyright (c) 2003 by Hiro SAKAI (http://wellwine.net/)
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
include __DIR__ . '/../../../mainfile.php';
include sprintf('%s/include/cp_header.php', XOOPS_ROOT_PATH);
require_once sprintf('%s/modules/%s/header.php', XOOPS_ROOT_PATH, $xoopsModule->dirname());
include __DIR__ . '/admin.inc.php';
require_once __DIR__ . '/admin_header.php';

$action = '';
if (isset($_POST)) {
    foreach ($_POST as $k => $v) {
        ${$k} = $v;
    }
}

function privManagerLink()
{
    global $xoopsModule;

    return sprintf('<a href=\'%s/modules/%s/admin/privmanager.php\'>%s</a>', XOOPS_URL, $xoopsModule->dirname(), _AM_WEBLOG_PRIVMANAGER_WEBLOG);
}

function privmanager()
{
    $memberHandler = xoops_getHandler('group');
    $groups        = $memberHandler->getObjects();
    $group_ids     = [];
    foreach ($groups as $group) {
        $group_ids[$group->getVar('groupid')] = $group->getVar('name');
    }

    $groupHandler   = xoops_getModuleHandler('priv');
    $priv_groups    = $groupHandler->getObjects();
    $priv_group_ids = [];
    foreach ($priv_groups as $priv_group) {
        $priv_group_ids[$priv_group->getVar('priv_gid')] = $priv_group->getVar('name');
    }

    $non_groups = array_diff($group_ids, $priv_group_ids);

    xoops_cp_header();
    //    echo sprintf('<h4>%s&nbsp;&raquo;&raquo;&nbsp;%s</h4>',
    //                 indexLink(), _AM_WEBLOG_PRIVMANAGER_WEBLOG);
    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation(basename(__FILE__));

    echo _AM_WEBLOG_PRIVMANAGER_WEBLOG_CAUTION . '<br><br>';
    echo "<table width='100%' class='outer' cellspacing='1'>\r\n";
    echo sprintf("<tr><th colspan='3'>%s</th></tr>", _AM_WEBLOG_PRIVMANAGER_WEBLOG);

    echo "<tr valign='top' align='center'><td width='40%' class='head'>" . _AM_WEBLOG_NONPRIV . '</td>';
    echo "<td class='head'><br></td>";
    echo "<td width='40%' class='head'>" . _AM_WEBLOG_PRIV . '</td></tr>';
    echo "<form action='privmanager.php' method='post'>";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo "<tr valign='top' align='center'>";
    echo "<td class='even'><select name='gid[]' size='10' multiple>";
    foreach ($non_groups as $g_id => $g_name) {
        if (XOOPS_GROUP_ANONYMOUS != $g_id) {
            echo sprintf("<option value='%d'>%s</option>", $g_id, $g_name);
        }
    }
    echo '</select></td>';
    echo "<td class='odd' valign='middle'>";
    echo sprintf("<input type='submit' class='formButton' name='add' value='%s'>", _AM_WEBLOG_ADDPRIV . ' -->');
    echo "<input type='hidden' name='action' value='add'>";
    echo '</form>';
    echo "<form action='privmanager.php' method='post'>";
    echo $GLOBALS['xoopsSecurity']->getTokenHTML();
    echo sprintf("<input type='submit' class='formButton' name='delete' value='%s'>", '<-- ' . _AM_WEBLOG_DELETEPRIV);
    echo "<input type='hidden' name='action' value='delete'>";
    echo '</td>';
    echo "<td class='even'>";
    echo "<select name='gid[]' size='10' multiple>";
    foreach ($priv_group_ids as $g_id => $g_name) {
        echo sprintf("<option value='%d'>%s</option>", $g_id, $g_name);
    }
    echo '</select></td></tr>';

    echo '</form>';
    echo "</table>\r\n";
    xoops_cp_footer();
}

function addGroup($post)
{
    if (isset($post['gid'])) {
        $groupHandler = xoops_getModuleHandler('priv');
        foreach ($post['gid'] as $gid) {
            $group = $groupHandler->create();
            $group->setVar('priv_gid', $gid);
            $groupHandler->insert($group);
        }
    }
    redirect_header('privmanager.php', 2, _AM_WEBLOG_DBUPDATED);
}

function deleteGroup($post)
{
    if (isset($post['gid'])) {
        $groupHandler = xoops_getModuleHandler('priv');
        foreach ($post['gid'] as $gid) {
            $criteria = new Criteria('priv_gid', $gid);
            $group    = $groupHandler->getObjects($criteria);
            if (is_object($group[0])) {
                $groupHandler->delete($group[0]);
            }
        }
    }
    redirect_header('privmanager.php', 2, _AM_WEBLOG_DBUPDATED);
}

switch ($action) {
    case 'comments':
        synchronizeComments();
        break;
    case 'add':
        addGroup($_POST);
        break;
    case 'delete':
        deleteGroup($_POST);
        break;
    default:
        privmanager();
        break;
}
