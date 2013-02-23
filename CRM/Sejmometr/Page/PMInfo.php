<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Sejmometr/Utils/ParliamentMemeber.php';


class CRM_Sejmometr_Page_PMInfo extends CRM_Core_Page {

    function copydataaction() {
        $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, true);
        $civiParam = CRM_Utils_Request::retrieve('civi_param', 'Text', $this, true);
        $sejmParam = CRM_Utils_Request::retrieve('sejm_param', 'Text', $this, true);

        $contact = civicrm_api('Contact', 'Getsingle', array(
            'contact_id' => $contactId,
            'contact_type' => 'Individual',
            'sequential' => 0,
            'version' => 3,
                ));

        $dataset = new ep_Dataset('poslowie');
        $member = $dataset->where('id', '=', $contact['external_identifier'])->find_one();        
        
        $result = civicrm_api('Contact', 'Update', array(
            'id' => $contactId,
            $civiParam => $member->data[$sejmParam],
            'version' => 3,
                ));

        $url = CRM_Utils_System::url('civicrm/contact/view', 'action=browse&selectedChild=sejmometrTab&cid=' . $contactId
        );
        CRM_Utils_System::redirect($url);
    }

    function run() {
        $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, true);

        $result = civicrm_api('Contact', 'Getsingle', array(
            'contact_id' => $this->_contactId,
            'contact_type' => 'Individual',
            'sequential' => 0,
            'version' => 3,
                ));

        $dataset = new ep_Dataset('poslowie');

        $member = $dataset->where('id', '=', $result['external_identifier'])->find_one();

        $this->assign('contactID', $this->_contactId);
        $this->assign('member', $member->data);

        $associates = $member->wspolpracownicy()->find_all();
        $tpl_associates = array();
        foreach ($associates as $key => $associate) {
            $tpl_associates[$key] = $associate->data;
        }
        $this->assign('associates', $tpl_associates);

        //$club = $member->klub();

        parent::run();
    }

}
