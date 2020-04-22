<?php

$url = "https://capi.inforu.co.il/api/v2/Contact/CreateOrUpdateContacts";
// $username = "realtorsco";
// $token = "zxcpjaxui9n03ulukrduywol5";
$username = "district1";
$token = "h0xf2bhnkuroednp4wh7tc734";
$request = array();
$request["Data"] = array();
$request["Data"]["List"] = array();
$request["Data"]["List"][] = array(
"FirstName"=>"David",
"LastName"=>"Cohen",
"Phone"=>"0589995551",
"Email"=>"Cohen@test.com",
"AddToGroupName"=>"",
);
$json = json_encode($request);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json; charset=utf-8',
));
curl_setopt($ch, CURLOPT_USERPWD, $username.":".$token);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json );
$response = curl_exec($ch);
curl_close ($ch);
$result = json_decode($response,true);
print_r($result);

