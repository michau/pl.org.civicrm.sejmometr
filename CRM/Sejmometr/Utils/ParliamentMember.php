<?php

/*
 * ParliamentMemeber Class. 
 * Implements eP_Posel class.
 */
class CRM_Sejmometr_Utils_ParliamentMember {

  public $id;

  public $first_name;

  public $middle_name;
  
  public $last_name;
 
  public $display_name;
 
  public $birth_date;

  public $parliamentary_club;
  
  public $collaborators;

  public $commisions;
  
  public $member;

  /*
   * class constructor
   */
  function __construct( $id )
  {

    $this->id = $id;
    $dataset = new ep_Dataset( 'poslowie' );
    $member = $dataset->where( 'id', '=', $this->id)->find_one(); 
    
    if( $member ) {
      $this->data = $member->data;
      $this->first_name = $this->member['imie_pierwsze'];
      $this->middle_name = $this->member['imie_drugie'];    
      $this->last_name = $this->member['nazwisko'];
      $this->display_name = $this->member['nazwa'];
      $this->birth_date = $this->member['data_urodzenia'];
      $this->collaborators = $member->wspolpracownicy()->find_all();

      if(!empty($this->member['klub_id'])) {
        $dataset = new ep_Dataset( 'sejm_kluby' );
        $klub = $dataset->where( 'id', '=', $this->member['klub_id'])->find_one();
        if( $klub ) {  
          $this->parliamentary_club = $klub->data['nazwa'];   
        }
      }
     
      $dataset = new ep_Dataset( 'poslowie_komisje_stanowiska' );
      $this->commisions = $dataset->where( 'posel_id', '=', $this->id)->find_all();

    }    
  }  

  function get( $field_name ) {
    return isset($this->member["$field_name"]) ? $this->member["$field_name"] : NULL; 
  }

}
