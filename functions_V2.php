<?php

/*************************************
  Send to bamby user buy member ticket 
*************************************/ 
function send_purchase_date($user){
    $bamby_id = get_field('bamby_id','user_'.$user->ID);
    $district = get_field('district','user_'.$user->ID);
    $phone = get_field('phone','user_'.$user->ID);
    $member_purchase_date = get_field('member_purchase_date','user_'.$user->ID);
    $member_purchase_date = date('Y-m-d',strtotime($member_purchase_date));

    $client = new http\Client;
    $request = new http\Client\Request;
    
    $body = new http\Message\Body;

    $xml='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v3="https://www.bmby.com/WebServices/srv/v3/clients.php">
    <soapenv:Header/>
    <soapenv:Body>
       <v3:Insert soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
            <Parameters xsi:type="v3:GetAllInput">
                <!--You may enter the following 17 items in any order-->
            <Login xsi:type="xsd:string">mekarkein</Login>
                <Password xsi:type="xsd:string">310719</Password>
                <ProjectID xsi:type="xsd:int">'.$district.'</ProjectID>
                <UniqID xsi:type="xsd:int"></UniqID>
                <TaskID xsi:type="xsd:int"></TaskID>
                <ClientID xsi:type="xsd:int"></ClientID>
                <OwnerID xsi:type="xsd:int"></OwnerID>
                <ContractID xsi:type="xsd:int"></ContractID>
                <Dynamic xsi:type="xsd:int"></Dynamic>
                <Limit xsi:type="xsd:int"></Limit>
                <Offset xsi:type="xsd:int"></Offset>
                <OrderDesc xsi:type="xsd:int"></OrderDesc>
                <FromDate xsi:type="xsd:string"></FromDate>
                <ToDate xsi:type="xsd:string"></ToDate>
                <Type xsi:type="soapenc:Array" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
                    <!--You may enter ANY elements at this point-->
                </Type>
                <TypeString xsi:type="xsd:string"></TypeString>
                <SetPrivate xsi:type="xsd:int"></SetPrivate>
            </Parameters>
            <jsonClient xsi:type="xsd:string">
            {"project_id":{"value":"'.$district.'"},"user_id":{"value":50594},"update":{"value":1}," email":{"value":"'.$user->user_email.'"},"phone_home":{"value":"'.$phone.'"}}}
            </jsonClient>
        </v3:Insert>
    </soapenv:Body>
    </soapenv:Envelope>';

    file_put_contents($_SERVER["DOCUMENT_ROOT"]."/Member_Purchase_Log/Member_Purchase_Log_".date("d-m-Y h-m-s").".txt",$xml);

    $body->append($xml);
    
    $request->setRequestUrl('https://www.bmby.com/WebServices/srv/');
    $request->setRequestMethod('POST');
    $request->setBody($body);
    
    $request->setHeaders(array(
      'cache-control' => 'no-cache',
      'Connection' => 'keep-alive',
      'Content-Length' => '1919',
      'Accept-Encoding' => 'gzip, deflate',
      'Host' => 'www.bmby.com',
      'Postman-Token' => 'a31c36ed-1435-4116-91ed-f20333c4860f,90b208db-e37e-4354-9680-5cdecee258c2',
      'Cache-Control' => 'no-cache',
      'Accept' => '*/*',
      'User-Agent' => 'PostmanRuntime/7.15.2',
      'Content-Type' => 'text/xml'
    ));
    
    $client->enqueue($request)->send();
    $response = $client->getResponse();

    echo "bamby_id : ".$bamby_id."<br>phone : ".$phone;


    exit;
}

/*****************************************************
  Add new user to bamby after registration in wp  
*****************************************************/
function addUserBamby(){
    $fname=sanitize_text_field( $_POST['firname']);
    $lname=sanitize_text_field($_POST['lasname']);
    $email=sanitize_text_field( $_POST['mail_id']);
    $phone_mobile=sanitize_text_field($_POST['phone']);
    $district = sanitize_text_field($_POST['district']); 
    $office_name = sanitize_text_field($_POST['office_name']);
    $license_number =  sanitize_text_field($_POST['licenseNumber']);
    $expertise = sanitize_text_field($_POST['expertise']);
    $XML='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v3="https://www.bmby.com/WebServices/srv/v3">
    <soapenv:Header/>
    <soapenv:Body>
       <v3:Insert soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
          <Parameters xsi:type="v3:GetAllInput">
             <!--You may enter the following 17 items in any order-->
        <Login xsi:type="xsd:string">mekarkein</Login>
             <Password xsi:type="xsd:string">310719</Password>
             <ProjectID xsi:type="xsd:int">8524</ProjectID>
             <UniqID xsi:type="xsd:int"></UniqID>
             <TaskID xsi:type="xsd:int"></TaskID>
             <ClientID xsi:type="xsd:int"></ClientID>
             <OwnerID xsi:type="xsd:int"></OwnerID>
             <ContractID xsi:type="xsd:int"></ContractID>
             <Dynamic xsi:type="xsd:int"></Dynamic>
             <Limit xsi:type="xsd:int"></Limit>
             <Offset xsi:type="xsd:int"></Offset>
             <OrderDesc xsi:type="xsd:int"></OrderDesc>
             <FromDate xsi:type="xsd:string"></FromDate>
             <ToDate xsi:type="xsd:string"></ToDate>
             <Type xsi:type="soapenc:Array" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
                  <!--You may enter ANY elements at this point-->
             </Type>
             <TypeString xsi:type="xsd:string"></TypeString>
             <SetPrivate xsi:type="xsd:int"></SetPrivate>
          </Parameters>
          <jsonClient xsi:type="xsd:string">
         {"project_id":{"value":'.$district.'},"user_id":{"value":50594},"update":{"value":1}, "status":{"value":2},"fname":{"value":"'.$fname.'"},"lname":{"value":"'.$lname.'"},"phone_mobile":{"value":"'.$phone_mobile.'"},"phone_home":{"value":"'.$phone_mobile.'"},"email":{"value":"'.$email.'"},"remark":{"value":"'.$license_number.'"}}
    </jsonClient>
        </v3:Insert>
        </soapenv:Body>
    </soapenv:Envelope>';
    $fileName="User_log_".date("d-m-Y h-m-s").".xml";
    $filePath=$_SERVER["DOCUMENT_ROOT"]."/New_Users_Log/".$fileName;
    file_put_contents($filePath,$XML);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.bmby.com/WebServices/srv/v3",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $XML,
      CURLOPT_HTTPHEADER => array(
        "Accept: */*",
        "Connection: keep-alive",
        "Content-Type: application/xml",
        "Host: www.bmby.com",
        "cache-control: no-cache"
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    // if ($err) {
    //   echo "cURL Error #:" . $err;
    // } else {
    //   echo $response;
    // }
    // exit;

}


/***************************** 
chainge all users role to מסרב
******************************/
// global $wpdb;
// $q="SELECT DISTINCT `user_id` FROM `wp_usermeta` WHERE 1";
// $results = $wpdb->get_results( $q, OBJECT );
// // Kint::dump($results);
// // exit;
// foreach($results as $r){
   
//     if($r->user_id != "1" && $r->user_id != "229"){        
//         update_field( 'field_5d7a0d56f000e', 'מסרב', 'user_'.$r->user_id );
//         $user_id = wp_update_user(array("ID"=>$r->user_id,"role"=>"customer"));
//     }
// }


// $client = new http\Client;
// var_dump($client);
// exit;

// $request = new http\Client\Request;

// $body = new http\Message\Body;


// function auto_login_new_user( $user_id ) {
//     wp_set_current_user($user_id);
//     wp_set_auth_cookie($user_id,false);
//     $user = get_user_by( 'id', $user_id );
//     do_action( 'wp_login', $user->email ,$user );
//     wp_redirect( home_url() ); // You can change home_url() to the specific URL,such as "wp_redirect( 'http://www.wpcoke.com' )";
//         echo "logggg";
//     exit;
// }


// add_action( 'user_register', 'auto_login_new_user' );
// if(!is_user_logged_in()){
//     do_action( 'user_register', 855);
// }
// if(is_user_logged_in()){
//    echo "login";
// }

// function prevent_email_domain( $user_login, $user_email, $errors ) {
// exit;
// }
// add_action( 'woocommerce_review_order_before_submit', 'prevent_email_domain', 10, 3 );




add_filter( 'woocommerce_checkout_fields' , 'override_checkout_city_fields' );
function override_checkout_city_fields( $fields ) {
    // var_dump($fields);
    // $option_cities_acf = get_field('address_area', 'option');

    // foreach($option_cities_acf as $city){
    //     $option_cities[$city['city']] = $city['city']; 
    // }

    $fields['billing']['billing_phone']['value'] = '0528676516';
    // $fields['billing']['billing_city']['options'] = $option_cities;
    // $fields['shipping']['shipping_city']['type'] = 'select';
    // $fields['shipping']['shipping_city']['options'] = $option_cities;

    return $fields;
}

/*****************************************************
  Add new user to bamby after pay in wp  
*****************************************************/
function newUserBamby($user){
  // Kint::dump($user->data);
  $userMeta = get_user_meta($user->ID);
  // Kint::dump($userMeta);
  // exit;
  $fname=$userMeta['first_name'][0];
  $lname=$userMeta['last_name'][0];
  $email=$user->data->user_email;
  $phone_mobile=$userMeta['phone'][0];
  $district = $userMeta['district'][0]; 
  $office_name = $userMeta['office_name'][0];
  $license_number = $userMeta['license_number'][0];
  $member_expiry_date = $userMeta['member_expiry_date'][0];
  $billing_address_1 = $userMeta['billing_address_1'][0];
  // $expertise = sanitize_text_field($_POST['expertise']);
  $XML='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v3="https://www.bmby.com/WebServices/srv/v3">
  <soapenv:Header/>
  <soapenv:Body>
     <v3:Insert soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
        <Parameters xsi:type="v3:GetAllInput">
           <!--You may enter the following 17 items in any order-->
      <Login xsi:type="xsd:string">mekarkein</Login>
           <Password xsi:type="xsd:string">310719</Password>
           <ProjectID xsi:type="xsd:int">'.$district.'</ProjectID>
           <UniqID xsi:type="xsd:int"></UniqID>
           <TaskID xsi:type="xsd:int"></TaskID>
           <ClientID xsi:type="xsd:int"></ClientID>
           <OwnerID xsi:type="xsd:int"></OwnerID>
           <ContractID xsi:type="xsd:int"></ContractID>
           <Dynamic xsi:type="xsd:int"></Dynamic>
           <Limit xsi:type="xsd:int"></Limit>
           <Offset xsi:type="xsd:int"></Offset>
           <OrderDesc xsi:type="xsd:int"></OrderDesc>
           <FromDate xsi:type="xsd:string"></FromDate>
           <ToDate xsi:type="xsd:string"></ToDate>
           <Type xsi:type="soapenc:Array" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
                <!--You may enter ANY elements at this point-->
           </Type>
           <TypeString xsi:type="xsd:string"></TypeString>
           <SetPrivate xsi:type="xsd:int"></SetPrivate>
        </Parameters>
        <jsonClient xsi:type="xsd:string">
       {"project_id":{"value":'.$district.'},"user_id":{"value":50594},"update":{"value":1}, "status":{"value":"2967"},"fname":{"value":"'.$fname.'"},"lname":{"value":"'.$lname.'"},"phone_mobile":{"value":"'.$phone_mobile.'"},"phone_home":{"value":""},"email":{"value":"'.$email.'"},"remark":{"value":"'.$license_number.'"},"birth_day":{"value":"'.$member_expiry_date.'"},"address":{"value":"'.$billing_address_1.'"}}
  </jsonClient>
      </v3:Insert>
      </soapenv:Body>
  </soapenv:Envelope>';
  //Kint::dump($XML);
  // exit;
  $fileName="User_log_".date("d-m-Y h-m-s").".xml";
  $filePath=$_SERVER["DOCUMENT_ROOT"]."/New_Users_Log/".$fileName;
  file_put_contents($filePath,$XML);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.bmby.com/WebServices/srv/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $XML,
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      "Connection: keep-alive",
      "Content-Type: application/xml",
      "Host: www.bmby.com",
      "cache-control: no-cache"
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  // if ($err) {
  //   echo "cURL Error #:" . $err;
  // } else {
  //   echo $response;
  // }
  // exit;

}

/*****************************************************
Update user to bamby after pay in wp  
*****************************************************/
function updateUserBamby($user){
  // Kint::dump($user->data);
  $userMeta = get_user_meta($user->ID);
  // Kint::dump($userMeta);
  // exit;
  $fname=$userMeta['first_name'][0];
  $lname=$userMeta['last_name'][0];
  $email=$user->data->user_email;
  $phone_mobile=$userMeta['phone'][0];
  $district = $userMeta['district'][0]; 
  $office_name = $userMeta['office_name'][0];
  $license_number = $userMeta['license_number'][0];
  $member_expiry_date = $userMeta['member_expiry_date'][0];
  $billing_address_1 = $userMeta['billing_address_1'][0];
  // $expertise = sanitize_text_field($_POST['expertise']);
  $XML='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v3="https://www.bmby.com/WebServices/srv/v3">
  <soapenv:Header/>
  <soapenv:Body>
     <v3:Insert soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
        <Parameters xsi:type="v3:GetAllInput">
           <!--You may enter the following 17 items in any order-->
      <Login xsi:type="xsd:string">mekarkein</Login>
           <Password xsi:type="xsd:string">310719</Password>
           <ProjectID xsi:type="xsd:int">'.$district.'</ProjectID>
           <UniqID xsi:type="xsd:int"></UniqID>
           <TaskID xsi:type="xsd:int"></TaskID>
           <ClientID xsi:type="xsd:int"></ClientID>
           <OwnerID xsi:type="xsd:int"></OwnerID>
           <ContractID xsi:type="xsd:int"></ContractID>
           <Dynamic xsi:type="xsd:int"></Dynamic>
           <Limit xsi:type="xsd:int"></Limit>
           <Offset xsi:type="xsd:int"></Offset>
           <OrderDesc xsi:type="xsd:int"></OrderDesc>
           <FromDate xsi:type="xsd:string"></FromDate>
           <ToDate xsi:type="xsd:string"></ToDate>
           <Type xsi:type="soapenc:Array" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
                <!--You may enter ANY elements at this point-->
           </Type>
           <TypeString xsi:type="xsd:string"></TypeString>
           <SetPrivate xsi:type="xsd:int"></SetPrivate>
        </Parameters>
        <jsonClient xsi:type="xsd:string">
       {"project_id":{"value":'.$district.'},"user_id":{"value":50594},"update":{"value":1}, "status":{"value":"2"},"fname":{"value":"'.$fname.'"},"lname":{"value":"'.$lname.'"},"phone_mobile":{"value":"'.$phone_mobile.'"},"phone_home":{"value":""},"email":{"value":"'.$email.'"},"remark":{"value":"'.$license_number.'"},"birth_day":{"value":"'.$member_expiry_date.'"},"address":{"value":"'.$billing_address_1.'"}}
  </jsonClient>
      </v3:Insert>
      </soapenv:Body>
  </soapenv:Envelope>';
  //Kint::dump($XML);
  // exit;
  $fileName="User_log_".date("d-m-Y h-m-s").".xml";
  $filePath=$_SERVER["DOCUMENT_ROOT"]."/Update_Users_Log/".$fileName;
  file_put_contents($filePath,$XML);

  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.bmby.com/WebServices/srv/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => $XML,
    CURLOPT_HTTPHEADER => array(
      "Accept: */*",
      "Connection: keep-alive",
      "Content-Type: application/xml",
      "Host: www.bmby.com",
      "cache-control: no-cache"
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  // if ($err) {
  //   echo "cURL Error #:" . $err;
  // } else {
  //   echo $response;
  // }
  // exit;

}
