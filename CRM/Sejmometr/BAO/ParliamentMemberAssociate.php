<?php

/*
 * CRM_Sejmometr_BAO_ParliamentMemberAssociate class.
 */
class CRM_Sejmometr_BAO_ParliamentMemberAssociate {

    public $sejmometrId = null;
    public $sejmometrName = null;
    public $pmSejmometrId = null;
    public $pmCiviId = null;
    private $_associateMapping = array(
        'first_name' => null, // needs to be built in constructor
        'last_name' => null, // needs to be built in constructor
        'job_position' => 'funkcja',
    );
    /*
     * class constructor
     */

    function __construct($pmAssociateObject, $pmId) {

        dpm( $pmAssociateObject);
        
        $this->sejmometrId = $pmAssociateObject->id;
        $this->sejmometrName = $pmAssociateObject->data['nazwa'];
        $this->pmSejmometrId = $pmAssociateObject->data['posel_id'];
        $this->pmCiviId = $pmId;
        $this->job_title = $pmAssociateObject->data['funkcja'];
        
        // assuming the first element is first name, the rest is the rest :-)
        $nameElements = explode(" ", $this->sejmometrName);        
        $this->first_name = $nameElements[0];
        $this->last_name = implode(" ", array_slice($nameElements, 1));
        
        if( empty($this->sejmometrName) ) {
            $this->first_name = t("ERROR IN SEJMOMETR DATA");
        }

    }

   /*
    * Translates the name of civicrm API contact property 
    * into Sejmometr object property.
    * 
    * TODO phpdoc
    */
    public function copySelf() {
        $existing = civicrm_api('Contact', 'Getsingle', array(
            'external_identifier' => $this->sejmometrId,
            'contact_type' => 'Individual',
            'sequential' => 0,
            'version' => 3,
                ));
        if( $existing['count'] == 0 ) {
            // new contact
            var_dump( $existing );
        } else {
            // exists
            var_dump( $existing );
        }

        drupal_exit();
    }

   /*
    * Builds URL for copy action.
    * 
    * TODO phpdoc
    */    
    public function buildCopyURL() {
        $copyurl = 'civicrm/sejmometr/copydataaction';
        $cid = $this->pmCiviId;
        $queryString = "cid=$cid&copy_param=associate&copied_object=$this->sejmometrId";
        return CRM_Utils_System::url($copyurl, $queryString);
    }

}
