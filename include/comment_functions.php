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

// configure values and common functions
defined('XOOPS_ROOT_PATH') || exit('XOOPS Root Path not defined');

// configure values and common functions
$moduleDirName = basename(dirname(__DIR__));

function weblog_com_update($link_id, $total_num)
{
    global $moduleDirName;
    $db  = XoopsDatabaseFactory::getDatabaseConnection();
    $sql = 'UPDATE ' . $db->prefix($moduleDirName) . ' SET comments = ' . $total_num . ' WHERE blog_id = ' . $link_id;
    $db->query($sql);
}

function weblog_com_approve(&$comment)
{
    // send notification mail
}
