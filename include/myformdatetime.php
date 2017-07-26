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
 * Date and time selection field
 *
 * @author      Kazumi Ono  <onokazu@xoops.org>
 * @copyright   copyright (c) 2000-2003 XOOPS.org
 *
 * @package     kernel
 * @subpackage  form
 */
// tohokuaiki change
class myXoopsFormDateTime extends XoopsFormElementTray
{
    public function __construct($caption, $name, $size = 15, $value = 0)
    {
        parent::__construct($caption, '&nbsp;');
        $value    = (int)$value;
        $value    = ($value > 0) ? $value : time();
        $datetime = getdate($value);
        $this->addElement(new myXoopsFormTextDateSelect('', $name . '[date]', $size, $value));
        $timearray = array();
        for ($i = 0; $i < 24; ++$i) {
            for ($j = 0; $j < 60; $j = $j + 10) {
                $key             = ($i * 3600) + ($j * 60);
                $timearray[$key] = ($j != 0) ? $i . ':' . $j : $i . ':0' . $j;
            }
        }
        ksort($timearray);
        $timeselect = new XoopsFormSelect('', $name . '[time]', $datetime['hours'] * 3600 + 600 * ceil($datetime['minutes'] / 10));
        $timeselect->addOptionArray($timearray);
        $this->addElement($timeselect);
    }
}
