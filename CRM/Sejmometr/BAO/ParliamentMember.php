<?php

/*
 * CRM_Sejmometr_BAO_ParliamentMember class.
 */

class CRM_Sejmometr_BAO_ParliamentMember {

    private $_member = null;
    private $_dataSet = null;
    private $_mpMapping = array(
        'first_name' => 'imie_pierwsze',
        'middle_name' => 'imie_drugie',
        'last_name' => 'nazwisko',
        'birth_date' => 'data_urodzenia',
    );
    public $id = null;
    public $sejmometrId = null;
    public $commissions = null;
    public $associates = null;

    /*
     * class constructor
     */

    function __construct($id) {

        $this->id = $id;

        $result = civicrm_api('Contact', 'Getsingle', array(
            'contact_id' => $this->id,
            'contact_type' => 'Individual',
            'sequential' => 0,
            'version' => 3,
                ));

        if (isset($result['external_identifier'])
                && !empty($result['external_identifier'])) {

            $this->sejmometrId = $result['external_identifier'];
            $this->_dataset = new ep_Dataset('poslowie');
            $this->_member = $this->_dataset->where('id', '=', $this->sejmometrId)->find_one();
            if ($this->_member) {
                $this->data = $this->_member->data;
                $this->sejmometrName = $this->data['nazwa'];
                foreach ($this->_mpMapping as $civiField => $sejmometrField) {
                    $this->$civiField = $this->data[$sejmometrField];
                }
            }
        }
    }

    /*
     * Copies PM related Sejmometr data into CiviCRM
     * 
     * TODO phpdoc
     */
    public function copyData($param_name, $object_id = null) {
        // first see if we're copying property
        if ($this->verifyPropertyParam($param_name)) {
            $result = civicrm_api('Contact', 'Update', array(
                'id' => $this->id,
                $param_name => $this->$param_name,
                'version' => 3,
                    ));
            if( $result['is_error']) {
                CRM_Core_Error::fatal('Something went wrong when copying data.');
            }
        } else {
            switch ($param_name) {
                case 'associate':
                    // fire off associates property population
                    $dc = $this->associates();
                    if( isset( $this->associates[$object_id] )) {
                        $this->associates[$object_id]->copySelf();
                    } else {
                        CRM_Core_Error::fatal('Wrong associate ID');
                    }
                    break;
                case 'commission':
                    var_dump('copying commission');
                    drupal_exit();
                    break;
                case 'club':
                    var_dump('copying club');
                    drupal_exit();                    
                    break;
                default:
                    // bail out if parameter is wrong
                    CRM_Core_Error::fatal('Copy data unsuccessful - wrong param.');
            }
        }
    }

    /*
     * Verifies if civicrm API contact property has relevant
     * Sejmometr object property.
     * 
     * TODO phpdoc
     */

    public function verifyPropertyParam($param_name) {
        if (array_key_exists($param_name, $this->_mpMapping)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * Translates the name of civicrm API contact property 
     * into Sejmometr object property.
     * 
     * TODO phpdoc
     */

    public function translateCopyParam($param_name) {
        // verify just to be safe
        if ($this->verifyPropertyParam($param_name)) {
            return $this->_mpMapping[$param_name];
        } else {
            // bail out if parameter is wrong
            CRM_Core_Error::fatal('Wrong parameter for copyURL');
        }
    }

    /*
     * Builds URL for copy action.
     * 
     * TODO phpdoc
     */

    public function buildCopyURL($param_name) {
        $copyurl = 'civicrm/sejmometr/copydataaction';
        $cid = $this->id;
        $queryString = "cid=$cid&copy_param=$param_name";
        return CRM_Utils_System::url($copyurl, $queryString);
    }

    /*
     * Returns the list of Parliament Member Associates.
     * 
     * TODO phpdoc
     */

    public function associates() {
        if (is_null($this->associates)) {
            require_once 'CRM/Sejmometr/BAO/ParliamentMemberAssociate.php';
            $associates = $this->_member->wspolpracownicy()->find_all();
            foreach ($associates as $associate) {
                $this->associates[$associate->id] = new CRM_Sejmometr_BAO_ParliamentMemberAssociate($associate, $this->id);
            }
        }
        return $this->associates;
    }

    public function getClub() {
        if (!empty($this->data['klub_id'])) {
            $dataset = new ep_Dataset('sejm_kluby');
            $klub = $dataset->where('id', '=', $this->data['klub_id'])->find_one();
            if ($klub) {
                $this->parliamentary_club = $klub->data['nazwa'];
            }
        }
    }

    public function getCommissions() {
        if (is_null($this->commissions)) {
            $this->commissions = $this->_member->komisje_stanowiska()->find_all();
            foreach ($this->commissions as $key => $commissionParticipation) {
                $this->commissions[$key]->commission = $commissionParticipation->komisja();
            }
        }
        return $this->commissions;
    }

}
