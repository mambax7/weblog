<?php
// System Constants (Don't Edit) -> ../config.php
/*
define( "GPERM_POSTABLE" , 1 ) ;
define( "GPERM_EDITABLE" , 2 ) ;
define( "GPERM_DELETABLE" , 4 ) ;
define( "GPERM_VIEWABLE" , 8 ) ;
*/
require_once __DIR__ . '/../../../include/cp_header.php';
require_once __DIR__ . '/mygrouppermform.php';
require_once __DIR__ . '/../include/gtickets.php';
require_once __DIR__ . '/../header.php';
//include_once( __DIR__ . '/../include/read_configs.php' ) ;
require_once __DIR__ . '/admin_header.php';

// check $xoopsModule
if (!is_object($xoopsModule)) {
    redirect_header("$mod_url/", 1, _NOPERM);
}

// language files
require_once XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php';

function list_groups()
{
    global $xoopsModule;

    $global_perms_array = array(
        //      GPERM_POSTABLE => _AM_WEBLOG_PRIV_POST ,
        WEBLOG_PERMIT_EDIT       => _AM_WEBLOG_PRIV_EDIT,
        //      GPERM_DELETABLE => _AM_WEBLOG_PRIV_DELETE ,
        WEBLOG_PERMIT_READINDEX  => _AM_WEBLOG_PRIV_READINDEX,
        WEBLOG_PERMIT_READDETAIL => _AM_WEBLOG_PRIV_READDETAIL
    );

    /*
        $global_perms_array = array(
            GPERM_INSERTABLE => _ALBM_GPERM_G_INSERTABLE ,
            GPERM_SUPERINSERT | GPERM_INSERTABLE => _ALBM_GPERM_G_SUPERINSERT ,
    //      GPERM_EDITABLE => _ALBM_GPERM_G_EDITABLE ,
            GPERM_SUPEREDIT | GPERM_EDITABLE => _ALBM_GPERM_G_SUPEREDIT ,
    //      GPERM_DELETABLE => _ALBM_GPERM_G_DELETABLE ,
            GPERM_SUPERDELETE | GPERM_DELETABLE => _ALBM_GPERM_G_SUPERDELETE ,
            GPERM_RATEVIEW => _ALBM_GPERM_G_RATEVIEW ,
            GPERM_RATEVOTE | GPERM_RATEVIEW => _ALBM_GPERM_G_RATEVOTE
        ) ;
    */
    $form = new MyXoopsGroupPermForm('', $xoopsModule->mid(), 'weblog_global', _AM_WEBLOG_GROUPPERM_GLOBALDESC);
    foreach ($global_perms_array as $perm_id => $perm_name) {
        $form->addItem($perm_id, $perm_name);
    }

    echo $form->render();
}

if (!empty($_POST['submit'])) {
    include __DIR__ . '/mygroupperm.php';
    redirect_header(XOOPS_URL . '/modules/' . $xoopsModule->dirname() . '/admin/groupperm_global.php', 1, _AM_WEBLOG_GPERMUPDATED);
}

xoops_cp_header();
//include( './mymenu.php' ) ;
echo '';
//echo "<h3 style='text-align:left;'>".$xoopsModule->name()."</h3>\n" ;
$adminObject = \Xmf\Module\Admin::getInstance();
$adminObject->displayNavigation(basename(__FILE__));
echo "<h4 style='text-align:left;'>" . _AM_WEBLOG_GROUPPERM_GLOBAL . "</h4>\n";
echo _AM_WEBLOG_PRIVMANAGER_XOOPS_CAUTION . '<br>';
list_groups();
xoops_cp_footer();
