<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Sejmometr/BAO/ParliamentMember.php';

class CRM_Sejmometr_Page_PMInfo extends CRM_Core_Page {

    function copydataaction() {
        $cid = CRM_Utils_Request::retrieve('cid', 'Positive', $this, true);
        $copyParam = CRM_Utils_Request::retrieve('copy_param', 'Text', $this, true);
        $copiedObject = CRM_Utils_Request::retrieve('copied_object', 'Text', $this, true);

        $member = new CRM_Sejmometr_BAO_ParliamentMember($cid);
        $member->copyData( $copyParam, $copiedObject );
        
        $url = CRM_Utils_System::url('civicrm/contact/view', 
                'action=browse&selectedChild=sejmometrTab&cid=' . $cid);
        CRM_Utils_System::redirect($url);
    }

    function run() {

        $cid = CRM_Utils_Request::retrieve('cid', 'Positive', $this, true);
        $pm = new CRM_Sejmometr_BAO_ParliamentMember($cid);
        $this->assign('pm', $pm);

        $pm->associates();
        dpm($pm);
        
        parent::run();
    }

}
