<?php

require_once 'CRM/Core/Page.php';

/*
 * Sejmometr configuration info page. 
 * Display warnings if eP api configuration is not set.
 */
class CRM_Sejmometr_Page_ConfigurationInfo extends CRM_Core_Page {


  function run() {
  
     if(!defined('eP_API_KEY') || eP_API_KEY == "") {
      $this->assign('eP_API_KEY_message', "eP_API_KEY not found. <br/>Please register on <a href='http://sejmometr.pl'>http://sejmometr.pl</a> generate your API Key and define as eP_API_KEY in packages/eP_API/ep_API.php file. More on <a href='http://sejmometr.pl'>http://sejmometr.pl/api</a>.");
     } else {
      $this->assign('eP_API_KEY_message', "Your eP_API_KEY is: ".eP_API_KEY);      
     }
     if(!defined('eP_API_SECRET') || eP_API_SECRET == "") {
      $this->assign('eP_API_SECRET_message', "eP_API_SECRET not found. <br/>Please register on <a href='http://sejmometr.pl'>http://sejmometr.pl</a> generate your API Secret and define as eP_API_KEY in packages/eP_API/ep_API.php file. More on <a href='http://sejmometr.pl'>http://sejmometr.pl/api</a>.");      
     } else {
      $this->assign('eP_API_SECRET_message', "Your eP_API_SECRET is: ".eP_API_SECRET);      
     }
     
     parent::run();
  }

}
