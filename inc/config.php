<?php
include_once("inc/facebook.php"); //include facebook SDK
######### Facebook API Configuration ##########
$appId = '1780066375564741'; //Facebook App ID
$appSecret = '95d26a249dd3e2d89a75f5e8a4ecb977'; // Facebook App Secret
$homeurl = 'http://localhost:9090/dquip/login.php';  //return to home
$fbPermissions = 'email';  //Required facebook permissions

//Call Facebook API
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $appSecret

));
$fbuser = $facebook->getUser();
?>