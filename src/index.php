<?php 	
    define('checkup' ,'postnl');
	include 'inc/php/calls.php';
	$calls= new Calls();
	$calls->set_landing_stat($_GET['ref']);
	$meta = $calls->get_meta_data($_GET['id']);
?><!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge;chrome=1" />
   <!--[if lte IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    <meta property="description" content="<?php echo $meta['description'];?>" />
    <title>PostNL | Wie verras jij deze kerst met een kaartje?</title>
    <meta property="og:locale" content="nl_NL"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="<?php echo $meta['url'];?>"/>
    <meta property="og:title" content="<?php echo $meta['title'];?>"/>
    <meta property="og:description" content="<?php echo $meta['description'];?>"/>
    <meta property="og:image" content="http://www.postnlkaart.nl/fb_share.jpg" />
    <meta name="viewport" content="width=device-width, user-scalable=no"/>
    
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
	<link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="canonical" href="" />
    <link href="reset-min.css" rel="stylesheet" type="text/css" />
    <link href="style.css" rel="stylesheet" type="text/css" />
    <!--[if lte IE 8]><link href="ie8.css" rel="stylesheet" type="text/css" /><![endif]-->
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/modernizr/2.7.1/modernizr.min.js"></script>    
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/gsap/1.11.4/plugins/ScrollToPlugin.min.js"></script>
    <script type="text/javascript" src="inc/js/toolbox/whichbrowser.js"></script>
    <script type="text/javascript" src="inc/js/toolbox/validate.js"></script>
    <script type="text/javascript" src="inc/js/toolbox/stats.js"></script>
    <script type="text/javascript" src="inc/js/ajaxHandler.js"></script>
    <script type="text/javascript" src="inc/js/snowClass.js"></script>
    <script type="text/javascript" src="inc/js/mouseHandler.js"></script>
    <script type="text/javascript" src="inc/js/main.js"></script> 
    <script type="text/javascript" src="inc/js/toolbox/smoothscroll.js"></script>
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-23456008-17', 'auto');
      ga('send', 'pageview');
    
    </script>
    <script>
		var website_active = <?php echo $calls->website_active?>;
	</script>
</head>
<body  class="<?php echo $calls->device_type?>">
<div id="fb-root"></div>

<script>
window.fbAsyncInit = function(){
    FB.init({
        appId: '685342094898347', status: true, cookie: true, xfbml: true }); 
    };
    (function(d, debug){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if   (d.getElementById(id)) {return;}js = d.createElement('script'); js.id = id; js.async = true;js.src = "//connect.facebook.net/en_US/all" + (debug ? "/debug" : "") + ".js";ref.parentNode.insertBefore(js, ref);}(document, /*debug*/ false));
</script>   
    <div id="container">
    	<?php echo $calls->init();?>
    </div>
    <div class="pixel">
        <!-- Segment Pixel - Post NL Corperate Kerst 2014  RET pixel  - DO NOT MODIFY -->
            <img src="https://secure.adnxs.com/seg?add=2208839&t=2" width="1" height="1" />
        <!-- End of Segment Pixel -->
    </div>

<?php if($_GET['cookies']=='on'){?>

	<style>
    div#WGaclsmkap{z-index: 99999999;height: 75px;line-height: 75px;top: 0px;background-color: #ffae00;border-top: 0px solid #000;opacity:0.9; filter:alpha(opacity=90);font-size: 14px;color: #00007f;font-weight: bold;font-family:Arial,Helvetica;position: fixed; width: 100%; text-align: center; display: table-cell; vertical-align: top;}
    div#WGaclsmkap a:visited,div#WGaclsmkap a:active,div#WGaclsmkap a:link{text-decoration:underline; font-size: 14px; color: #00007f; font-weight: bold; font-family:Arial,Helvetica,FreeSans,"Liberation Sans","Nimbus Sans L",sans-serif; vertical-align: top;}
    div#WGaclsmkap a#WGaclsmkapbutton:visited,div#WGaclsmkap a#WGaclsmkapbutton:active,div#WGaclsmkap a#WGaclsmkapbutton:link{text-decoration:none; font-size: 14px; color: #FFFFFF; font-weight: bold; font-family:Arial,Helvetica,FreeSans,"Liberation Sans","Nimbus Sans L",sans-serif; vertical-align: top; margin: 0px 0px 0px 10px;}
    </style>
    <script src="inc/js/cookies.js"></script>
    <script type="text/javascript">
    //<![CDATA[
    var barid = 'WGaclsmkap'; var barcookieexpiredays = 365; var buttonclosetext = 'Verberg deze melding'; var msg = 'De websites van PostNL maken gebruik van cookies. De cookies die PostNL gebruikt, laten onze websites beter aansluiten op uw wensen. Ze maken de websites persoonlijker, gebruiksvriendelijker en hiermee kunnen we advertenties beter aanpassen aan uw voorkeuren. U geeft, door op akkoord te drukken, toestemming voor cookies op de websites van PostNL.<a href="http://www.postnl.nl/cookie-verklaring/">Klik hier</a> voor meer informatie.';
    Cookies.defaults = { path: '/', expires: (barcookieexpiredays*24*60*60)};
    window.onload = function() {
    if (Cookies('showbar') != 'false'){
    var closeButton = document.createElement('a'); closeButton.setAttribute('href', 'javascript:void(0);'); closeButton.id = barid+'button'; closeButton.name = buttonclosetext; closeButton.innerHTML = 'Sluiten'; closeButton.onclick = function() { removeElement(document.getElementById(barid)); Cookies.set('showbar', 'false'); };
    var cookieMsgContainer = document.createElement('div'); cookieMsgContainer.innerHTML = msg; cookieMsgContainer.id = barid; cookieMsgContainer.appendChild(closeButton); document.body.appendChild(cookieMsgContainer);
    }};
    function removeElement(element) { element && element.parentNode && element.parentNode.removeChild(element);}
    //]]>
    </script>


<?php }?>


        
</body>
</html>