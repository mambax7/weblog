<?php
/**
 *
 * create weblog archive block
 * @author    hodaka <hodaka@hodaka.org>
 * @copyright hodaka <hodaka@hodaka.org>
 */

use Xmf\Module\Helper;

$moduleHelper = Helper::getHelper(basename(dirname(__DIR__)));
//$myModule = $moduleHelper->getModule();
$moduleDirName = $moduleHelper->getModule()->dirname();

if (!defined('WEBLOG_BLOCK_ARCHIVE_INCLUDED')) {
    define('WEBLOG_BLOCK_ARCHIVE_INCLUDED', 1);
    // $options[0] is always weblog dirname.

    function b_weblog_archive_show($options)
    {
        global $xoopsDB, $xoopsUser;
        global $xoopsConfig;

        $moduleDirName = $options[0];
        $numperblock   = $options[1];

        $offset     = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
        $user_id    = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
        $currentuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid', 'E') : 0;

        if (is_object($xoopsUser)) {
            $useroffset = $xoopsUser->timezone() - $xoopsConfig['server_TZ'];
        } else {
            $useroffset = $xoopsConfig['default_TZ'] - $xoopsConfig['server_TZ'];
        }

        if (file_exists(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/calendar.php')) {
            require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/calendar.php';
        } else {
            require_once XOOPS_ROOT_PATH . '/language/english/calendar.php';
        }
        $month_arr = [
            1  => _CAL_JANUARY,
            2  => _CAL_FEBRUARY,
            3  => _CAL_MARCH,
            4  => _CAL_APRIL,
            5  => _CAL_MAY,
            6  => _CAL_JUNE,
            7  => _CAL_JULY,
            8  => _CAL_AUGUST,
            9  => _CAL_SEPTEMBER,
            10 => _CAL_OCTOBER,
            11 => _CAL_NOVEMBER,
            12 => _CAL_DECEMBER
        ];

        // must adjust the selected time to server timestamp
        //$timeoffset = $useroffset - $xoopsConfig['server_TZ'];

        $sql = 'select FROM_UNIXTIME(created+' . $useroffset * 3600 . ", '%Y%m') as thismonth, count(*) as entries from " . $xoopsDB->prefix($moduleDirName);
        $sql .= " where private='N' or (private='Y' and user_id=$currentuid)";
        $sql .= ' group by thismonth';
        $sql .= ' order by thismonth DESC';

        $block = [];
        $count = $xoopsDB->getRowsNum($xoopsDB->query($sql));
        if (!$count) {
            return $block;
        }

        $lines = $xoopsDB->query($sql, $numperblock, $offset);

        $archives = [];
        $i        = 0;
        $months   = [];
        while ($line = $xoopsDB->fetchArray($lines)) {
            //$months[$i]['date'] = $line['thismonth']."00";
            $months[$i]['year']      = (string)substr($line['thismonth'], 0, 4);
            $months[$i]['month']     = (string)substr($line['thismonth'], 4, 2);
            $months[$i]['monthname'] = $month_arr[(int)substr($line['thismonth'], 4, 2)];
            $months[$i]['entries']   = $line['entries'];
            ++$i;
        }
        $archives['months'] = $months;
        // add page navigator if entries > per page
        if ($count > $numperblock) {
            if (!empty($_SERVER['QUERY_STRING'])) {
                if (preg_match("/^offset=[0-9]+$/", $_SERVER['QUERY_STRING'])) {
                    $url = '';
                } else {
                    $url = preg_replace("/^(.*)\&offset=[0-9]+$/", "$1", $_SERVER['QUERY_STRING']);
                }
            } else {
                $url = '';
            }
            require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
            $nav                    = new XoopsPageNav($count, $numperblock, $offset, 'offset', $url);
            $archives['navigation'] = $nav->renderNav();
        } else {
            $archives['navigation'] = '';
        }
        $archives['module_dir'] = $moduleDirName;
        $archives['currentuid'] = $currentuid;
        $archives['user_id']    = $user_id;

        $block['archives'] = $archives;

        return $block;
    }

    function b_weblog_archive_edit($options)
    {
        $moduleDirName = empty($options[0]) ? basename(dirname(__DIR__)) : $options[0];
        $form          = '<table>';
        $form          .= "<input type='hidden' name='options[]' value='$moduleDirName '>\n";
        $form          .= sprintf('<tr><td><b>%s</b>:</td><td><input type="text" name="options[]" value="%d"></td></tr>', _MB_WEBLOG_EDIT_ARCHIVE_NUMBER_PER_PAGE, (int)$options[1]);
        $form          .= '</table>';

        return $form;
    }

    function b_weblog_calendar_show($options)
    {
        global $xoopsDB, $xoopsUser;
        global $xoopsConfig, $xoopsTpl;

        $moduleDirName = $options[0];
        require_once XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/include/PEAR/Date/Calc.php';

        $currentuid = is_object($xoopsUser) ? $xoopsUser->getVar('uid', 'E') : 0;

        if (is_object($xoopsUser)) {
            $useroffset = $xoopsUser->timezone() - $xoopsConfig['server_TZ'];
        } else {
            $useroffset = $xoopsConfig['default_TZ'] - $xoopsConfig['server_TZ'];
        }

        // set when month
        $date = (isset($_GET['date']) && strlen((int)$_GET['date']) >= 6) ? (int)$_GET['date'] : '';
        if ($date > 0) {
            $month = substr($date, 0, 6);
        } else {
            $month = date('Ym', time() + $useroffset * 3600);
        }
        // get next/previous month and year
        $this_year  = substr((string)$month, 0, 4);
        $this_month = substr((string)$month, 4, 6);
        $date_Calc  = new Date_Calc();
        $month_next = $date_Calc->beginOfNextMonth('1', $this_month, $this_year, $format = '%Y%m');
        $month_prev = $date_Calc->beginOfPrevMonth('1', $this_month, $this_year, $format = '%Y%m');
        $year_next  = (string)($this_year + 1) . $this_month;
        $year_prev  = (string)($this_year - 1) . $this_month;

        if (file_exists(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/calendar.php')) {
            require_once XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/calendar.php';
        } else {
            require_once XOOPS_ROOT_PATH . '/language/english/calendar.php';
        }
        $month_arr = [
            1  => _CAL_JANUARY,
            2  => _CAL_FEBRUARY,
            3  => _CAL_MARCH,
            4  => _CAL_APRIL,
            5  => _CAL_MAY,
            6  => _CAL_JUNE,
            7  => _CAL_JULY,
            8  => _CAL_AUGUST,
            9  => _CAL_SEPTEMBER,
            10 => _CAL_OCTOBER,
            11 => _CAL_NOVEMBER,
            12 => _CAL_DECEMBER
        ];
        $week_arr  = [
            _MB_WEBLOG_LANG_SUNDAY,
            _MB_WEBLOG_LANG_MONDAY,
            _MB_WEBLOG_LANG_TUESDAY,
            _MB_WEBLOG_LANG_WEDNESDAY,
            _MB_WEBLOG_LANG_THURSDAY,
            _MB_WEBLOG_LANG_FRIDAY,
            _MB_WEBLOG_LANG_SATURDAY
        ];

        // get one month calendar array
        require_once XOOPS_ROOT_PATH . '/modules/' . $moduleDirName . '/class/class.calendar.php';
        $mycalendar = new MyCalendar($month);
        $calendar   = $mycalendar->dispCalendar();

        $calendar['lang_monthPrev']     = _MB_WEBLOG_LANG_PREVMONTH;
        $calendar['lang_monthNext']     = _MB_WEBLOG_LANG_NEXTMONTH;
        $calendar['lang_yearPrev']      = _MB_WEBLOG_LANG_PREVYEAR;
        $calendar['lang_yearNext']      = _MB_WEBLOG_LANG_NEXTYEAR;
        $calendar['lang_month']         = $month_arr[(int)$calendar['month']];
        $calendar['lang_ShowPrevMonth'] = _MB_WEBLOG_LANG_PREVMONTH_TITLE;
        $calendar['lang_ShowNextMonth'] = _MB_WEBLOG_LANG_NEXTMONTH_TITLE;
        $calendar['lang_ShowPrevYear']  = _MB_WEBLOG_LANG_PREVYEAR_TITLE;
        $calendar['lang_ShowNextYear']  = _MB_WEBLOG_LANG_NEXTYEAR_TITLE;
        $calendar['lang_ShowThisMonth'] = _MB_WEBLOG_LANG_THIS_MONTH_TITLE;
        $calendar['dayofweek']          = $week_arr;
        // override
        $calendar['monthThis'] = $this_year . $this_month;
        $calendar['monthPrev'] = $month_prev;
        $calendar['monthNext'] = $month_next;
        $calendar['yearPrev']  = $year_prev;
        $calendar['yearNext']  = $year_next;

        // add xoops_block_header for css file
        $xoops_block_header = $xoopsTpl->get_template_vars('xoops_block_header');
        $xoops_block_header .= '<link rel="stylesheet" type="text/css" media="screen" href="' . XOOPS_URL . '/modules/' . $moduleDirName . '/weblog_block.css">';
        $xoopsTpl->assign('xoops_block_header', $xoops_block_header);

        if (!empty($_SERVER['QUERY_STRING'])) {
            if (preg_match("/^calMonth=[0-9]{10}$/", $_SERVER['QUERY_STRING'])) {
                $query_string = '?';
            } else {
                $query_string = '?' . preg_replace("/(.*)\&calMonth=[0-9]{10}$/", "$1", $_SERVER['QUERY_STRING']) . '&';
            }
        } else {
            $query_string = '?';
        }
        $calendar['action_url'] = $_SERVER['PHP_SELF'] . $query_string;

        // set the month
        $yearmonth             = date('Ym', $calendar['monthThis']);
        $calendar['yearmonth'] = $yearmonth;

        // get entries of the month
        $sql = 'select FROM_UNIXTIME(created+' . $useroffset * 3600 . ", '%d') as day, blog_id from " . $xoopsDB->prefix($moduleDirName);
        $sql .= ' where (FROM_UNIXTIME(created+' . $useroffset * 3600 . ", '%Y%m') = " . $month . ') ';
        $sql .= " AND (private='N' or (private='Y' and user_id=$currentuid))";
        $sql .= ' group by day ';
        $sql .= ' order by day ASC';
        //echo $sql ;
        $lines = $xoopsDB->query($sql);

        $entries = [];
        if ($lines) {
            while (list($day, $blog_id) = $xoopsDB->fetchRow($lines)) {
                //          $entries[$blog_id] = (int)($day);
                $entries[(int)$day] = $this_year . $this_month . $day;
            }
        } else {
            return $block['calendar'] = $calendar;
        }
        $days = array_keys($entries);            // make array of day
        //  $counts = array_count_values($days);    // make day=>count array
        //  $entries = array_flip($entries);        // make day=>blog_id array

        // week number of 1st day of this month
        $firstcol = date('w', mktime(0, 0, 0, $this_month, 1, $this_year));
        // insert entry count corresponding to the day
        foreach ($entries as $day => $yyyymmdd) {
            $row                             = ceil(($day + $firstcol) / 7) - 1;
            $col                             = date('w', mktime(0, 0, 0, $this_month, $day, $this_year));
            $calendar['details'][$row][$col] = $yyyymmdd;
        }

        // optional variables in case you replace prev and next month to the months posted any entries
        // prev month to show
        /*  $sql = "select FROM_UNIXTIME(created, '%Y%m') as prevmonth from ".$xoopsDB->prefix($moduleDirName );
            $sql .= " where (private='N' or (private='Y' and user_id=$currentuid))";
            $sql .= " and FROM_UNIXTIME(created, '%Y%m') < $yearmonth";
            $sql .= " group by prevmonth";
            $sql .= " order by prevmonth DESC";
            $sql .= " limit 0, 1";
            $result = $xoopsDB->query($sql);
            if ($result) {
                list($calendar['prevMonthPosted']) = $xoopsDB->fetchRow($result);
            } else {
                $calendar['prevMonthPosted'] = "";
            }*/
        // next month to show
        /*  if ( $yearmonth < date( 'Ym', time() ) ) {
                $sql = "select FROM_UNIXTIME(created, '%Y%m') as nextmonth from ".$xoopsDB->prefix($moduleDirName );
                $sql .= " where (private='N' or (private='Y' and user_id=$currentuid))";
                $sql .= " and FROM_UNIXTIME(created, '%Y%m') > $yearmonth";
                $sql .= " group by nextmonth";
                $sql .= " order by nextmonth ASC";
                $sql .= " limit 0, 1";
                $result = $xoopsDB->query($sql);
                if ($result) {
                    list($calendar['nextMonthPosted']) = $xoopsDB->fetchRow($result);
                } else {
                    $calendar['nextMonthPosted'] = "";
                }
            } else {
                $calendar['nextMonthPosted'] = "";
            }*/

        $calendar['moduledir']   = $moduleDirName;
        $calendar['calblockcss'] = 'db:' . $moduleDirName . '_calblock.css.tpl';
        $calendar['user_id']     = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
        $block['calendar']       = $calendar;

        return $block;
    }

    function b_weblog_calendar_edit($options)
    {
        $moduleDirName = empty($options[0]) ? basename(dirname(__DIR__)) : $options[0];
        $form          = "<input type='hidden' name='options[]' value='$moduleDirName '>\n";

        return $form;
    }
}
