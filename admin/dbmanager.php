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

function dbManagerLink()
{
    global $xoopsModule, $moduleDirName;

    return sprintf('<a href=\'%s/modules/%s/admin/dbmanager.php\'>%s</a>', XOOPS_URL, $xoopsModule->dirname(), _AM_WEBLOG_DBMANAGER);
}

function dbManager()
{
    global $moduleDirName;
    xoops_cp_header();
    //    echo sprintf('<h4>%s&nbsp;&raquo;&raquo;&nbsp;%s</h4>',
    //                 indexLink(), _AM_WEBLOG_DBMANAGER);

    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation(basename(__FILE__));

    echo "<table width='100%' class='outer' cellspacing='1'>\r\n";
    echo sprintf("<tr><th colspan='2'>%s</th></tr>", _AM_WEBLOG_DBMANAGER);

    // synchronize # of comments
    echo tableRow(_AM_WEBLOG_SYNCCOMMENTS, _AM_WEBLOG_SYNCCOMMENTSDSC, 'comments');

    // check table
    echo tableRow(_AM_WEBLOG_CHECKTABLE, _AM_WEBLOG_CHECKTABLEDSC, 'checktable');

    echo "</table>\r\n";
    xoops_cp_footer();
}

/**
 * param[0]=table name
 * param[1]=column name
 * @param $post
 */
function addColumn($post)
{
    global $xoopsDB, $moduleDirName;

    $table  = $post['param'][0];
    $column = $post['param'][1];

    if ($table == $moduleDirName) {
        if ('cat_id' === $column) {
            $sql = sprintf('ALTER TABLE %s ADD cat_id INT( 5 ) UNSIGNED DEFAULT \'1\' NOT NULL', $xoopsDB->prefix($moduleDirName));
        } elseif ('dohtml' === $column) {
            $sql = sprintf('ALTER TABLE %s ADD dohtml TINYINT( 1 ) DEFAULT \'0\' NOT NULL', $xoopsDB->prefix($moduleDirName));
        } elseif ('trackbacks' === $column) {
            $sql = sprintf('ALTER TABLE %s ADD trackbacks INT(11) NOT NULL DEFAULT \'0\' ', $xoopsDB->prefix($moduleDirName));
        } elseif ('permission_group' === $column) {
            $sql = sprintf('ALTER TABLE %s ADD permission_group VARCHAR(255) NOT NULL DEFAULT \'all\' ', $xoopsDB->prefix($moduleDirName));
        } elseif ('dobr' === $column) {
            $sql = sprintf('ALTER TABLE %s ADD dobr TINYINT(1) UNSIGNED NOT NULL DEFAULT \'1\' ', $xoopsDB->prefix($moduleDirName));
        } else {
            redirect_header('dbmanager.php', 2, _AM_WEBLOG_UNSUPPORTED);
        }

        $result = $xoopsDB->query($sql);
        if (!$result) {
            redirect_header('dbmanager.php', 5, sprintf(_AM_WEBLOG_COLNOTADDED, $xoopsDB->error()));
        } else {
            redirect_header('dbmanager.php', 2, _AM_WEBLOG_COLADDED);
        }
    } else {
        redirect_header('dbmanager.php', 2, _AM_WEBLOG_UNSUPPORTED);
    }
}

function addTable($post)
{
    global $xoopsDB, $moduleDirName;

    $table = $post['param'][0];

    if ($table == $moduleDirName . '_category') {
        $sql = sprintf('CREATE TABLE %s (', $xoopsDB->prefix($moduleDirName . '_category'));
        $sql .= 'cat_id int(5) unsigned NOT NULL auto_increment,';
        $sql .= 'cat_pid int(5) unsigned NOT NULL default \'0\',';
        $sql .= 'cat_title varchar(50) NOT NULL default \'\',';
        $sql .= 'cat_description text NOT NULL,';
        $sql .= 'cat_created int(10) NOT NULL default \'0\',';
        $sql .= 'cat_imgurl varchar(150) NOT NULL default \'\',';
        $sql .= 'PRIMARY KEY  (cat_id),';
        $sql .= 'KEY cat_pid (cat_pid)';
        $sql .= ') ENGINE=MyISAM;';
    } elseif ($table == $moduleDirName . '_priv') {
        $sql = sprintf('CREATE TABLE %s(', $xoopsDB->prefix($moduleDirName . '_priv'));
        $sql .= 'priv_id smallint(5) unsigned NOT NULL auto_increment,';
        $sql .= 'priv_gid smallint(5) unsigned NOT NULL default \'0\',';
        $sql .= 'PRIMARY KEY  (priv_id)';
        $sql .= ') ENGINE=MyISAM;';
    } elseif ($table == $moduleDirName . '_trackback') {
        $sql = sprintf('CREATE TABLE %s(', $xoopsDB->prefix($moduleDirName . '_trackback'));
        $sql .= 'blog_id mediumint(9) NOT NULL ,';
        $sql .= 'tb_url text NOT NULL,';
        $sql .= 'blog_name varchar(255) NOT NULL,';
        $sql .= 'title varchar(255) NOT NULL,';
        $sql .= 'description text NOT NULL,';
        $sql .= 'link text NOT NULL,';
        $sql .= 'direction enum(\'\',\'transmit\',\'recieved\') NOT NULL default \'\',';
        $sql .= 'trackback_created int(10) NOT NULL default \'0\',';
        $sql .= 'PRIMARY KEY  (blog_id,tb_url(100),direction)';
        $sql .= ') ENGINE=MyISAM;';
    } elseif ($table == $moduleDirName . 'myalbum_photos') {
        $sql = sprintf('CREATE TABLE %s(', $xoopsDB->prefix($moduleDirName . 'myalbum_photos'));
        $sql .= 'lid int(11) unsigned NOT NULL auto_increment, ';
        $sql .= 'cid int(5) unsigned NOT NULL default \'0\', ';
        $sql .= 'title varchar(100) NOT NULL default \'\', ';
        $sql .= 'ext varchar(10) NOT NULL default \'\', ';
        $sql .= 'res_x int(11) NOT NULL default \'\', ';
        $sql .= 'res_y int(11) NOT NULL default \'\' ,';
        $sql .= 'submitter int(11) unsigned NOT NULL default \'0\',';
        $sql .= 'status tinyint(2) NOT NULL default \'0\',';
        $sql .= 'date int(10) NOT NULL default \'0\',';
        $sql .= 'PRIMARY KEY  (lid),';
        $sql .= 'KEY cid (cid)';
        $sql .= ') ENGINE=MyISAM;';
    } else {
        redirect_header('dbmanager.php', 2, _AM_WEBLOG_UNSUPPORTED);
    }

    $result = $xoopsDB->query($sql);
    if (!$result) {
        redirect_header('dbmanager.php', 5, sprintf(_AM_WEBLOG_TABLENOTADDED, $xoopsDB->error()));
    } else {
        if ($table == $moduleDirName . '_category') {
            $handler = xoops_getModuleHandler('category');
            $cat     = $handler->create();
            $cat->setVar('cat_pid', 0);
            $cat->setVar('cat_id', 1);
            $cat->setVar('cat_created', time());
            $cat->setVar('cat_title', 'Miscellaneous');
            $cat->setVar('cat_description', '');
            $cat->setVar('cat_imgurl', '');
            $ret = $handler->insert($cat);
        }
        redirect_header('dbmanager.php', 5, _AM_WEBLOG_TABLEADDED);
    }
}

function checkTables()
{
    global $moduleDirName;
    xoops_cp_header();
    //    echo sprintf('<h4>%s&nbsp;&raquo;&raquo;&nbsp;%s&nbsp;&raquo;&raquo;&nbsp;%s</h4>',
    //                 indexLink(), dbManagerLink(), _AM_WEBLOG_CHECKTABLE);

    $adminObject = \Xmf\Module\Admin::getInstance();
    $adminObject->displayNavigation(basename(__FILE__));

    // checking table 'weblog'
    $columns = [
        'blog_id',
        'user_id',
        'cat_id',
        'created',
        'title',
        'contents',
        'private',
        'comments',
        'reads',
        'trackbacks',
        'permission_group',
        'dohtml',
        'dobr'
    ];
    checkTable($moduleDirName, $columns);

    echo '<br>';
    // checking table 'weblog_category'
    $columns = ['cat_id', 'cat_pid', 'cat_title', 'cat_description', 'cat_created', 'cat_imgurl'];
    checkTable($moduleDirName . '_category', $columns);

    echo '<br>';
    // checking table 'weblog_priv'
    $columns = ['priv_id', 'priv_gid'];
    checkTable($moduleDirName . '_priv', $columns);

    echo '<br>';
    // checking table 'weblog_trackback'
    $columns = [
        'blog_id',
        'tb_url',
        'blog_name',
        'title',
        'description',
        'link',
        'direction',
        'trackback_created'
    ];
    checkTable($moduleDirName . '_trackback', $columns);

    echo '<br>';
    // checking table 'weblogmyalbum_photos'
    $columns = ['lid', 'cid', 'title', 'ext', 'res_x', 'res_y', 'submitter', 'status', 'date'];
    checkTable($moduleDirName . 'myalbum_photos', $columns);

    xoops_cp_footer();
}

function checkTable($table, $columns = [])
{
    global $xoopsDB, $moduleDirName;

    $sql         = sprintf('SELECT count(*) AS count FROM %s WHERE 1', $xoopsDB->prefix($table));
    $result      = $xoopsDB->query($sql);
    $table_exist = $result ? true : false;
    if ($table_exist) {
        list($count) = $xoopsDB->fetchRow($result);
        $row_exist = (isset($count['count']) && $count['count'] > 0) ? true : false;
    }

    echo "<table width='100%' class='outer' cellspacing='1'>\r\n";
    echo sprintf('<tr><th colspan=\'2\'>%s: \'%s\'</th></tr>', _AM_WEBLOG_TABLE, $table);

    // if table does not exist or table does not have rows
    //if (!$table_exist || !$row_exist) {
    if (!$table_exist) {
        $hidden = [0 => $table];
        echo tableRow(sprintf(_AM_WEBLOG_CREATETABLE, $table), sprintf(_AM_WEBLOG_CREATETABLEDSC, $table), 'addtable', $hidden);
        // table does exist and columns are missing
    } else {
        $sql    = sprintf('SHOW COLUMNS FROM %s', $xoopsDB->prefix($table));
        $result = $xoopsDB->query($sql);
        $fields = [];
        while (list($field) = $xoopsDB->fetchRow($result)) {
            $fields[] = $field;
        }
        $alter = false;
        foreach ($columns as $column) {
            foreach ($fields as $field) {
                if ($column === $field) {
                    continue 2;
                }
            }
            $hidden = [0 => $table, 1 => $column];
            echo tableRow(sprintf(_AM_WEBLOG_ADD, $column), sprintf(_AM_WEBLOG_ADDDSC, $column), 'addcolumn', $hidden);
            $alter = true;
        }
        if (false === $alter) {
            echo tableRow(sprintf(_AM_WEBLOG_NOADD, $table), sprintf(_AM_WEBLOG_NOADDDSC, $table));
        }
    }

    echo "</table>\r\n";
}

function synchronizeComments()
{
    global $xoopsDB, $xoopsModule, $moduleDirName;
    $sql = sprintf('SELECT bl.blog_id, COUNT(cm.com_id) FROM %s AS bl LEFT JOIN %s AS cm ON bl.blog_id=cm.com_itemid AND cm.com_modid=%d GROUP BY bl.blog_id', $xoopsDB->prefix($moduleDirName), $xoopsDB->prefix('xoopscomments'), $xoopsModule->getVar('mid'));
    $result = $xoopsDB->query($sql) or exit($xoopsDB->error());
    $handler = xoops_getModuleHandler('entry');
    while (list($blog_id, $comments) = $xoopsDB->fetchRow($result)) {
        $handler->updateComments($blog_id, (int)$comments);
    }
    redirect_header('dbmanager.php', 2, _AM_WEBLOG_DBUPDATED);
}

switch ($action) {
    case 'comments':
        synchronizeComments();
        break;
    case 'checktable':
        checkTables();
        break;
    case 'addcolumn':
        addColumn($_POST);
        break;
    case 'addtable':
        addTable($_POST);
        break;
    default:
        dbManager();
        break;
}
