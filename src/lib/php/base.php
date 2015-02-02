<?php
class Base {	
	private $maintenance;	
	private $debug;
	private $error; 
	private $db_table;
	private $db_measure_table;
	
	public $bodyclass;
	public $device_type;
	public $client_outdated;
	public $client_error;
	public $fb_iphone;
	public $vars;
	public $detect;

	public function __construct(){	
		//direct calls safety	
		if((!defined('checkup') && $_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest') ):		
			die('Direct access not permitted');		
		endif;
		
		$this->debug=true;
		$this->debug();		
		$this->db_measure_table='ng_stats'; 		
		$this->db_connect();	
									
		require_once 'Mobile_Detect.php';
		$this->detect= new Mobile_Detect();
		
		$this->set_bodyclass();
		$this->check_device_type();	
		$this->check_system();			
	}

	public function db_connect() {		
			$DB_SERVER = "localhost"; 
			$DB_USER = "postnlkaart"; 
			$DB_PWD = "Xie7naeni2ee";
			$DB_NAME = "postnlkaart"; 
			$DB_ERROR= "Fout in de database connectie";		
			$DB=mysql_connect($DB_SERVER, $DB_USER, $DB_PWD);
			mysql_select_db($DB_NAME, $DB) or die($DB_ERROR);		
	} 
	
	public function check_device_type(){
		if($this->detect->isTablet()):
			$this->device_type='tablet';		
		elseif($this->detect->isMobile()):
			$this->device_type='phone';		
		else:
			$this->device_type='desktop';
		endif;
	}
	
	public function set_bodyclass(){		 
		$agent= strtolower($_SERVER['HTTP_USER_AGENT']);
		
		$array=array('ipad', 'iphone', 'android', 'mobile');
		$this->bodyclass='desktop';
		foreach($array as $value):
			if (strstr($agent, $value)==true):	
				$this->bodyclass='mobile';	
			endif;
		endforeach;		
		if (strpos($agent,'fbmd/iphone') !== false) {
			$this->fb_iphone= true;
		} 
	}
			
	public function db_prep($var){
		return mysql_real_escape_string($var);	
	}		
	
	public function set_stat($type, $target){	
		$query="SELECT value FROM ".$this->db_measure_table." WHERE device='".$this->device_type."' AND type='".$type."' AND target='".$target."'";
		$result=mysql_query($query);
		$count=mysql_num_rows($result);
		$number=mysql_result($result,0);
		$value=$number++;				
		if($count==0):
			$query="INSERT INTO ".$this->db_measure_table." (device,type,target,value)  
			VALUES (		
			'".$this->db_prep($this->device_type)."',
			'".$this->db_prep($type)."', 
			'".$this->db_prep($target)."',	
			1						
			)";		
		else:		
			$query="UPDATE ".$this->db_measure_table." SET value=".$number." WHERE device='".$this->device_type."' AND type='".$this->db_prep($type)."' AND target='".$this->db_prep($target)."'";	
		endif;		
		$result=mysql_query($query);		
		//die();
	}
	
	public function debug(){
		if($this->debug==true):
			ini_set('display_errors',1);
			ini_set('display_startup_errors',1);
			error_reporting(1);		
		endif;		
	}
	
	public function check_system(){		
		$this->client_outdated=false;
		if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 9')):
			$this->client_outdated=false;	
			$this->client_error='ie';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 8')):
			$this->client_outdated=true;	
			$this->client_error='ie';		
		elseif(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 7')):
			$this->client_outdated=true;	
			$this->client_error='ie';
		endif;			
		if ($this->detect->isiOS()):			
			$version = $this->detect->version('iOS'); 
			if($version[0]<6):
				$this->client_outdated=true;	
				$this->client_error='mobile';
			endif;	
		elseif ($this->detect->isAndroidOS()):				
			$version = $this->detect->version('Android'); 							
			if(strpos($_SERVER['HTTP_USER_AGENT'],'Firefox')):			
			
			else:
				if($version[0]<4):
					$this->client_outdated=true;	
					$this->client_error='mobile';
				endif;	
			endif;	
		endif;
	}
	
	public function fbuid_check($id){
		$booUser = false;
		$fbData = file_get_contents('https://graph.facebook.com/'.$id);
		$jsonData = json_decode($fbData);		
		if($jsonData->id) $booUser = true;
	 	return $booUser;	
	}	
	
	public function set_viewport($device){		
		if($device=='tablet'){
			$viewport='768px';
			$initscale='initial-scale=1';
			$maxscale='maximum-scale=1';
			$scalable=0; 
			$input='width=768,user-scalable=0';		
		}else{
			$viewport='512px';		
			$input='width=512,user-scalable=no';		
		}	
		
		$agent=strtolower($_SERVER['HTTP_USER_AGENT']);
		if((strpos($agent,'mobile') && strpos($agent,'chrome')==false &&  strpos($agent,'iphone')==false) && strpos($agent,'ipad')==false):
			$scalable='';	
		else:	
			$scalable=',user-scalable=0';
		endif;
			return '<meta name="apple-mobile-web-app-capable" content="yes" />
			<meta name="viewport" id="viewport" content="'.$input.'"/>';
	}
}
?>