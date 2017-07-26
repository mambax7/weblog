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
 * @copyright    XOOPS Project https://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @package
 * @since
 * @author       XOOPS Development Team, Kazumi Ono (AKA onokazu)
 */

/**
 * A text field with calendar popup
 *
 * @package     kernel
 * @subpackage  form
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 */
// tohokuaiki change

class myXoopsFormTextDateSelect extends XoopsFormText
{
    public function __construct($caption, $name, $size = 15, $value = 0)
    {
        $value = !is_numeric($value) ? time() : (int)$value;
        parent::__construct($caption, $name, $size, 25, $value);
    }

    public function render()
    {
        global $xoopsTpl;
        $jstime = formatTimestamp('F j Y, H:i:s', $this->getValue());
        ob_start();
        require_once XOOPS_ROOT_PATH . '/include/calendarjs.php';
        $contents = ob_get_contents();
        ob_end_clean();
        $xoops_module_header = $xoopsTpl->get_template_vars('xoops_module_header') . $contents;
        $xoopsTpl->assign('xoops_module_header', $xoops_module_header);

        return "<input type='text' name='"
               . $this->getName()
               . "' id='"
               . $this->getName()
               . "' size='"
               . $this->getSize()
               . "' maxlength='"
               . $this->getMaxlength()
               . "' value='"
               . date('Y-m-d', $this->getValue())
               . "'"
               . $this->getExtra()
               . "><input type='reset' value=' ... ' onclick='return showCalendar(\""
               . $this->getName()
               . "\");'>";
    }
}
