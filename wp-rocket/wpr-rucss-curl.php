<?php
// Send a curl request directly from the server to the RUCSS SaaS. 
// Is the same CURL request we send using Postman
//
// Upload this PHP file in the public_html folder. 
// EDIT the following fields and load it in the browser
$url= 'https://example.com/?nowprocket';
$wpr_email = 'your@email.com';
$wpr_api_key = 'yourkey';



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://saas.wp-rocket.me/api',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('url' => $url,'config[rucss_safelist][]' => '','credentials[wpr_email]' => $wpr_email ,'credentials[wpr_key]' => $wpr_api_key,'config[treeshake]' => '1','config[is_home]' => '0','config[is_mobile]' => ''),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;