<?php

//רושם משתמש חדש באתר כלא חבר 
add_action( 'user_register', 'new_user_to_bmby', 10, 1 );
function new_user_to_bmby( $user_id ) {
  if ( isset( $_POST['office_name'] ) ){
    update_user_meta( $user_id, 'office_name', sanitize_text_field($_POST['office_name'])); 
  }

  if ( isset( $_POST['billing_phone'] ) ){
    update_user_meta( $user_id, 'phone', sanitize_text_field($_POST['billing_phone'])); 
  }

  if ( isset( $_POST['billing_email'] ) ){
    update_user_meta( $user_id, 'billing_email', sanitize_text_field($_POST['billing_email'])); 
  }

  if ( isset( $_POST['license_number'] ) ){
    update_user_meta( $user_id, 'license_number', sanitize_text_field($_POST['license_number'])); 
  }

  if ( isset( $_POST['district'] ) ){
    update_user_meta( $user_id, 'district', sanitize_text_field($_POST['district'])); 
  }

  if ( isset( $_POST['billing_address_1'] ) ){
    update_user_meta( $user_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1'])); 
  }

  if ( isset( $_POST['district'] ) ){
    update_user_meta( $user_id, 'district', sanitize_text_field($_POST['district'])); 
  }

  bambyUser($user_id,'2968',null);
}

// add_action( 'woocommerce_order_status_completed', 'so_payment_complete' ,1,10);
add_action( 'woocommerce_order_status_processing', 'so_payment_complete' ,1,10);
function so_payment_complete( $order_id ){
    $order = wc_get_order( $order_id );
    $user = $order->get_user();
    // var_dump($user);
    // exit;
    //$wp_capabilities=get_user_meta($user->ID,'wp_capabilities');

    if( $order ){

        foreach ($order->get_items() as $item_id => $item_data) {
            $product = $item_data->get_product();
            if($product->get_id() == 3930){
                bambyUser($user->ID,$status = '2',$order_id);
                wp_update_user(array( 'ID' => $user->ID , 'role' => 'monthly_subscriptionnot_approve'));
            }
            send_price_offers($item_data,$user,$order_id);
        }  
    }
}

function htmlspecialchars_xml($value){
  $value=str_replace('&','_',$value);
  $value=str_replace('׳','',$value);
  $value=str_replace('"','',$value);
  return $value;
}


/*****************************************************
  bamby user serveis
*****************************************************/
function bambyUser($user_id,$status,$order_id){
    $userMeta = get_user_meta($user_id);
    // Kint::dump($userMeta);
    // exit;
    if(!empty($userMeta['billing_first_name'][0])){
      $fname=htmlspecialchars_xml($userMeta['billing_first_name'][0]);
    }else{
      $fname=htmlspecialchars_xml($userMeta['first_name'][0]);
    }

    if(!empty($userMeta['billing_last_name'][0])){
      $lname=($userMeta['billing_last_name'][0]);
    }else{
      $lname=htmlspecialchars_xml($userMeta['last_name'][0]);
    }
    
    // $fname=$userMeta['first_name'][0];
    // $lname=$userMeta['last_name'][0];
    $email=htmlspecialchars_xml($userMeta['billing_email'][0]);
    $phone_mobile=htmlspecialchars_xml($userMeta['phone'][0]);
    $district = htmlspecialchars_xml($userMeta['district'][0]); 
    $office_name = htmlspecialchars_xml($userMeta['office_name'][0]);
    $license_number = $userMeta['license_number'][0];
    $member_expiry_date = $userMeta['member_expiry_date'][0];
    $billing_address_1 = htmlspecialchars_xml($userMeta['billing_address_1'][0],ENT_XML1,UTF-8);
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
         {"project_id":{"value":"'.$district.'"},"user_id":{"value":50594},"update":{"value":1}, "status":{"value":"'.$status.'"},"fname":{"value":"'.$fname.'"},"lname":{"value":"'.$lname.'"},"phone_mobile":{"value":"'.$phone_mobile.'"},"phone_home":{"value":""},"email":{"value":"'.$email.'"},"remark":{"value":"'.$license_number.'"},"birth_day":{"value":"'.$member_expiry_date.'"},"address":{"value":"'.$billing_address_1.'"},"company_name":{"value":"'.$office_name.'"}}
    </jsonClient>
        </v3:Insert>
        </soapenv:Body>
    </soapenv:Envelope>';
    // Kint::dump($XML);
    // exit;


    
    $fileName = $order_id."xml";
    // $fileName="User_log_".date("d-m-Y_h:i:s").".xml";
    $filePath=$_SERVER["DOCUMENT_ROOT"]."/Users_Log/".$fileName;
    file_put_contents($filePath,$XML);

    $order = wc_get_order($order_id);
    $note = "<a href='".site_url()."/Users_Log/".$fileName."' target='_balnk'>משתמש חדש: xml לבמבי</a>";
    $order->add_order_note( $note );
    $order->save();
    


    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://www.bmby.com/WebServices/srv/v3/",
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
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
        $xml_response=xml2array($response);
        $ClientID = json_decode($xml_response['SOAP-ENV:Envelope']['SOAP-ENV:Body']['SOAP-ENV:InsertResponse']['InsertReturn']);
        // echo "ClientID : ".$ClientID->ClientID;
        $bamby_id = get_field('bamby_id', 'user_'.$user_id);
        // if(!empty($ClientID->ClientID) && empty($bamby_id)){
        if(!empty($ClientID->ClientID)){
          update_field('bamby_id', $ClientID->ClientID, 'user_'.$user_id);
          $note = "הלקוח עודכן בבמבי";
          $order->add_order_note( $note );
          $order->save();
        }else{
          wp_mail(array('info@link-in.co.il','‫office@realtors.org.il‬‏,‫amir@mayamedia.co.il‬'),'לשכה - שגיאה ברישום מתווך חדש','שגיאת רישום','',$filePath);
          $note = "הלקוח לא עודכן בבמבי";
          $order->add_order_note( $note );
          $order->save();
        }
    }

}


/*************************************
  Send to bamby price offers 
*************************************/ 
function send_price_offers($product,$user,$order_id){
    // Kint::dump($product);
    // Kint::dump($user);
    $userMeta=get_user_meta($user->ID);
    $product_name = $product->get_name($context = 'view');
    $prodact_price=$product->get_total($context = 'view');
    // Kint::dump($userMeta);
    $bmby_product_id=get_field($userMeta['district'][0],$product->get_product_id());


    $XML='<soapenv:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:pric="https://www.bmby.com/WebServices/srv/v3/price_offers.php">
    <soapenv:Header/>
    <soapenv:Body>
       <pric:Insert soapenv:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
            <Parameters xsi:type="pric:GetAllInput">
                <Login xsi:type="xsd:string">mekarkein</Login>
                <Password xsi:type="xsd:string">310719</Password>
                <ProjectID xsi:type="xsd:int">8520</ProjectID>
                <ClientID xsi:type="xsd:int">'.$userMeta['bamby_id'][0].'</ClientID>
                <Type xsi:type="soapenc:Array" xmlns:soapenc="http://schemas.xmlsoap.org/soap/encoding/">
                <!--You may enter ANY elements at this point-->
                </Type>
                <TypeString xsi:type="xsd:string"></TypeString>
                <SetPrivate xsi:type="xsd:int"></SetPrivate>
            </Parameters>
            <jsonClient xsi:type="xsd:string">
            {"project_id":{"value":'.$userMeta['district'][0].'},"user_id":{"value":50594},"bid_amount":{"value":'.$prodact_price.'},"client_id":{"value":'.$userMeta['bamby_id'][0].'},"bid_date":{"value":"'.date('Y-m-d').'"},"expected_to_close_up":{"value":"'.date('Y-m-d').'"},"invoiced_date":{"value":"'.date('Y-m-d').'"},"comments":{"value":""},"status":{"value":5},
            "products":[{"product_id":{"value":'.$bmby_product_id.'},"quantity":{"value":1},"price":{"value":'.$prodact_price.'},"price_total":{"value":'.$prodact_price.'}}
            ]}
            </jsonClient>
       </pric:Insert>
    </soapenv:Body>
 </soapenv:Envelope>';

// var_dump($XML);
// exit;




    //$fileName="price_offers_log_".date("d-m-Y_h:i:s").".xml";
    $fileName = $order_id."xml";
    $filePath=$_SERVER["DOCUMENT_ROOT"]."/Price_offers_Log/".$fileName;
    file_put_contents($filePath,$XML);

    $order = wc_get_order($order_id);
    $note = "<a href='".site_url()."/Price_offers_Log/".$fileName."' target='_balnk'>הזדמנות רכישה: xml לבמבי</a>";
    $order->add_order_note( $note );
    $order->save();
    


    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://www.bmby.com/WebServices/srv/v3/price_offers.php",
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
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      // echo $response;
              // var_dump($response);
              $xml_response=xml2array($response);
              $xml_response=xml2array($response);
              $PriceOfferID = json_decode($xml_response['SOAP-ENV:Envelope']['SOAP-ENV:Body']['SOAP-ENV:InsertResponse']['InsertReturn']);
              // Kint::dump($PriceOfferID->PriceOfferID);
              if(empty($PriceOfferID->PriceOfferID)){
                wp_mail(array('info@link-in.co.il','‫office@realtors.org.il‬‏,‫amir@mayamedia.co.il‬'),'לשכה - שגיאה בעדכון רכישה','שגיאת רכישה','',$filePath);
                $note = "הרכישה לא עודכנה בבמבי";
                $order->add_order_note( $note );
                $order->save();
              }else{
                $note = "הרכישה עודכנה בהצלחה בבמבי";
                $order->add_order_note( $note );
                $order->save();
              }

    }
}
