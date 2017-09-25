<?php
/*
 *
 * Copyright (c) 2005 by ITOH Takashi(http://tohokuaiki.jp/)
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
 *
 */

require_once XOOPS_ROOT_PATH . '/kernel/object.php';

$moduleDirName = basename(dirname(__DIR__));

if (!class_exists('WeblogTrackbackBase')) {
    class WeblogTrackbackBase extends XoopsObject
    {
        public $moduleDirName = '';     // abstruct

        /**
         * Constructs an instance of this class
         */
        public function __construct()
        {
            parent::__construct();

            $this->initVar('blog_id', XOBJ_DTYPE_INT, 0, false);
            $this->initVar('tb_url', XOBJ_DTYPE_TXTBOX, null, true);
            $this->initVar('blog_name', XOBJ_DTYPE_TXTBOX, null, false);
            $this->initVar('title', XOBJ_DTYPE_TXTBOX, null, false);
            $this->initVar('description', XOBJ_DTYPE_TXTBOX, null, false);
            $this->initVar('link', XOBJ_DTYPE_TXTBOX, null, false);
            $this->initVar('direction', XOBJ_DTYPE_TXTBOX, null, false);
            $this->initVar('trackback_created', XOBJ_DTYPE_INT, 0, false);
        }

        public function check_url()
        {
            if (!$tb_url = $this->getVar('tb_url')) {
                return false;
            }
            $url_array = parse_url($tb_url);
            if ('http' == $url_array['scheme'] && $url_array['host'] && $url_array['path']) {
                return true;
            }

            return false;
        }
    }

    class WeblogTrackbackHandlerBase extends XoopsObjectHandler
    {
        public $moduleDirName = '';     // abstruct

        public function &create()
        {
            return new WeblogTrackbackBase();   // abstruct
        }

        public function &get($blog_id, $direction = '')
        {
            $blog_id  = (int)$blog_id;
            $criteria = new CriteriaCompo(new Criteria('blog_id', $blog_id));
            if ($direction) {
                $criteria->add(new Criteria('direction', $direction));
            }

            if ($blog_id > 0) {
                $sql = sprintf('SELECT blog_id, tb_url, blog_name, title, description, link, direction,trackback_created FROM %s WHERE %s ORDER BY trackback_created DESC', $this->db->prefix($this->moduleDirName . '_trackback'), $criteria->render());
                if ($result = $this->db->query($sql)) {
                    $trackback_array = [];
                    while ($trackback_data = $this->db->fetchArray($result)) {
                        $trackback_obj = $this->create();
                        $trackback_obj->assignVars($trackback_data);
                        array_push($trackback_array, $trackback_obj);
                    }

                    return $trackback_array;
                }
            }

            return false;
        }

        // return tackbackurls string quoted by "\n" from DB->weblog_trackback
        public function &getTrackbackurl_string($blog_id, $direction = '')
        {
            $ent_trackback   = '';
            $trackback_array =& $this->get($blog_id, $direction);
            if ($trackback_array && is_array($trackback_array)) {
                $ent_trackback = '';
                foreach ($trackback_array as $trackback_obj) {
                    $ent_trackback .= $trackback_obj->getVar('tb_url', 'n') . "\n";
                }
                $ent_trackback = trim($ent_trackback);
            }

            return $ent_trackback;
        }

        public function insert(XoopsObject $trackback)
        {
            //ORGINAL
            //if (strtolower(get_parent_class($trackback)) != 'weblogtrackbackbase') {  // php-5< must be lowercase only
            //    $trackback->setErrors("Object isn't a sub-class of WeblogTrackbackBase");   // for test hodaka
            //    return false;
            //}

            //NEW
            if ('weblogtrackbackbase' != get_parent_class($trackback)) {  // must be lowercase only
                $trackback->setErrors("Object isn't a sub-class of WeblogTrackbackBase");    // trapped by hodaka

                return false;
            }

            if (!$trackback->isDirty()) {
                return true;
            }
            if (!$trackback->cleanVars()) {
                $trackback->setErrors('Sanitization failed');   // for test hodaka

                return false;
            }

            foreach ($trackback->cleanVars as $k => $v) {
                ${$k} = $v;
            }

            $criteria = new CriteriaCompo(new Criteria('blog_id', $blog_id));
            $criteria->add(new Criteria('tb_url', $tb_url));
            $count             = $this->getCount($criteria);
            $trackback_created = time();
            if ($blog_id > 0 && $count > 0) {
                $sql = sprintf(
                    'UPDATE %s SET blog_name=%s, title=%s, description=%s, link=%s, direction=%s,trackback_created=%d WHERE blog_id=%d AND tb_url=%s',
                    $this->db->prefix($this->moduleDirName . '_trackback'),
                    $this->db->quoteString($blog_name),
                    $this->db->quoteString($title),
                               $this->db->quoteString($description),
                    $this->db->quoteString($link),
                    $this->db->quoteString($direction),
                    $blog_id,
                    $this->db->quoteString($tb_url),
                    $trackback_created
                );
            } else {
                $sql = sprintf(
                    'INSERT INTO %s (blog_id, tb_url, blog_name, title, description, link, direction, trackback_created) VALUES (%d, %s, %s, %s, %s, %s, %s, %d)',
                    $this->db->prefix($this->moduleDirName . '_trackback'),
                    $blog_id,
                    $this->db->quoteString($tb_url),
                               $this->db->quoteString($blog_name),
                    $this->db->quoteString($title),
                    $this->db->quoteString($description),
                    $this->db->quoteString($link),
                    $this->db->quoteString($direction),
                    $trackback_created
                );
            }
            if (!$result = $this->db->queryF($sql)) {  // must be query()
                $trackback->setErrors('Failed DB query');   // for test hodaka

                return false;
            } elseif (1 != $this->db->getAffectedRows()) {
                $trackback->setErrors('No databse record updated');    // for test by hodaka

                return false;
            }

            return true;
        }

        public function delete(XoopsObject $trackback)
        {
            if ('weblogtrackbackbase' != strtolower(get_parent_class($trackback))) {
                return false;
            }
            $criteria = new CriteriaCompo(new Criteria('blog_id', $trackback->getVar('blog_id')));
            if ($trackback->getVar('tb_url')) {
                $criteria->add(new Criteria('tb_url', $trackback->getVar('tb_url')));
            }
            if ($trackback->getVar('direction')) {
                $criteria->add(new Criteria('direction', $trackback->getVar('direction')));
            }

            $sql = sprintf('DELETE FROM %s %s ', $this->db->prefix($this->moduleDirName . '_trackback'), $criteria->renderWhere());
            if (!$result = $this->db->query($sql)) {  // must be query()

                return false;
            }

            return true;
        }

        public function getCount($criteria = null)
        {
            $sql = sprintf('SELECT count(*) AS count FROM %s', $this->db->prefix($this->moduleDirName . '_trackback'));
            if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
                $sql .= sprintf(' %s', $criteria->renderWhere());
            }
            if (!$result = $this->db->query($sql)) {
                return 0;
            }
            $count = $this->db->fetchArray($result);

            return $count['count'];
        }
    }
}

// for module duplicate
$entry_class = (string)(ucfirst($moduleDirName) . 'Trackback');
if (!defined($entry_class)) {
    define($entry_class, 'DEFINED CLASS');
    eval('
    class ' . ucfirst($GLOBALS['moduleDirName']) . 'Trackback extends WeblogTrackbackBase{
        var $moduleDirName ="' . $GLOBALS['moduleDirName'] . '" ;
        function __construct() {
                parent::__construct() ;
        }
    }
');

    eval('
    class ' . ucfirst($GLOBALS['moduleDirName']) . 'TrackbackHandler extends WeblogTrackbackHandlerBase{
        var $moduleDirName ="' . $GLOBALS['moduleDirName'] . '" ;
        function &create() {
            return new ' . ucfirst($GLOBALS['moduleDirName']) . 'Trackback();
        }
    }
');
}
