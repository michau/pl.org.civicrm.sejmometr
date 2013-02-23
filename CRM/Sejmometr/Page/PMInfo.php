<?php

require_once 'CRM/Core/Page.php';
require_once 'CRM/Sejmometr/Utils/ParliamentMemeber.php';


class CRM_Sejmometr_Page_PMInfo extends CRM_Core_Page {

  function run() {
    $this->_contactId = CRM_Utils_Request::retrieve( 'cid', 'Positive', $this, true );

    $result = civicrm_api('Contact', 'Getsingle', array(
      'contact_id' => $this->_contactId,
      'contact_type' => 'Individual',
      'sequential' => 0,
      'version' => 3,
    ));
    
    $dataset = new ep_Dataset('poslowie');

    $member = $dataset->where( 'id', '=', $result['external_identifier'])->find_all();
    
    $this->assign('member', $member->data);

//    $associates = $member->wspolpracownicy()->find_all();
    $tpl_associates = array(); 
    foreach( $associates as $key => $associate) {
      $tpl_associates[$key] = $associate->data;
    }
    $this->assign('associates', $tpl_associates);

//    $club = $member->klub();

    // CRM_Core_Error::debug( $club );
    // CRM_Core_Error::debug( $associates );
    
    parent::run();
  }
}
