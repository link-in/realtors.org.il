<?php 

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Template Name: users_import */ 
get_header();
/*
https://realtors.org.il/%d7%99%d7%91%d7%95%d7%90-%d7%9e%d7%a9%d7%aa%d7%9e%d7%a9%d7%99%d7%9d/

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

חבר לשכה שנתי = author = 2967
חבר לשכה חדש = monthly_subscriptionnot_approve = 2
חבר לשכה חתום חודשי = new_monthly_subscriptionnot = 2966
לא חבר לשכה = customer = 2968
לא בתוקף = expired_membership = 3185
*/
?>
<div class="row response">
<form style="
    max-width: 450px;
    margin: auto;
    background: #eee;
    border-radius: 5px;
    padding: 20px;
">
    <h2>יבוא / עדכון משתמשים לפי מחוז </h2>
  <div class="form-group">
    <label for="exampleInputEmail1">בחירת מחוז</label>

    <select name="districts" class="form-control">
        <option value="0">יש לבחור מחוז</option>
        <option value="8524">מחוז גוש דן</option>
        <option value="8520">מחוז ירושלים</option>
        <option value="8535">מחוז הדרום והנגב</option>
        <option value="8537">מחוז העמקים והגליל העליון</option>
        <option value="8521">מחוז השפלה</option>
        <option value="8522">מחוז השרון</option>
        <option value="8538">מחוז חיפה והגליל המערבי</option>
        <option value="8523">מחוז מישור החוף הצפוני</option>
        <option value="00">כולם</option>
    </select>

        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
    <br>
    <button type="submit" name="send" value="send" class="btn btn-primary form-control">שלח</button>
</form>
</div>

<div class="row response" style="padding: 20px;">

<?php

if(isset($_GET['send'])){
    $districts = sanitize_text_field($_GET['districts']);
    if($districts == '00'){
        $districts = array(8524,8535,8537,8521,8522,8536,8520,8538,8523);
    }
    echo "מספר מחוז שנבחר : ";    
    if(is_array($districts)){
        foreach($districts as $d){
            echo $d." ";;
            curl_users($d);
            sleep(1);
            // exit;
        }
        echo "<h2>הסתיים בהצלחה</h2>";
    }else{
        echo $districts." ";
        curl_users($districts);
        echo "<h2>הסתיים בהצלחה</h2>";
    }

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
    addUserToWp( $users );
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

// function xml2array moved to function.php



function addUserToWp($users){
    global $wpdb;


    echo "<h1>מס הלקוחות: ".count($users['clients']['row'])."</h1>";
    foreach($users['clients']['row'] as $user){
        // Kint::dump($user);
        foreach ($user as &$str) {
            $str = str_replace('Array', '', $str);
            if(empty($str)){$str = '';}
        }
        /*
        חבר לשכה שנתי = author = 2967
        חבר לשכה חדש = monthly_subscriptionnot_approve = 2
        חבר לשכה חתום חודשי = new_monthly_subscriptionnot = 2966
        לא חבר לשכה = customer = 2968
        לא בתוקף = expired_membership = 3185
        */

        if($user['status'] == "חבר לשכה שנתי"){
            $role = 'author';
        }elseif($user['status'] == "חבר לשכה חדש"){
            $role = 'monthly_subscriptionnot_approve';
        }elseif($user['status'] == "חבר לשכה חתום חודשי"){
            $role = 'new_monthly_subscriptionnot';
        }elseif($user['status'] == "לא חבר בלשכה"){
            $role = 'customer';
        }elseif($user['status'] == "לא בתוקף"){
            $role = 'expired_membership';
        }
        // Kint::dump($user);
        // var_dump($role);
        // exit;
        $fullName = $user['fname']." ".$user['lname'];
        $fullName = str_replace('Array','',$fullName);
        
        echo "<ul>
            <li>fullName : ".$fullName." </li>
            <li>email : ".$user['email']." </li>
            <li>district : ".$user['project_id']." </li>
            <li>status : ".$user['status']." </li>
            <li>phone : ".$user['phone_mobile']." </li>
            <li>license_number : ".$user['remark']." </li> 
            <li>bamby_id : ".$user['client_id']." </li> 
            <li>district : ".$user['project_title']." </li> 
            <li>status : ".$user['status']." </li> 
            <li>role : ".$role." </li> 
            <li>office_name : ".$user['company_name']." </li> 
            <li>member_expiry_date : ".$user['birth_day']." </li> 
            <li>member_purchase_date : ".$user['client_date']." </li> 
            <li>city : ".$user['city']." </li> 
            <li>project_id : ".$user['project_id']." </li> 
            <li>address : ".$user['address']."</li>
        </ul>
        <hr>";

        if(empty($user['email'])){
            $file_ = $_SERVER["DOCUMENT_ROOT"]."/Users_Log/".'users_log.txt';
            $d = date("d-m-Y h:m:s")." | bamby_id : ".$user['client_id']." | no email".PHP_EOL;
            file_put_contents($file_, $d, FILE_APPEND);
            continue;
        }

        $user_id = get_user_by('email',$user['email']);
        $user_id = $user_id->ID;
        if(!empty($user_id)){
            //update user
            updateUsermeta($user_id,$user,$role);
        }else{
            //new user
            $userdata = array(
                'ID'                    => '',    //(int) User ID. If supplied, the user will be updated.
                'user_pass'             => md5(randomPassword()),   //(string) The plain-text user password.
                'user_login'            => $user['email'],   //(string) The user's login username.
                'user_nicename'         => $fullName,   //(string) The URL-friendly user name.
                'user_email'            => $user['email'],   //(string) The user email address.
                'display_name'          => $fullName,   //(string) The user's display name. Default is the user's username.
                'nickname'              => $fullName,   //(string) The user's nickname. Default is the user's username.
                'first_name'            => $user['fname'],   //(string) The user's first name. For new users, will be used to build the first part of the user's display name if $display_name is not specified.
                'last_name'             => $user['lname'],   //(string) The user's last name. For new users, will be used to build the second part of the user's display name if $display_name is not specified.
                'role'                  => $role,   //(string) User's role.
                'user_registered' =>    date('Y-m-d h:i:s')
            );

            $user_id=wp_insert_user($userdata);
            if( is_wp_error( $user_id  ) ) {     
                echo $return->get_error_message();
            }   

            // $user_id=452;
            if(is_int($user_id)){
                updateUsermeta($user_id,$user,$role);
            }else{
                $file_ = $_SERVER["DOCUMENT_ROOT"]."/Users_Log/".'users_log.txt';
                $d = date("d-m-Y h:m:s")." | email : ".$user['email']." | new user error".PHP_EOL;
                file_put_contents($file_, $d, FILE_APPEND);
               echo "משתמש לא עודכן ".$user['email']."<br>";
            }

        }//end new user
        // exit;

    }//loop users
}


function updateUsermeta($user_id,$user,$role){
    echo "User id : ".$user_id."<hr>";

    $user_data = array( 'ID' => $user_id );

    if(!empty($user['phone_mobile'])){
        $user_data['phone'] = $user['phone_mobile'];
        // update_field( 'phone', $user['phone_mobile'], 'user_'.$user_id );
        update_user_meta( $user_id, 'phone', $user['phone_mobile']); 
        update_user_meta( $user_id, 'billing_phone', $user['phone_mobile']); 
    }

    if(!empty($user['remark'])){
        update_user_meta( $user_id, 'license_number', $user['remark']);         
    }

    if(!empty($user['project_id'])){
        //update_field( 'field_5d4bf4ee5e5d0', $user['project_id'], 'user_'.$user_id );//district  
        update_field( 'field_5d4bf4ee5e5d0', 'מחוז מישור החוף הצפוני', 'user_'.$user_id );//district  
    }

    if(!empty($user['status'])){
        update_field( 'field_5d7a0d56f000e', $user['status'], 'user_'.$user_id );//status   
    }

    if(!empty($user['company_name'])){
        update_user_meta( $user_id, 'office_name', $user['company_name']);        
        // $user_data['office_name'] = $user['company_name'];  
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
        update_user_meta( $user_id, 'bamby_id', $user['client_id']);
        // $user_data['bamby_id'] = $user['client_id']; 
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
        $file_ = $_SERVER["DOCUMENT_ROOT"]."/Users_Log/".'users_log.txt';
        $d = date("d-m-Y h:m:s")." | email : ".$user['email']." | update user error".PHP_EOL;
        file_put_contents($file_, $d, FILE_APPEND);
        $error_string = $user_id->get_error_message();
        echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
    } else {
        // echo 'Success!';
    }
}

?>
</div>
<?php
get_footer();