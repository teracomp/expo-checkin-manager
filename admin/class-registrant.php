<?php
//
// simple object to store needed data
//
class Registrant {
	public $form_id;
	public $gf_lead_id;
	public $group_name;
	public $seqnbr;
	public $group_total;
	public $firstname;
	public $lastname;
	public $email;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $phone;
	public $precon;
	public $checkedin;
	public $notes;
	public $paid;
	public $datasource;
	public $regtype;
	public $regreason;
	
	public function __construct( $id ) {
		$this->gf_lead_id = $id;
	}		
}

class RegFieldNumbers {
	public $group_name;
	public $total_grp_regs;
	public $total_ind_regs;
	public $seqnbr;	
	public $firstname; 
	public $lastname;
	public $email;
	public $address;
	public $city;
	public $state;
	public $zip;
	public $phone;
	public $precon;
	public $checkin;
	public $notes;
}