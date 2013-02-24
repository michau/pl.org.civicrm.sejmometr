<?php

require_once 'sejmometr.civix.php';
require_once('packages/ePF_API/ep_API.php');

/**
 * Implementation of hook_civicrm_config
 */
function sejmometr_civicrm_config(&$config) {
    _sejmometr_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function sejmometr_civicrm_xmlMenu(&$files) {
    _sejmometr_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function sejmometr_civicrm_install() {
    return _sejmometr_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function sejmometr_civicrm_uninstall() {
    return _sejmometr_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function sejmometr_civicrm_enable() {
    return _sejmometr_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function sejmometr_civicrm_disable() {
    return _sejmometr_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function sejmometr_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
    return _sejmometr_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function sejmometr_civicrm_managed(&$entities) {
    return _sejmometr_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_tabs
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function sejmometr_civicrm_tabs(&$tabs, $contactID) {

    $contact = civicrm_api('Contact', 'Getsingle', array(
        'contact_id' => $contactID,
        'contact_type' => 'Individual',
        'sequential' => 0,
        'version' => 3,
            ));

    // TODO: This is draft, do it properly
    $pmContactType = 'Posel';
    
    if (in_array($pmContactType, $contact['contact_sub_type'] )) {
        if (!sejmometr_validate_configuration()) {
            $url = CRM_Utils_System::url('civicrm/sejmometr/configurationinfo', "reset=1&snippet=1&force=1&cid=$contactID");
        } elseif (empty($contact['external_identifier'])) {
            $url = CRM_Utils_System::url('civicrm/sejmometr/associate', "reset=1&snippet=1&force=1&cid=$contactID");
        } else {
            $url = CRM_Utils_System::url('civicrm/sejmometr/parliamentmemberinfo', "reset=1&snippet=1&force=1&cid=$contactID");
        }

        $tabs[] = array('id' => 'sejmometrTab',
            'url' => $url,
            'title' => 'Sejmometr',
            'weight' => 300);
    }
}

/**
 * Validate eP_API configuration
 *
 */
function sejmometr_validate_configuration() {

    if (!defined('eP_API_KEY') || eP_API_KEY == "") {
        return false;
    }
    if (!defined('eP_API_SECRET') || eP_API_SECRET == "") {
        return false;
    }
    return true;
}