<?php
/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright      {@link https://xoops.org/ XOOPS Project}
 * @license        {@link http://www.gnu.org/licenses/gpl-2.0.html GNU GPL 2 or later}
 * @package
 * @since
 * @author         XOOPS Development Team
 */

include __DIR__ . '/header.php';
$com_itemid = isset($_GET['com_itemid']) ? (int)$_GET['com_itemid'] : 0;
if ($com_itemid > 0) {
    require_once XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/class/class.weblog.php';
    $weblog = Weblog::getInstance();
    $entry  = $weblog->getEntry(0, $com_itemid);

    // title
    $com_replytitle = $entry->getVar('title');

    // text
    $com_replytext = sprintf('%s &nbsp;<b> %s </b>&nbsp; %s &nbsp;<b> %s </b><br><br>%s', _POSTEDBY, XoopsUser::getUnameFromId($entry->getVar('user_id')), _DATE, formatTimestamp($entry->getVar('created')), $entry->getVar('contents'));
}

include XOOPS_ROOT_PATH . '/include/comment_new.php';
