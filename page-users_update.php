<?php 
/* Template Name: users_update */ 
/*
echo "<h1>יבוא משתמשים</h1>";
8436 לשכת מתווכי הנדלן
8524 מחוז גוש דן
8535 מחוז הדרום והנגב
8537 מחוז העמקים והגליל העליון
8521 מחוז השפלה
8522 מחוז השרון
8536 מחוז חיפה והגליל המערבי
8520 מחוז ירושלים
8538 מחוז מישור החוף הדרומי
8523 מחוז מישור החוף הצפוני 
*/

exit('fdsf');



//$districts = array(8524,8535,8537,8521,8522,8536,8520,8538,8523);
$districts = array(8521,8520);
foreach($districts as $d){
    curl_users($d);
    sleep(1);
    // exit;

}

function curl_users($projectID){
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://www.bmby.com/WebServices/srv/",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:srv=\"https://www.bmby.com/WebServices/srv/\">\n   <soapenv:Header/>\n   <soapenv:Body>\n      <srv:GetAll soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">\n         <Parameters xsi:type=\"srv:GetAllInput\">\n            <!--You may enter the following 13 items in any order-->\n            <Login xsi:type=\"xsd:string\">mekarkein</Login>\n            <Password xsi:type=\"xsd:string\">310719</Password>\n            <ProjectID xsi:type=\"xsd:int\">".$projectID."</ProjectID>\n            <Dynamic xsi:type=\"xsd:int\">1</Dynamic>\n            <UniqID xsi:type=\"xsd:int\">1</UniqID>\n            <OwnerID xsi:type=\"xsd:int\"></OwnerID>\n            <ContractID xsi:type=\"xsd:int\"></ContractID>\n            <Dynamic xsi:type=\"xsd:int\"></Dynamic>\n            <FromDate xsi:type=\"xsd:string\"></FromDate>\n            <ToDate xsi:type=\"xsd:string\"></ToDate>\n                 <Type xsi:type=\"soapenc:Array\" xmlns:soapenc=\"http://schemas.xmlsoap.org/soap/encoding/\">\n               <!--You may enter ANY elements at this point-->\n            </Type>\n            <TypeString xsi:type=\"xsd:string\">?</TypeString>\n         </Parameters>\n      </srv:GetAll>\n   </soapenv:Body>\n</soapenv:Envelope>",
    CURLOPT_HTTPHEADER => array(
        "Accept: */*",
        "Accept-Encoding: gzip, deflate",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Content-Length: 1349",
        "Content-Type: text/xml",
        "Host: www.bmby.com",
        "Postman-Token: e388b3aa-3425-4f56-8b89-783027222573,bb85bc75-878e-4bd9-8071-21c7d2fe8be0",
        "User-Agent: PostmanRuntime/7.15.2",
        "cache-control: no-cache"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    exit;
    }


    $xml = xml2array($response);
    $data = $xml['SOAP-ENV:Envelope']['SOAP-ENV:Body']['SOAP-ENV:GetAllResponse']['GetAllReturn']['Data'];
    $users = xml2array($data);
    // Kint::dump($users);
    // exit;
    addUserToWp( $users , $projectID);
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function xml2array($contents, $get_attributes=1, $priority = 'tag') { 
    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 

    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(''); 
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); # http://minutillo.com/steve/weblog/2004/6/17/php-xml-and-character-encodings-a-tale-of-sadness-rage-and-data-loss 
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 
    xml_parse_into_struct($parser, trim($contents), $xml_values); 
    xml_parser_free($parser); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; //Refference 

    //Go through the tags. 
    $repeated_tag_index = array();//Multiple tags with same name will be turned into an array 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 

        //This command will extract these variables into the foreach scope 
        // tag(string), type(string), level(int), attributes(array). 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = array(); 
        $attributes_data = array(); 
         
        if(isset($value)) { 
            if($priority == 'tag') $result = $value; 
            else $result['value'] = $value; //Put the value in a assoc array if we are in the 'Attribute' mode 
        } 

        //Set the attributes too. 
        if(isset($attributes) and $get_attributes) { 
            foreach($attributes as $attr => $val) { 
                if($priority == 'tag') $attributes_data[$attr] = $val; 
                else $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
            } 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 
            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                if($attributes_data) $current[$tag. '_attr'] = $attributes_data; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 

                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 

                if(isset($current[$tag][0])) {//If there is a 0th element it is already an array 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                    $repeated_tag_index[$tag.'_'.$level]++; 
                } else {//This section will make the value an array if multiple tags with the same name appear together 
                    $current[$tag] = array($current[$tag],$result);//This will combine the existing item and the new item together to make an array 
                    $repeated_tag_index[$tag.'_'.$level] = 2; 
                     
                    if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well 
                        $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                        unset($current[$tag.'_attr']); 
                    } 

                } 
                $last_item_index = $repeated_tag_index[$tag.'_'.$level]-1; 
                $current = &$current[$tag][$last_item_index]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 
                $repeated_tag_index[$tag.'_'.$level] = 1; 
                if($priority == 'tag' and $attributes_data) $current[$tag. '_attr'] = $attributes_data; 

            } else { //If taken, put all things inside a list(array) 
                if(isset($current[$tag][0]) and is_array($current[$tag])) {//If it is already an array... 

                    // ...push the new element into that array. 
                    $current[$tag][$repeated_tag_index[$tag.'_'.$level]] = $result; 
                     
                    if($priority == 'tag' and $get_attributes and $attributes_data) { 
                        $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; 

                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value 
                    $repeated_tag_index[$tag.'_'.$level] = 1; 
                    if($priority == 'tag' and $get_attributes) { 
                        if(isset($current[$tag.'_attr'])) { //The attribute of the last(0th) tag must be moved as well 
                             
                            $current[$tag]['0_attr'] = $current[$tag.'_attr']; 
                            unset($current[$tag.'_attr']); 
                        } 
                         
                        if($attributes_data) { 
                            $current[$tag][$repeated_tag_index[$tag.'_'.$level] . '_attr'] = $attributes_data; 
                        } 
                    } 
                    $repeated_tag_index[$tag.'_'.$level]++; //0 and 1 index is already taken 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 
     
    return($xml_array); 
}  

function addUserToWp($users,$projectID){
    global $wpdb;

    // Kint::dump($users['clients']['row']);
    echo "<h1>מס הלקוחות: ".count($users['clients']['row'])."</h1>";
    foreach($users['clients']['row'] as $user){
        // Kint::dump($user);
        // exit;
        // Kint::dump($user['birth_day']);
        // exit;
        if($user['status'] == "חבר לשכה"){
            $role = 'author';
        }else{
            $role = 'customer';
        }
        $user_id = get_user_by('email',$user['email']);
        $user_id = $user_id->ID;
        if(!empty($user_id)){
            echo "1";
        }else{
            echo "22";
        }
exit;
        echo "
        userid : ".$user_id." |
        email : ".$user['email']." |
        district : ".$user['project_id']." |
        phone : ".$user['phone_mobile']." |
        license_number : ".$user['Dynamic']['row'][1]['value']." | 
        bamby_id : ".$user['client_id']." | 
        district : ".$user['project_title']." | 
        status : ".$user['status']." | 
        role : ".$role." | 
        office_name : ".$user['company_name']." | 
        member_expiry_date : ".$user['birth_day']." | 
        member_purchase_date : ".$user['client_date']." | 
        city : ".$user['city']." | 
        project_id : ".$user['project_id']." | 
        address : ".$user['address']."
        
        <br>";

        $fullName = $user['fname']." ".$user['lname'];

        $user_data = array( 'ID' => $user_id );

        if(!empty($user['phone_mobile'])){
            $user_data['phone'] = $user['phone_mobile'];
            // update_user_meta( $user_id, 'phone', $user['phone_mobile']);                
        }

        if(!empty($user['Dynamic']['row'][1]['value'])){
            // update_user_meta( $user_id, 'license_number', $user['Dynamic']['row'][1]['value']);         
            $user_data['license_number'] = $user['Dynamic']['row'][1]['value'];
        }

        if(!empty($user['Dynamic'][0])){
            // update_user_meta( $user_id, 'bamby_id', $user['Dynamic'][0]); 
            $user_data['bamby_id'] = $user['Dynamic'][0];
        }

        if(!empty($user['project_id'])){
            update_field( 'field_5d4bf4ee5e5d0', $user['project_id'], 'user_'.$user_id );//district  
                        
        }

        if(!empty($user['status'])){
            update_field( 'field_5d7a0d56f000e', $user['status'], 'user_'.$user_id );//status   
        }

        if(!empty($user['company_name'])){
            //update_user_meta( $user_id, 'office_name', $user['company_name']);        
            $user_data['office_name'] = $user['company_name'];  
        }
        if(!empty($user['city'])){
            //update_user_meta( $user_id, 'billing_city', $user['city']);
            $user_data['billing_city'] = $user['city'];  
        }

        if(!empty($user['address'])){
            //update_user_meta( $user_id, 'billing_address_1', $user['address']);
            $user_data['billing_address_1'] = $user['address']; 
        }

        if(!empty($user['client_id'])){
            //update_user_meta( $user_id, 'bamby_id', $user['client_id']);
            $user_data['bamby_id'] = $user['client_id']; 
        }

        if(!empty($user['client_date'])){
            $update_date=update_field('member_purchase_date', $user['client_date'], 'user_'.$user_id);
        }

        if(!empty($user['birth_day'])){
            //update_user_meta( $user_id, 'bamby_id', $user['client_id']);
            $user_data['member_expiry_date'] = $user['birth_day']; 
            $update_date=update_field('member_expiry_date', $user['birth_day'], 'user_'.$user_id);
        }
         
        if(!empty($role)){
          //update_user_meta( $user_id, 'role', $role);
          $user_data['role'] = $role; 
        }   
        
        $user_id = wp_update_user($user_data);
        // var_dump($user_data);
        // exit;
        if ( is_wp_error( $user_id ) ) {
            $error_string = $user_id->get_error_message();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        } else {
            // echo 'Success!';
        }

    }
}

echo "end";
