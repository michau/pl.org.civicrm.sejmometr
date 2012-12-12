<?php

require_once 'CRM/Core/Page.php';

class CRM_Sejmometr_Page_AssociateParliamentMember extends CRM_Core_Page {

  function associateaction() {
    $contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, true);
    $sejmid = CRM_Utils_Request::retrieve('sejmid', 'Positive', $this, true);

    var_dump( $contactId);
    
    $result = civicrm_api('Contact', 'Update', array(
      'id' => $contactId,
      'external_identifier' => "$sejmid",
      'version' => 3,
    ));
    
        $contact = civicrm_api('Contact', 'Getsingle', array(
      'contact_id' => $contactId,
      'contact_type' => 'Individual',
      'sequential' => 0,
      'version' => 3,
        ));
    
    var_dump($contact);
    
  }

  function run() {
    $this->_contactId = CRM_Utils_Request::retrieve('cid', 'Positive', $this, true);
    $this->assign('contactID', $this->_contactId);
    $result = civicrm_api('Contact', 'Getsingle', array(
      'contact_id' => $this->_contactId,
      'contact_type' => 'Individual',
      'sequential' => 0,
      'version' => 3,
        ));

    $first_name = $result['first_name'];
    $last_name = $result['last_name'];
    $full_name = $first_name . ' ' . $last_name;
    $this->assign('fullName', $full_name);

    $dataset = new ep_Dataset('poslowie');
    $members = $dataset->where('nazwa', '=', $full_name)->find_all();
    if (empty($members)) {
      $this->assign('notFound', TRUE);

      $others_by_first_name = $dataset->where('imie_pierwsze', '=', $result['first_name'])->find_all();
      $this->assign('othersByFirstName', $others_by_first_name);
      $others_by_last_name = $dataset->where('nazwisko', '=', $result['last_name'])->find_all();
      $this->assign('othersByLastName', $others_by_last_name);
    }
    else {
      $this->assign('notFound', FALSE);
      $this->assign('members', $members);
    }

    parent::run();
  }

}
