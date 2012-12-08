<?php

require_once 'CRM/Core/Page.php';

class CRM_Sejmometr_Page_Member extends CRM_Core_Page {
  function run() {
    CRM_Utils_System::setTitle(ts('Member'));
    
    $dataset = new ep_Dataset('poslowie');

    $member = $dataset->where( 'id', '=', '2')->find_one();

    $this->assign('member', $member->data);
    
    parent::run();
  }
}
