<?php

require_once 'CRM/Core/Page.php';

class CRM_Sejmometr_Page_ParliamentMemberInfo extends CRM_Core_Page {
  function run() {
    $this->_contactId = CRM_Utils_Request::retrieve( 'cid', 'Positive', $this, true );

    $result = civicrm_api('Contact', 'Getsingle', array(
      'contact_id' => $this->_contactId,
      'contact_type' => 'Individual',
      'sequential' => 0,
      'version' => 3,
    ));
    CRM_Core_Error::debug( $result['first_name'] );
    
    $dataset = new ep_Dataset('poslowie');

    $member = $dataset->where( 'imie_pierwsze', '=', $result['first_name'])->where( 'nazwisko', '=', $result['last_name'])->find_all();

    CRM_Core_Error::debug( $member );
    
    $this->assign('member', $member->data);

    $associates = $member->wspolpracownicy()->find_all();
    $tpl_associates = array(); 
    foreach( $associates as $key => $associate) {
      $tpl_associates[$key] = $associate->data;
    }
    $this->assign('associates', $tpl_associates);

    $club = $member->klub();

    // CRM_Core_Error::debug( $club );
    // CRM_Core_Error::debug( $associates );
    
    parent::run();
  }
}
