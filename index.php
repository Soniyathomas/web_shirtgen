<?php 
session_start();
require_once("connect.php"); 
require_once 'fbphp5/src/Facebook/autoload.php';

$siteUrl_2='https://wpmonk.herokuapp.com';
//facebook_campaign start
$fc_params['id'] = $_REQUEST["CId"];
$fc_params['meta_key'] = 'facebook_campaign';
$fc_appMeta = campaign::getCampaignMetaValueByCampaignId($fc_params);
$fcId = $fc_appMeta['meta_value'];
//facebook_campaign end
$t_params['id'] = $fcId;
$t_params['meta_key'] = 'app_token';
$t_appMeta = campaign::getCampaignMetaValueByCampaignId($t_params);
$token = $t_appMeta['meta_value'];
$_SESSION['al_token'] = $token;
//token 
//token 
$appid_params['id'] = $fcId;
$appid_params['meta_key'] = 'app_id';
$appid_appMeta = campaign::getCampaignMetaValueByCampaignId($appid_params);
$appid = $appid_appMeta['meta_value'];
$_SESSION['al_appid'] = $appid;
//token 
//app_secret_id
$app_secret_id_params['id'] = $fcId;
$app_secret_id_params['meta_key'] = 'app_secret_id';
$app_secret_id_appMeta = campaign::getCampaignMetaValueByCampaignId($app_secret_id_params);
$app_secret_id = $app_secret_id_appMeta['meta_value'];
$_SESSION['al_app_secret_id'] = $app_secret_id;
//app_secret_id 	


$recid = $_REQUEST["CId"];
//$siteUrl_2 = siteurl_2;	
$fb = new Facebook\Facebook([
	  'app_id' => $appid,
	  'app_secret' => $app_secret_id,
	  'default_graph_version' => 'v2.2',
	  ]);
$helper = $fb->getRedirectLoginHelper();
$accessToken = $helper->getAccessToken();
$permissions = ['email']; // Optional permissions

$_SESSION['Cid'] = $_REQUEST['CId'];
$_SESSION['tId'] = $_REQUEST['tId'];
$_SESSION['mId'] = $_REQUEST['mId'];

$Cid = $_REQUEST['CId'];
$tId = $_REQUEST['tId'];
$mId = $_REQUEST['mId'];

//
$redirection = $helper->getLoginUrl("$siteUrl_2/fb-callback.php?CId=$Cid&tId=$tId&mId=$mId", $permissions);
foreach ($_SESSION as $k=>$v) {                    
    if(strpos($k, "FBRLH_")!==FALSE) {
        if(!setcookie($k, $v)) {
            //what??
        } else {
            $_COOKIE[$k]=$v;
        }
    }
}
$redition_sleep = 50;
//header("location:$loginUrl");
//exit;

?>
<html>
<head>
	<meta property="og:url" content="<?php echo $redirection; ?>" >
	<meta http-equiv="refresh" content="8; url=<?php echo $redirection; ?>">
	
	<script type="text/javascript">
		<?php if(!empty($redirection)):?>		
		setTimeout(function(){
			window.location = "<?php echo $redirection; ?>";
		},<?=$redition_sleep?>);
		<?php endif; ?>
	</script>
</head><body><h1 align='center' >Please Wait Loading...</h1> </body></html>
