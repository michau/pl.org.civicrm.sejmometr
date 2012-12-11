<?php

require_once 'CRM/Core/Page.php';

class CRM_Sejmometr_Page_Member extends CRM_Core_Page {
  function run() {
    CRM_Utils_System::setTitle(ts('Member'));
    
    $dataset = new ep_Dataset('poslowie');

    $member = $dataset->where( 'id', '=', '2')->find_one();

    //CRM_Core_Error::debug( $member );
    
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
