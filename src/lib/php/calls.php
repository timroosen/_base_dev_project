 <?php

$calls=new Calls(); 

class Calls {
	
	//CLASSES		
	private $base;
	private $content;
	
	//db tables
	private $db_entries;
	private $db_stats;
	private $db_options;
	private $db_entry_options;
	
	//vars
	private $db_id;
	private $img_nr;
	
	public $website_active;
	private $optionid;
	public $device_type;
	
	public function __construct(){			
		if((!defined('checkup') && $_SERVER['HTTP_X_REQUESTED_WITH']!='XMLHttpRequest') ):		
			//die('Direct access not permitted');		
		endif;	
					
		$this->db_entries= 'ng_entries';		
		$this->db_stats='ng_stats';  
		$this->db_options='ng_options'; 
		$this->db_entry_options='ng_entry_options';		
		
		$this->img_nr=1;	
		
		require_once 'base.php';
		$this->base= new Base();				
			
		$this->base->db_connect();
		$this->base->check_system();
		$this->base->check_device_type();
		
		$this->device_type=$this->base->device_type;
		
		$this->website_active=$this->get_backend_option('website_active');
		
		if (isset($_POST['action'])):					
			$this->action=$_POST['action'];					
			$this->ajax_calls();					
		endif;				
	}

	private function ajax_calls(){			
		switch($this->action):
			case '':

			break;
			case 'set_stat':
				$this->base->set_stat($_POST['type'],$_POST['target']);				
			break;	
			case 'set_share':
				$this->set_share();			
			break;	
			case 'get_overlay':
				echo $this->get_overlay_content($_POST['type']);			
			break;	
			case 'submit_form':
				echo $this->submit_form();			
			break;		
		endswitch;			
	}
	
	
	public function init(){	
		if($this->base->client_outdated==true):
			$content=$this->create_fallback();			
		else:
			$content=$this->page_header().$this->create_carrousel();
		endif;			
		return $this->site_header().$this->wrap_content($content).$this->site_footer();		
	}
	public function set_landing_stat($ref='direct'){		
		$this->base->set_stat('landing', $ref);		
	}
	
	public function get_meta_data($id=false){
		$meta= array();
		if($id==false):		
			$meta['title']='Wie verras jij deze kerst met een kaartje?';
			$meta['description']='Laat het ons weten en zowel jij als de ontvanger maken kans op een heerlijk weekend voor 2 personen in Maastricht.';
			$meta['url']='http://www.postnlkaart.nl/?ref=share';		
		else:
			$sql="SELECT * FROM $this->db_entries WHERE id=".$id." AND status=1";
			$result=mysql_query($sql);
			while($item=mysql_fetch_array($result)):
				$meta['title']=$item['name'].' verrast deze kerst een speciaal iemand met een kaartje.';
				$meta['description']='En zowel '.$item['name'].' als de ontvanger maken zo ook nog eens kans op een heerlijk weekend voor 2 personen in Maastricht). Wie verras jij?';	
				$meta['url']='http://www.postnlkaart.nl/?ref=share_entry&id='.$item['id'];	
			endwhile;
			
		endif;	
		
		return $meta;
	}
	
	private function site_header(){
		return '<section id="menu-mobile">
                    <div id="menu-top">
                        <div class="logo"></div>
                        <div id="menu-icon"></div>
                        <div class="menu-gradient-bar">
                            <div class="menu-gradient-bar-start"></div>
                            <div class="menu-gradient-bar-end"></div>
                            <div class="menu-gradient-bar-middel"></div>                            
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div id="menu-bottom">
                        <div id="menu-bottom-container">
                            <nav>
                                <a href="http://www.postkantoor.nl/kerst?trc=dp-KNJ14-pkt-inspiratiezegel" target="_blank" onclick="setstatextra('."'decemberzegels-menu'".');"><div class="menu-item first" data-num="0">Naar  Decemberzegels<img class="menu-icon-image stamps" src="media/base/menu_icon_stamp.png"></div></a>
                                <a href="http://www.postnl.nl/locatiewijzer?trc=dp-KNJ14-pnl-inspiratielocatie" target="_blank" onclick="setstatextra('."'zoek-verkooppunt-menu'".');"><div class="menu-item" data-num="1">Naar verkooppunt<img class="menu-icon-image location" src="media/base/menu_icon_location.png"></div></a>
                                <a href="http://www.postnl.nl/postcode-zoeken?trc=dp-KNJ14-pnl-inspiratiepostcode" target="_blank" onclick="setstatextra('."'zoek-postcode-menu'".');"><div class="menu-item" data-num="2">Zoek postcode<img class="menu-icon-image search" src="media/base/menu_icon_search.png"></div></a>
                                <a href="#" class="how-to-link-mobile" target="_blank"><div class="menu-item" data-num="3">Hoe werkt het?</div></a>
                              	<a href="actievoorwaarden.pdf" target="_blank"><div class="menu-item last" data-num="4">Actievoorwaarden</div></a>
								<div class="menu-item social-menu-item"><div class="social-btn" id="facebook-btn"></div></div>								
								&nbsp<div class="menu-item social-menu-item"><div class="social-btn" id="twitter-btn"></div></div>
								
                            </nav>
                        </div>
                        <div class="menu-pattern">    
                        </div>
                    </div>
					<div id="menu-pattern-desktop"></div>
					
                </section>
				<div id="overlay-menu" class="overlay-background"></div>
				';
		
	}
	
	private function site_footer(){
		return'<section id="footer">
				<div class="footer-content-wrapper">
                    <div class="footer-content-container">
					 <a href="http://www.postkantoor.nl/kerst?trc=dp-KNJ14-pkt-inspiratiezegel" target="_blank" onclick="setstatextra('."'decemberzegels-footer'".');">
						 <div class="footer-section stamps">
                            <div class="footer-section-title">Bestel de voordelige Decemberzegels</div>
                            Nu bij 3 velletjes<br>een gratis kookboek.
                        <div class="footer-section-btn stamps orange">Naar Decemberzegels<img class="footer-icon-image" src="media/base/footer_btn_icon.png"></div>
                        </div>
						</a>
                    </div>
                    <div class="footer-content-container mobile-divider">
                    <div id="borders"></div>
					 <a href=" http://www.postnl.nl/locatiewijzer?trc=dp-KNJ14-pnl-inspiratielocatie" target="_blank" onclick="setstatextra('."'zoek-verkooppunt-footer'".');">
                        <div class="footer-section location">
                            <div class="footer-section-title">Zoek een verkooppunt</div>
                            Zoek een verkooppunt<br>met Decemberzegels bij<br>jou in de buurt.<br>
                          <div class="footer-section-btn location orange">Naar verkooppunt<img class="footer-icon-image" src="media/base/footer_btn_icon.png"></div>
                        </div>
					</a>
						
                    </div>
                    <div class="footer-content-container">
						 <a href="http://www.postnl.nl/postcode-zoeken?trc=dp-KNJ14-pnl-inspiratiepostcode" target="_blank" onclick="setstatextra('."'zoek-postcode-footer'".');">
                      		 <div class="footer-section search">	
                            <div class="footer-section-title">Postcode zoeken</div>
                            Heb je wel het adres maar geen<br>postcode? Gebruik onze<br>Postcodezoeker.<br>
                            <div class="footer-section-btn search orange">Zoek postcode<img class="footer-icon-image" src="media/base/footer_btn_icon.png"></div>
                        </div>
						</a>
                    </div>
					<div class="clear"></div>
					</div>
                </section>
				<section id="footer-bar">
                    <div id="footer-bar-items">
                        <div class="footer-bar-item"><a href="#" class="how-to-link" target="_blank">Hoe werkt het?</a></div>
                        <div class="footer-bar-item middle"><a href="actievoorwaarden.pdf" target="_blank">Actievoorwaarden</a></div>
                        <div class="footer-bar-item"><a href="http://www.postnl.nl/privacy-verklaring?trc=dp-KNJ14-pnl-inspiratieprivacy" target="_blank">Privacy policy</a></div>
                    </div>
                </section>';
		
	}
	
	private function create_fallback(){
		
		return '<div id="fallback_content">
			<div class="header-title">Wie verras jij deze<br>&nbsp;&nbsp;&nbsp;kerst met een kaartje?</div>
			<div id="fallback_content_text">
			Helaas is je browser niet geschikt<br>
			Download Google Chrome hier<br>
			of probeer het op een andere computer
				<a href="https://www.google.nl/intl/nl/chrome/browser/" target="_blank"><div id="fallback_btn"></div></a>
			
			</div></div>';		

		$this->base->set_stat('view','fallback');	
		
	}
	
	private function page_header(){
		$btn='';
		if($this->website_active==1)$btn='<div class="btn header-mobile compete-link" id="btn_header_cta">Wie ga jij verrassen?</div>';
		return'<section id="header">
					<canvas id="let-it-snow"></canvas>
					<div id="header-wrapper">
					<div class="header-title">Wie verras jij deze<br>&nbsp;&nbsp;&nbsp;kerst met een kaartje?</div>
					<div class="header-image"></div>
					<div class="header-copy">Misschien wel die lieve schooljuf van je zoon of dochter. Je oppas die je altijd kunt bellen. Of die handige klusvriend waar je altijd op kunt bouwen. Kerst is het ideale moment om zo iemand te verrassen. Juist de mensen die het niet verwachten zullen dit extra waarderen.<p>Heb jij nu zo’n speciaal iemand in gedachten? Vertel het ons en inspireer ook anderen om iemand het mooiste cadeautje met kerst te sturen. Dan maak niet alleen jij kans op een heerlijk weekend voor 2 personen in Maastricht, maar degene die je gaat verrassen ook!</p> Een kaartje. <span class="orange">Het mooiste cadeautje met kerst</span>
				'.$btn.'
			</div>
			</div>
		</section>';
		
		
	}
	private function wrap_content($content){
		return'<div id="page_container">
			<section id="overlay-page" class="overlay-background">
				<div id="contestant-overlays">
					<div class="btn-overlay-close"></div>
					<div id="contestant-overlays-content"></div>
				</div>
			</section>
			'.$content.'</div>';		
	}
	
	
	//entries
	
	private function create_carrousel(){	
	if($this->website_active==1)$btn='<div class="btn entries-mobile compete-link" id="btn_entries_cta">Wie ga jij verrassen?</div>';	
		return '
			<section id="entries">
			<div id="entries-wrapper">
				<div class="entry-nav left"></div>
				<div class="entry-nav right"></div>
				<div id="entries-container">
					<div id="entries-holder">                    
						'.$this->get_carroussel_items().'
					</div>
				</div>
			</div>
			'.$btn.'
			</section>';		
	}
	
	private function get_carroussel_items(){		
			//get all active and not empty enrty optionss						
			$output='';
			$i=1;	
			$sql="SELECT * FROM ".$this->db_entry_options." WHERE status=1";			
			$result=mysql_query($sql);			
			while($item=mysql_fetch_array($result)):				
				if($this->get_carrousel_item_count($item['id'])!=0):				
					if($this->get_backend_option('third_item_bogus')==1 && $i==3)$output.=$this->get_bogus_item();					
					$output.=$this->get_single_carroussel_item($item);
					$i++;
				endif;
			endwhile;			
			return $output;	
	}
	
	private function get_carrousel_item_count($id){		
		$sql="SELECT * FROM $this->db_entries WHERE input_option=$id AND status=1";	
		$result=mysql_query($sql);
		return mysql_num_rows($result);			
	}
	private function get_single_carroussel_item($item){		
		if($item['id']>7) $img='stock_'.$this->get_stock_image().'.jpg';
		else $img=$item['id'].'.jpg';
		$name=explode(' ', $item['name'], 2);
		
		$output='<div class="entry" id="'.$item['id'].'">
					<div class="entry-title orange"><span class="font-regular">'.$name[0].'</span> '.$name[1].'</div>
					<div class="entry-image"><img src="media/gallery/'.$img.'"></div>
					<div class="items-wrapper">
						<div class="items-holder">
							<div class="items">
								'.$this->get_all_entries($item['id']).'						
							</div>
						</div>
					</div>
					<div class="items-nav">
						<div class="item-nav down"></div>
						<div class="item-nav up"></div>
					</div>
				</div>';
				
		return $output;		
	}
	
	private function get_all_entries($id){	
			$output='';								
			$sql="SELECT * FROM $this->db_entries WHERE status=1 AND input_option='".$id."'";
			$result=mysql_query($sql);
			$i=0;
			while($entry=mysql_fetch_array($result)):
				$output.=$this->get_entry($entry, $i);
				$i++;
			endwhile;			
			return $output;				
	}
	private function get_entry($item, $i){	
		$class='';
		if($i==0)$class='active';	
		return '<div class="item-copy '.$class.'" id="copy-'.$item['id'].'">
					<span class="item-copy-name">'.$item['name'].' verrast '.$item['input_name'].'</span>
					“'.$item['input_value'].' ” 
				</div>';
				
				//htmlspecialchars();
		
	}
	
	private function get_single_entry($friend=false){
		$sql="SELECT * FROM $this->db_entries WHERE id=".$_POST['id'];
		$result=mysql_query($sql);
		while($item=mysql_fetch_array($result)):
		
		if($friend==false)$name='Je';else $name =$item['name'];
		if($friend==false)$names='jij';else $names =$item['name'];
			$content=' 				
			<div class="contestant-form-title">
				'.$name.' gaat '.$item['input_name'].' verrassen met <span class="font-bold"> een kerstkaartje.</span>
			</div>
			
			<div class="contestant-form-header"><img src="http://www.postnlkaart.nl/media/base/stamps_large.gif">Bestel direct onze voordelige Decemberzegels, want dat geeft jouw kerstkaart dat échte kerstgevoel. Als je ze online op postkantoor.nl bestelt, dan bezorgen we ze gratis bij je thuis.</div>
			<div class="contestant-form-copy">
				“'.$item['input_value'].'“ <br><br>Met deze inzending maken zowel '.$names.'  als '.$item['input_name'].' allebei kans op een heerlijk weekend voor 2 personen in Maastricht
			</div>			';	
			if($friend==true){$content.='<div id="singel-entry-shares"></div>';
				if($this->website_active==1){
					$content.='<div class="btn-send compete-link" id="btn-surprise">Verras ook iemand</div>';
				}		
			}
			else $content.='<div id="singel-entry-shares">
				<div id="btn-fb-share" class="btn-share">Share</div>
				<div id="btn-tw-share" class="btn-share">Share</div>
			</div>
			<a href="http://www.postkantoor.nl/kerst?trc=dp-KNJ14-pkt-inspiratiezegel" target="_blank"><div class="btn-send" id="btn-buy-stamps">Koop nu Decemberzegels</div></a>';
				
		endwhile;
		$this->set_view($item['id']);	
		return $content;	
	}
	//form
	
	private function get_dropdown_options(){
			
		$query="SELECT * FROM $this->db_entry_options WHERE status=1";		
		$result=mysql_query($query);
		$options='';
		while($option=mysql_fetch_array($result)):
				$options.='<li class="dropdown-option" data-val="'.$option['id'].'">'.$option['name'].'</li>';
		endwhile;	
		if($this->get_backend_option('allow_other_in_options')==1) $options.='<li class="dropdown-option" data-val="different">Anders, namelijk...</li>';
		return $options;
	
		
		
	}
	
	private function get_form(){		
		
		$options=$this->get_dropdown_options();
		return' <div id="contestant-form" class="form-holder">
					<div class="form-wrapper">
						<div class="snowflake"></div>
						<div class="header-title form">Wie verras jij deze<br/>&nbsp&nbsp&nbspkerst met een kaartje?</div>
						<form method="post" id="form-form">
							<label class="form-label">Hoe heet hij of zij? (Voornaam)</label>
							<input id="input-name" type="text" class="form-element form-gradient" name="input_name" maxlength="30">

							<label class="form-label">Wie is hij of zij?</label>
							<div id="custom-dropdown" class="form-element">Maak een keuze</div>
							<div id="custom-dropdown-overlay">
								<ul id="custom-dropdown-box">
									'.$options.'
								</ul>
							</div>
							<label class="form-label custom-input">Hij of zij is…</label>
							<input id="input-option" type="text" class="form-element form-gradient custom-input" name="input_option" placeholder="bijv. De liefste thuishulp" maxlength="20">

							<label class="form-label">Waarom is hij of zij zo bijzonder?</label>
							<textarea id="input-message" rows="5" class="form-element-textarea form-gradient" cols="25" name="input_message" maxlength="140"></textarea>

							<label class="form-label">Wat is je voornaam?</label>
							<input id="input-first-name" type="text" class="form-element form-gradient" name="first_name" maxlength="30">

							<label class="form-label">Wat is je e-mailadres?</label>
							<input id="input-email" type="text" class="form-element form-gradient" name="email" maxlength="40">

							<label class="form-label">Herhaal je e-mailadres</label>
							<input id="input-validate" type="text" class="form-element form-gradient" name="email_validate" maxlength="40">

							<div id="check-sweepstake">
								<div id="check-sweepstake-radio" class="custom-radio"></div>
								<div id="check-sweepstake-label" class="form-label radio">Ja, ik ga akkoord met de <a href="actievoorwaarden.pdf" target="_blank">actievoorwaarden</a></div>
							</div>
							<br/><div id="newsletter">
								<div id="check-sweepstake-newsletter" class="custom-radio"></div>
								<div class="form-label radio">Ja, houd mij op de hoogte van andere <br> PostNL acties en nieuws!</div>
							</div>
							<div class="clear"></div>
							<div id="form-error-copy">Je hebt niet alle velden (correct) ingevuld</div>
							<div class="btn-send" id="btn-form-send">Verstuur</div>
						</form>
					</div>
				</div>';
		
		
	}
	
	private function submit_form(){			
		if(is_int($this->save_form_data())):
			$type='thanks';
		else:
			$type='form_error';
		endif;
		return $this->get_overlay_content($type);	
		
	}
	
	private function add_entry_option(){
		$sql="INSERT INTO $this->db_entry_options (name, status) VALUES ('".$this->base->db_prep($_POST['different'])."',0)";
		$result=mysql_query($sql);
		return mysql_insert_id();		
	}
	
	private function save_form_data(){
		
		$optionid=$_POST['input_option'];
		if($optionid=='different')$optionid=$this->add_entry_option();	
		$this->optionid=$optionid;									
		$query="INSERT INTO ".$this->db_entries." (name, email, input_name,input_option,input_value,ipaddress,timestamp,device,optin, referrer)  
		VALUES (		
		'".$this->base->db_prep(htmlentities($_POST['name']))."',	
		'".$this->base->db_prep(htmlentities($_POST['email']))."',
		'".$this->base->db_prep(htmlentities($_POST['input_name']))."',
		'".$this->base->db_prep($optionid)."',
		'".$this->base->db_prep(htmlentities($_POST['input_value']))."',		
		'".$_SERVER['REMOTE_ADDR']."',
		'".time()."',
		'".$this->base->device_type."',
		'".$this->base->db_prep($_POST['optin'])."',
		'".$this->base->db_prep($_POST['ref'])."'
		)";							
		$result=mysql_query($query) or die (mysql_error());
		return mysql_insert_id();						
	}	
	private function  strposa($haystack, $needle, $offset=0) {
		if(!is_array($needle)) $needle = array($needle);
		foreach($needle as $query) {
			if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
		}
		return false;
	}
	
	//overlay	
	private function get_overlay_content($type){		
		switch($type):
			case 'thanks':
				$wrapid='contestant-form-ty';
				$optionvalue=$this->get_input_option($this->optionid);
				$option=explode(' ', $optionvalue, 2);
				if (in_array($option[0],array('de', 'De', 'het', 'Het', 'een','Een'))) {
					$option_output=$option[1];
				}
				else{
					$option_output=$optionvalue;
				}				
				
				//$option=str_replace('een ','', str_replace('Een ','', str_replace('het ','', str_replace('Het ','', str_replace('de ','', str_replace('De ','', $this->get_input_option($this->optionid)))))));
				$content='	<div class="contestant-form-title">
									Wat leuk dat je <span class="font-bold">jouw '.strtolower($option_output).'</span> wilt verrassen met een kerstkaartje!
								</div>
								<div class="contestant-form-copy">
								Zodra je inzending online staat, laten we het je meteen weten. 
Bestel ook direct onze voordelige Decemberzegels, want dat geeft elke kerstkaart dat échte kerstgevoel. Als je ze online op <a href="http://www.postkantoor.nl?trc=dp-KNJ14-pnl-inspiratiepostkantoor">postkantoor.nl</a>  bestelt, dan bezorgen we ze gratis  bij je thuis. 
								</div>
								 <div id="contestant-form-ty-footer">
								 	<a href=" http://www.postkantoor.nl/kerst?trc=dp-KNJ14-pkt-inspiratiezegel" target="_blank"><div id="ty_image"></div></a>
									<span class="blue font-bold">Een kaartje.</span><br/><span class="orange">Het mooiste cadeautje met kerst</span>									
								 </div>

								 <a href="http://www.postkantoor.nl/kerst?trc=dp-KNJ14-pkt-inspiratiezegel" target="_blank" onclick="setstatextra('."'decemberzegels-bedankt-pagina'".');"><div class="btn-send" id="btn-buy-stamps">Koop nu Decemberzegels</div></a>
								 <div class="hide">!-- Conversion Pixel - Post NL Corporate Kerst 2014 Conversie Deelname - DO NOT MODIFY -->
<img src="https://secure.adnxs.com/px?id=423776&t=2" width="1" height="1" />
<!-- End of Conversion Pixel -->
<img border="0" src="https://r.turn.com/r/beacon?b2=TTELSGVfV6pSMgPCFRl91u_GZhTusuCBnZKPDqO_6XF8L7k_PHCROrKXOuKQ2UmlXqA5NlUpkvM6WE9AreZDqA&cid="> 
<div id="m3_tracker_4" style="position: absolute; left: 0px; top: 0px; visibility: hidden;"><img src="http://adserver.postnl.nl/ti.php?trackerid=4&amp;cb='.rand().'" width="0" height="0" alt="" /></div>
</div>
							';
							$this->base->set_stat('overlay','thanks');
			
			break;			
			case 'how-to-link':
				$wrapid='contestant-faq';
				$content=' <div class="contestant-form-title">
								<span class="font-bold">Hoe</span> werkt het?
							</div>
							<div class="contestant-form-copy extra-padding">
								Selecteer eerst wie je wilt verrassen. Is het de handige klusvriend? De onmisbare oppas? Of wil je zelf een nieuwe categorie toevoegen? Als jouw inzending is goedgekeurd, dan krijg je van ons een berichtje en plaatsen we jouw inzending op de site.<p>Alle inzendingen die positief geformuleerd zijn en bij de actie passen zullen worden goedgekeurd. Vanaf dan maak niet alleen jij kans op een heerlijk weekend voor 2 personen in Maastricht, maar degene die je gaat verrassen ook!</p> 
								<p>Op 29 december maken we de winnaars bekend. Hou dus je mail goed in de gaten. Voor alle overige vragen over deze campagne en de actievoorwaarden klik <a href="actievoorwaarden.pdf" target="_blank">hier</a>.<p>Veel succes!</p> 
							</div>                                
							<div class="btn-send" id="btn-faq-cta">Wie ga jij verrassen?</div>';
							$this->base->set_stat('overlay','how-to');
			
			break;
			case 'form_error':
				$wrapid='contestant-form-error';
				$content='Helaas is er iets misgegaan met je inzending 
Probeer het even opnieuw, want het zou zonde zijn als je niet kans zou maken op een heerlijk weekend in Maastricht. Veel succes!';
				$this->base->set_stat('overlay','formerror');
			
			break;
			case 'end':
				$wrapid='contestant-end';
			
				$content='<div class="contestant-form-title">                                        
						<span class="font-bold">Helaas</span> is de actie afgelopen
					</div>
					<div class="contestant-form-copy">
						We hopen dat je een fijne kerst hebt (gehad). Onze kerstactie is afgelopen. Je kunt nog wel alle inzendingen bekijken en je laten inspireren om ook iets vaker iemand te verrassen met een kaartje. Wij wensen  je een fantastisch 2015!
					</div>                                
					<a href="http://www.postkantoor.nl/kerst?trc=dp-KNJ14-pkt-inspiratiezegel" target="_blank"><div class="footer-section-btn stamps orange end">Naar Decemberzegels<img class="footer-icon-image" src="media/base/footer_btn_icon.png"/></div></a>
					<div class="btn-send" id="btn-faq-cta">Bekijk de inzendingen</div>';
					
						$this->base->set_stat('overlay','endpopup');
			
			break;	
			case 'item-copy':
				$wrapid='contestant-single-entry';			
				$content=$this->get_single_entry(true);		
				$this->base->set_stat('overlay','single-entry');		
			break;	
			case 'item-copy-friend':
				$wrapid='contestant-single-entry-friend';			
				$content=$this->get_single_entry();	
				$this->base->set_stat('overlay','single-entry-friend');			
			break;				
			case 'compete-link':
				$wrapid='contestant-form';			
				$content=$this->get_form();	
				$this->base->set_stat('overlay','compete');			
			break;	
			
			
		endswitch;	
		
		return  '<div id="'.$wrapid.'" class="form-holder">
                    <div class="form-wrapper">
					 '.$content.'
					</div>
                 </div>';	
	}
	
	
	
	//stats		
	private function set_share(){
		$query="UPDATE ".$this->db_entries." SET shares = shares + 1 WHERE id='".$this->base->db_prep($_POST['id'])."'";			
		$result=mysql_query($query);		
		die();			
	}	
	private function set_view($id=false){		
		if($id==false) $id=$this->base->db_prep($_POST['id']);
		$query="UPDATE ".$this->db_entries." SET views = views + 1 WHERE id='".$id."'";			
		$result=mysql_query($query);	
		if($id==false) die();	
	}	
	
	//images	
	private function get_stock_image(){
		if($this->img_nr==8) $this->img_nr=1;
		else $this->img_nr= $this->img_nr+1;		
		return $this->img_nr;	
	}
	
	//backend options
	
	private function get_backend_option($option){
		$sql="SELECT value FROM $this->db_options WHERE `option`='".$option."'";	
		$result=mysql_query($sql);
		$value = mysql_fetch_object($result);
		return $value->value;	
	}
	
	private function get_input_option($option){
		$sql="SELECT name FROM $this->db_entry_options WHERE `id`=".$option."";	
		$result=mysql_query($sql);
		$value = mysql_fetch_object($result);
		return $value->name;	
	}
	
	private function get_bogus_item(){		
		return '<div class="entry bogus compete-link">
					<div class="entry-title orange"><span class="font-regular">Wie</span> verras jij?</div>
					<div class="entry-image"><img src="media/gallery/bogus.jpg"></div>
					<div class="items-wrapper">
						<div class="items-holder">
						<div class="items">
							Iedereen vindt het leuk om een kerstkaartje te krijgen. Niet alleen de onmisbare oppas, lieve schooljuf of de andere voorbeelden die je hier vindt.<br><br>
							Voel je vrij om zelf te kiezen wie je gaat verrassen met een kerstkaartje.											
						</div>
					</div>	
					</div>				
				</div>';	
	}
}
?>