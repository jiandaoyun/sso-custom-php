<?php
require __DIR__ . '/vendor/autoload.php';
use \Firebase\JWT\JWT;

$config = array(
   'acs' => 'https://www.jiandaoyun.com/sso/custom/5d03911587833c7bf2e19c38/acs',
   'secret' => 'jdy',
   'issuer' => 'com.example',
   'username' => 'angelmsger'
);
$request = $_GET['request'];
$state = $_GET['state'];
// Should Check Detail in Prod
$decoded = (array) JWT::decode($request, $config['secret'], array('HS256'));
if ($decoded['type'] == 'sso_req') {
   $encoded = JWT::encode(array(
       'type' => 'sso_res',
       'username' => $config['username'],
       'iss' => $config['issuer'],
       'aud' => 'com.jiandaoyun',
       'exp' => time() + 3600
   ), $config['secret']);
   header('Location: ' . $config['acs'] . '?response=' . $encoded . '&state=' . $state);
} else {
   echo 'Bad Request.';
}
die();
?>
