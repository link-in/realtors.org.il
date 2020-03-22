<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
8436 לשכת מתווכי הנדלן
8524 מחוז גוש דן
8535 מחוז הדרום והנגב
8537 הלשכה המסחרית
8521 מחוז השפלה
8522 מחוז השרון
8536 מחוז חיפה והגליל המערבי
8520 מחוז ירושלים
8538 פתח תקווה ראש העין והשומרון
8523 מחוז מישור החוף הצפוני 

חבר לשכה שנתי = author = 2967
חבר לשכה חדש = monthly_subscriptionnot_approve = 2
חבר לשכה חתום חודשי = new_monthly_subscriptionnot = 2966
לא חבר לשכה = customer = 2968
לא בתוקף = expired_membership = 3185
*/


include( 'core/bootstrap.php' );
include('checkout_custom_field.php');


function bootstrap_resources() {
    wp_enqueue_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css','');
    wp_enqueue_script( 'bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), '3.3.4', true );
}
// add_action('wp_enqueue_scripts', 'bootstrap_resources');

function st_ajaxurl(){ 
    ?>
 
    <script>
     
    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
     
    <?php 

        $nonce = wp_create_nonce("my_user_vote_nonce");
        $link = admin_url('admin-ajax.php?action=my_user_vote&post_id='.$post->ID.'&nonce='.$nonce);
        echo "var ajaxlink = '".$link."'";
    ?>
    

    </script>
<?php }
add_action('wp_head','st_ajaxurl');

/*****************************************************
  Ajax is member in the low office 
*****************************************************/
function isMember($memberID){

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://data.gov.il/api/action/datastore_search?resource_id=a0f56034-88db-4132-8803-854bcdb01ca1&limit=40000",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "Accept: */*",
        "Accept-Encoding: gzip, deflate",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Host: data.gov.il",
        "Postman-Token: 01cfdb1a-ed9c-473c-ae14-e48ba06335ed,bf2ae4ba-fcd6-40f7-9b86-5cc66d902107",
        "User-Agent: PostmanRuntime/7.15.2",
        "cache-control: no-cache"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
        $result = json_decode($response);
        // var_dump($result->result->records);
        foreach($result->result->records as $menber){
            //Kint::dump($menber);
            $arr = array();
            foreach($menber as $a){

                $arr[]=$a;
                if($a == $memberID){
                    $inArr =  true;
                }
            }
            if($inArr == true){
                return $arr;
                //break;
            }
        
            

        }
        return false;
    }
}
// isMember
function st_handle_isMember(){
    if( $_POST['action'] == 'isMember_action' ) {
    
        $error = '';
        
         $licenseNumber = sanitize_text_field( $_POST['licenseNumber'] );
         $fname = sanitize_text_field( $_POST['firname'] );
         $lname = sanitize_text_field( $_POST['lasname'] );
        
    
        if( empty( $_POST['firname'] ) )
         $error .= '<p class="error">Enter First Name</p>';
        //  elseif( !preg_match("/^[a-zA-Z'-]+$/",$fname) )
        //  $error .= '<p class="error">Enter Valid First Name</p>';
        
        if( empty( $_POST['lasname'] ) )
         $error .= '<p class="error">Enter Last Name</p>';
        //  elseif( !preg_match("/^[a-zA-Z'-]+$/",$lname) )
        //  $error .= '<p class="error">Enter Valid Last Name</p>';
        $member = isMember($licenseNumber);
        //var_dump($member);

        if($member[1] != $licenseNumber ){
            echo "false" ;
            wp_die();
        }elseif (strpos($member[2], $fname) === false) {
            echo 'false';
        }elseif (strpos($member[2], $lname) === false) {
            echo 'false';
        }else{
            echo $respun = '{"valid":"true","validID":"@qweFF4535"}';
            wp_die();
        }        



        // echo $licenseNumber."-".$fname."-".$lname; 
        

         die(1);
    }    

}
add_action( 'wp_ajax_isMember_action', 'st_handle_isMember' );
add_action( 'wp_ajax_nopriv_isMember_action', 'st_handle_isMember' );
    

/*****************************************************
  Ajax registration - not activ!!!
*****************************************************/
function st_handle_registration(){
    if( $_POST['action'] == 'register_action' ) {
    
        if($_POST['validID'] != '@qweFF4535'){
            wp_die();   
        }

        // addUserBamby();
        // exit;
        $error = '';
        // $uname = sanitize_text_field( $_POST['username'] );
        $email = sanitize_text_field( $_POST['mail_id'] );
        $fname = sanitize_text_field( $_POST['firname'] );
        $lname = sanitize_text_field( $_POST['lasname'] );
        $pswrd = wp_generate_password( $length=12, $include_standard_special_chars=true );


        // if( empty( $_POST['mail_id'] ) )
        // $error .= '<p class="error">Enter Email Id</p>';
        // elseif( !filter_var($email, FILTER_VALIDATE_EMAIL) )
        // $error .= '<p class="error">Enter Valid Email</p>';
        
        // if( empty( $_POST['firname'] ) )
        // $error .= '<p class="error">Enter First Name</p>';
        // elseif( !preg_match("/^[a-zA-Z'-]+$/",$fname) )
        // $error .= '<p class="error">Enter Valid First Name</p>';
        
        // if( empty( $_POST['lasname'] ) )
        // $error .= '<p class="error">Enter Last Name</p>';
        // elseif( !preg_match("/^[a-zA-Z'-]+$/",$lname) )
        // $error .= '<p class="error">Enter Valid Last Name</p>';
        


        $userdata = array(
            'user_login' => esc_attr($email),
            'user_email' => esc_attr($email),
            'user_pass' => esc_attr($pswrd),
            'first_name' => esc_attr($fname),
            'last_name' => esc_attr($lname),
            'display_name' => esc_attr($fname.' '.$lname),
        );
        $register_user = wp_insert_user($userdata);
        //var_dump($register_user);
        if (!is_wp_error($register_user)) {

            user_metadata($register_user);
            addUserBamby();

            $info = array();
            $info['user_login'] = $email;
            $info['user_password'] = $pswrd;
            $info['remember'] = true;

            $user_signon = wp_signon( $info, false);
            //var_dump($user_signon);
            wp_set_current_user( $register_user, $email );
            wp_set_auth_cookie( $register_user );
            do_action( 'wp_login', $email ,get_user_by('email',$email) );
            echo '{"user_registered":"true"}';
        } else{
             //echo $register_user->get_error_message();
             $msg = '';
             foreach( $register_user->errors as $key=>$val ){
                 foreach( $val as $k=>$v ){
                     $msg = '<p class="error">'.$v.'</p>';
                 }
             }
             // var_dump($msg);
             // $msg='ddddd';
             echo '{"user_registered":"false","error":"'.htmlentities($v).'"}';
        }


        // if( empty( $error ) ){
        //     $fullName = sanitize_text_field($_POST['firname']).' '.sanitize_text_field($_POST['lasname']);     
        //     $status = wp_create_user( $email, $pswrd ,$email );
        //     // $register_user = wp_insert_user($userdata);
        //     wp_update_user(array('ID' => $status, 'display_name' => $fullName ));
        //     if( is_wp_error($status) ){
        //         $msg = '';
        //         foreach( $status->errors as $key=>$val ){
        //             foreach( $val as $k=>$v ){
        //                 $msg = '<p class="error">'.$v.'</p>';
        //             }
        //         }
        //         // var_dump($msg);
        //         // $msg='ddddd';
        //         echo '{"user_registered":"false","error":"'.htmlentities($v).'"}';

        //     }else{
        //         user_metadata($status);
        //         addUserBamby();
        //         wp_set_current_user( $status, $email );
        //         wp_set_auth_cookie( $status );
        //         do_action( 'wp_login', $email );
        //         echo '{"user_registered":"true"}';
        //         // var_dump($status);
        //         // $msg = '<p class="success">Registration Successful</p>';
        //         // echo $msg;
        //     }
        // }
     die(1);
    }
}

add_action( 'wp_ajax_register_action', 'st_handle_registration' );
add_action( 'wp_ajax_nopriv_register_action', 'st_handle_registration' );

/*****************************************************
  Ajax registration user meta update
*****************************************************/    
function user_metadata( $user_id ){

    if( !empty( $_POST['firname'] ) && !empty( $_POST['lasname'] ) ){
    
        update_user_meta( $user_id, 'role', 'customer' );

        update_user_meta( $user_id, 'first_name', sanitize_text_field($_POST['firname']) );
        update_user_meta( $user_id, 'billing_first_name', sanitize_text_field($_POST['firname']) );
        
        update_user_meta( $user_id, 'last_name', sanitize_text_field($_POST['lasname']) );
        update_user_meta( $user_id, 'billing_last_name', sanitize_text_field($_POST['lasname']) );

        update_user_meta( $user_id, 'license_number', sanitize_text_field($_POST['licenseNumber']) );

        update_user_meta( $user_id, 'phone', sanitize_text_field($_POST['phone']) );
        update_user_meta( $user_id, 'phone', billing_phone($_POST['phone']) );

        update_user_meta( $user_id, 'office_name', sanitize_text_field($_POST['office_name']) );

        update_user_meta( $user_id, 'district', sanitize_text_field($_POST['district']) );

        update_user_meta( $user_id, 'expertise', sanitize_text_field($_POST['expertise']) );

        update_user_meta( $user_id, 'show_admin_bar_front', false );
        
    }
    

}
add_action( 'user_register', 'user_metadata' );
// add_action( 'profile_update', 'user_metadata' );
        
/*****************************************************
  Add acf_get_field_key for development
*****************************************************/
// $r=acf_get_field_key('status',3677);
// var_dump($r);
// exit;
function acf_get_field_key( $field_name, $post_id ) {
	global $wpdb;
	$acf_fields = $wpdb->get_results( $wpdb->prepare( "SELECT ID,post_parent,post_name FROM $wpdb->posts WHERE post_excerpt=%s AND post_type=%s" , $field_name , 'acf-field' ) );
	// get all fields with that name.
	switch ( count( $acf_fields ) ) {
		case 0: // no such field
			return false;
		case 1: // just one result. 
			return $acf_fields[0]->post_name;
	}
	// result is ambiguous
	// get IDs of all field groups for this post
	$field_groups_ids = array();
	$field_groups = acf_get_field_groups( array(
		'post_id' => $post_id,
	) );
	foreach ( $field_groups as $field_group )
		$field_groups_ids[] = $field_group['ID'];
	
	// Check if field is part of one of the field groups
	// Return the first one.
	foreach ( $acf_fields as $acf_field ) {
		if ( in_array($acf_field->post_parent,$field_groups_ids) )
			return $acf_field->post_name;
	}
	return false;
}

/*****************************************************
  Chainge user role in wp after user buy member ticket 
*****************************************************/ 

include('bmby.php');

/***************************** 
 Email html header chainge
*****************************/ 
function wpse27856_set_content_type(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

/***************************** 
 users_status_cronjob
*****************************/ 
//add_action( 'users_status_cronjob', 'users_status_cronjob_function' );
function users_status_cronjob_function() {

    global $wpdb;

    //$query="SELECT user_id FROM {$wpdb->prefix}usermeta WHERE `meta_key` = 'status' AND meta_value ='חבר לשכה'";
    
    $query = "SELECT u.ID, m2.meta_value as member_purchase_date, m1.meta_value as capabilities
    FROM wp_users u
    INNER JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'wp_capabilities'
    INNER JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'member_purchase_date'
    AND m2.meta_value != ''";
    
    
    $results = $wpdb->get_results( $query, OBJECT );
    // Kint::dump($results);
    $today=date('Y-m-d');
    $datetime2 = new DateTime($today);
    foreach($results as $t){
        if(user_can( $t->ID, 'manage_options' )){
            continue;
        }
        $datetime1 = new DateTime($t->member_purchase_date);
        $interval = $datetime1->diff($datetime2);
        // var_dump($interval->days);

        if($interval->days <= 1){
            echo $t->ID."user: ";
            echo "1 days";
            echo "<BR>";
            sendEmail($t->ID,$interval->days);
        }elseif($interval->days <= 14){
            echo $t->ID."user: ";
            echo "14 days";
            echo "<BR>";
            sendEmail($t->ID,$interval->days);
        }elseif($interval->days <= 30){
            echo $t->ID."user: ";
            echo "30 days";
            echo "<BR>";
            sendEmail($t->ID,$interval->days);
        }elseif($interval->days >= 360){
            echo $t->ID."user: ";
            echo "360 days";
            echo "<BR>";
            //update_field( 'field_5d7a0d56f000e', 'מסרב', 'user_'.$t->ID );
            $user_id = wp_update_user(array("ID"=>$t->ID,"role"=>"expired_membership"));
        }else{
            echo "active member<BR>";
            //update_field( 'field_5d7a0d56f000e', 'חבר לשכה', 'user_'.$t->ID );
            $user_id = wp_update_user(array("ID"=>$t->ID,"role"=>"author"));
        }
    }
    exit;
}

function sendEmail($user_id,$days){
    $user = get_user_by('ID',$user_id);
    echo $email_body = '
    
        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
        <html lang="en">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>לשכת מתווכי הנדל״ן</title>

        <style type="text/css">
        

            /* Outlines the grids, remove when sending */
            /* table td { border: 1px solid cyan; } */
            /* CLIENT-SPECIFIC STYLES */
            body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
            table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
            img { -ms-interpolation-mode: bicubic; }
            /* RESET STYLES */
            img { border: 0; outline: none; text-decoration: none; }
            table { border-collapse: collapse !important; }
            body { margin: 0 !important; padding: 0 !important; width: 100% !important; }
            /* iOS BLUE LINKS */
            a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
            }
            /* ANDROID CENTER FIX */
            div[style*="margin: 16px 0;"] { margin: 0 !important; }
            /* MEDIA QUERIES */
            @media all and (max-width:639px){ 
            .wrapper{ width:320px!important; padding: 0 !important; }
            .container{ width:300px!important;  padding: 0 !important; }
            .mobile{ width:300px!important; display:block!important; padding: 0 !important; }
            .img{ width:100% !important; height:auto !important; }
            *[class="mobileOff"] { width: 0px !important; display: none !important; }
            *[class*="mobileOn"] { display: block !important; max-height:none !important; }
            }
        </style>    
        </head>
        <body style="margin:0; padding:0; background-color:#F2F2F2;">
        
        <span style="display: block; width: 640px !important; max-width: 640px; height: 1px" class="mobileOff"></span>
        
        <center>
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#F2F2F2">
            <tr>
                <td align="center" valign="top">
                    
                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                    <td align="center" valign="top">

                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="container">
                        <tr>
                            <td align="center" valign="top">
                            <img src="http://realtors.link-in.co.il/wp-content/uploads/2018/03/%D7%9C%D7%A9%D7%9B%D7%AA-%D7%9E%D7%AA%D7%95%D7%95%D7%9B%D7%99-%D7%94%D7%A0%D7%93%D7%9C%D7%9F-%D7%94%D7%90%D7%A8%D7%A6%D7%99%D7%AA-1024x462-300x135.png" width="180" height="" style="margin:0; padding:0; border:none; display:block;" border="0" alt="" /> 
                            </td>
                        </tr>
                        </table>

                    </td>
                    </tr>
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                </table>

                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                    <td align="center" valign="top">

                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="container" dir="rtl">
                        <tr>
                            <td width="300" class="mobile" align="right" valign="top" >
                            <h2 style="margin:0" align="right">
                            שלום : 
                            '.$user->display_name.'
                            </h2>
                            </td>
                            <td width="300" class="mobile" align="center" valign="top">
                            </td>
                        </tr>
                        </table>

                    </td>
                    </tr>
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                </table>


                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                    <td align="center" valign="top">

                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="container" dir="rtl">
                        <tr>
                            <td width="300" class="mobile" align="right" valign="top" dir="rtl" style=" direction: rtl; line-height: 30px;">
                    רצינו לעדכן כי המנוי שלך ללשכת המתווכים נגמר בעוד 
                    '.$days.'
                    ימים 
                    <br>
                    :ניתן להיכנס לקישור זה 
                    <a href="#">לחידוש מנוי</a>
                    
                            </td>
                            <td width="300" class="mobile" align="center" valign="top">
                            </td>
                        </tr>
                        </table>

                    </td>
                    </tr>
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                </table>


                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF" style="height: 100px;">
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                    <td align="center" valign="bottom">

                        <table width="600" cellpadding="0" cellspacing="0" border="0" class="container" dir="rtl">
                        <tr>
                            <td width="200" class="mobile" align="center" valign="top">
                                לשכת מתווכי הנדל״ן
                            </td>
                            <td width="200" class="mobile" align="center" valign="top">
                            072-3957515
                            </td>
                            <td width="200" class="mobile" align="center" valign="top">
                            office@realtors.org.il
                            </td>
                        </tr>
                        </table>

                    </td>
                    </tr>
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                </table>

                <table width="640" cellpadding="0" cellspacing="0" border="0" class="wrapper" bgcolor="#FFFFFF">
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                    <tr>
                    <td align="center" valign="top">

                    </td>
                    </tr>
                    <tr>
                    <td height="10" style="font-size:10px; line-height:10px;">&nbsp;</td>
                    </tr>
                </table>
                    
                </td>
            </tr>
            </table>
        </center>
        </body>
        </html>
    ';
    // $r=wp_mail("zurbracha@gmail.com", "חידוש מנוי - לשכת מתווכי הנדלן", $email_body);
    // $r=wp_mail($user->user_email, "חידוש מנוי - לשכת מתווכי הנדלן", $email_body);
    // var_dump($r);
    // exit;
    
}

// users_status_cronjob_function();
// exit();
// End users_status_cronjob

add_filter("retrieve_password_message", "mapp_custom_password_reset", 99, 4);

function mapp_custom_password_reset($message, $key, $user_login, $user_data )    {

    $message = "שלום רב , וברוך הבא לאתר הלשכה
    נשלחה בקשה לאיפוס סיסמה באתר לחשבון :

" . sprintf(__('%s'), $user_data->user_email) . "

ניתן לבצע זאת מקישור זה :

" . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . "\r\n";


    return $message;

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

/*************************************************************** 
Blocking add product  to cart if there is in cart member ticket 
****************************************************************/ 

function aelia_get_cart_contents() {

    $cart_contents = array();
    /**
     * Load the cart object. This defaults to the persistant cart if null.
     */
    $cart = WC()->session->get( 'cart', null );
   
    if ( is_null( $cart ) && ( $saved_cart = get_user_meta( get_current_user_id(), '_woocommerce_persistent_cart', true ) ) ) {
      $cart = $saved_cart['cart'];
    } elseif ( is_null( $cart ) ) {
      $cart = array();
    }
   
    if ( is_array( $cart ) ) {
      foreach ( $cart as $key => $values ) {
        $_product = wc_get_product( $values['variation_id'] ? $values['variation_id'] : $values['product_id'] );
   
        if ( ! empty( $_product ) && $_product->exists() && $values['quantity'] > 0 ) {
          if ( $_product->is_purchasable() ) {
            // Put session data into array. Run through filter so other plugins can load their own session data
            $session_data = array_merge( $values, array( 'data' => $_product ) );
            $cart_contents[ $key ] = apply_filters( 'woocommerce_get_cart_item_from_session', $session_data, $values, $key );
          }
        }
      }
    }
    return $cart_contents;
  }
   
  // Step 1 - Keep track of cart contents
  add_action('wp_loaded', function() {
    // If there is no session, then we don't have a cart and we should not take
    // any action
    if(!is_object(WC()->session)) {
      return;
    }
   
    // This variable must be global, we will need it later. If this code were
    // packaged as a plugin, a property could be used instead
    global $allowed_cart_items;
    // We decided that products with ID 737 and 832 can go together. If any of them
    // is in the cart, all other products cannot be added to it
    global $restricted_cart_items;
    $restricted_cart_items = array(
      3930
    );
   
    // "Snoop" into the cart contents, without actually loading the whole cart
    foreach(aelia_get_cart_contents() as $item) {
      if(in_array($item['data']->id, $restricted_cart_items)) {
        $allowed_cart_items[] = $item['data']->id;
   
        // If you need to allow MULTIPLE restricted items in the cart, comment
        // the line below
        break;
      }
    }
   
    // Step 2 - Make disallowed products "not purchasable"
    add_filter('woocommerce_is_purchasable', function($is_purchasable, $product) {
      global $restricted_cart_items;
      global $allowed_cart_items;
   
      // If any of the restricted products is in the cart, any other must be made
      // "not purchasable"
      if(!empty($allowed_cart_items)) {
        // To allow MULTIPLE products from the restricted ones, use the line below
        //$is_purchasable = in_array($product->id, $allowed_cart_items) || in_array($product->id, $restricted_cart_items);
   
        // To allow a SINGLE  products from the restricted ones, use the line below
        $is_purchasable = in_array($product->id, $allowed_cart_items);
      }
      return $is_purchasable;
    }, 10, 2);
  }, 10);
   
  // Step 3 - Explain customers why they can't add some products to the cart
  add_filter('woocommerce_get_price_html', function($price_html, $product) {
    if(!$product->is_purchasable() && is_product()) {
        $price_html .= '<ul class="woocommerce-error" role="alert"><li>לא ניתן לרכוש מינוי שנתי עם מוצר נוסף, ראשית יש לרכוש מינוי שנתי
        או לנקות את עגלת הקניות
        <a href="?add-to-cart" style="text-decoration: underline; ">ניקוי עגלה</a>
        </li></ul>';
    //   $price_html .= '<p>' . __('יש לבצע ראשית רכישה למינוי שנתי ללשכה ולאחר מכן לרכוש מוצר נוסף') . '</p>';
    }
    return $price_html;
    }, 10, 2);

add_action( 'init', 'woocommerce_clear_cart_url' );
function woocommerce_clear_cart_url() {
    if ( isset( $_GET['add-to-cart'] ) ) {
        WC()->cart->empty_cart();
    }
}

function filter_user_contact_methods( $methods ) {
    // To remove a method
    // unset( $methods['aim'] );

    // To add a method
    // $methods['twitter'] = 'Twitter';

    // To remove them all
    $methods = array();

    return $methods;
}
add_filter( 'user_contactmethods', 'filter_user_contact_methods' );

// $user = get_user_by('ID',5);
// $user->set_role( 'administrator' );
// var_dump($user);
// exit;
add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
  echo '<style>
    tr.user-rich-editing-wrap,.user-admin-color-wrap,.user-comment-shortcuts-wrap,.show-admin-bar user-admin-bar-front-wrap
    ,.user-language-wrap,.yoast.yoast-settings,tr.show-admin-bar.user-admin-bar-front-wrap,.user-display-name-wrap,table#fieldset-shipping {
        display: none;
    }

  </style>';
}




function wpb_welcome_shortcode() { 
 
    if ( is_user_logged_in() ) {
        $current_user = wp_get_current_user();
        if ( ($current_user instanceof WP_User) ) 
         {
            echo "<p style='color: #fff; margin: 0; border-bottom: 1px solid #fff; text-align: center;'>"; 
            echo 'ברוך הבא : ' . esc_html( $current_user->display_name );
            // echo get_avatar( $current_user->ID, 32 );
            echo "</p>"; 
        }
    }
} 
    // register shortcode
add_shortcode('welcome_shortcode', 'wpb_welcome_shortcode'); 

remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 ); 


add_action( 'wp_ajax_nopriv_react_check_if_logged', 'react_check_if_logged' );
add_action( 'wp_ajax_react_check_if_logged', 'react_check_if_logged' );
function react_check_if_logged(){
	$id = get_current_user_id();
	if( $id > 0 ){
		echo  json_encode(
			array(
				'success' => 1,
				'user' => new WP_User($id)
			));
	} else {
		echo  json_encode(
			array(
				'success' => 0
			));
	}

	wp_die();
}

add_action( 'wp_ajax_nopriv_react_login_user', 'react_login_user' );
add_action( 'wp_ajax_react_login_user', 'react_login_user' );
function react_login_user() {
	global $wpdb;
	check_ajax_referer( 'wp_react_login', '_wpnonce' );

	$username = $_POST['username'];
	$password = $_POST['password'];

	$auth = wp_authenticate( $username, $password );
	if( is_wp_error( $auth )) {
		echo  json_encode(
			array(
				'success' => 0,
				'message' => $auth->get_error_message()
			));
	} else {
		wp_set_auth_cookie( $auth->ID );
		echo  json_encode(
			array(
				'success' => 1,
				'user' => $auth
			));
	}
	

	wp_die();
}

/** Users_by_district **/
// add_action( 'wp_ajax_nopriv_users_by_district', 'users_by_district' );
// add_action( 'wp_ajax_users_by_district', 'users_by_district' );

// function users_by_district() {
//     global $wpdb;
// 	check_ajax_referer( 'wp_react_login', '_wpnonce' );
//     $users = get_users( array( 'fields' => array( 'ID' ) ) );
//     foreach($users as $user_id){
//         var_dump(get_user_meta ( $user_id->ID));
//     }

// 	wp_die();
// }


/** Users_by_district **/
register_rest_route(
	'captaincore/v1', '/customers/', array(
		'methods'       => 'GET',
		'callback'      => 'district_users_func',
		'show_in_index' => false
	)
);

function district_users_func( $request ) {
    
    $district = $request->get_param('district');
    global $wpdb;
    $q="SELECT user_id FROM `wp_usermeta` WHERE meta_key='district' AND meta_value='{$district}'";
    $result = $wpdb->get_results($q);
    $allUsers = array();
    $counter = 0;
    $rowNumber=1;
    foreach($result as $user_id){
        $userMeta = get_user_meta ( $user_id->user_id);
        // Kint::dump($userMeta);
        $allUsers[$counter]['rowNumber'] = $rowNumber; 
        $allUsers[$counter]['first_name'] = $userMeta['first_name'][0]; 
        $allUsers[$counter]['last_name'] = $userMeta['last_name'][0]; 
        $allUsers[$counter]['phone'] = $userMeta['phone'][0]; 
        $allUsers[$counter]['district'] = $userMeta['district'][0]; 
        $allUsers[$counter]['member_purchase_date'] = $userMeta['member_purchase_date'][0]; 
        $allUsers[$counter]['member_expiry_date'] = $userMeta['member_expiry_date'][0]; 
        $allUsers[$counter]['district'] = $userMeta['district'][0]; 
        $user = get_user_by ( 'ID',$user_id->user_id);
        $allUsers[$counter]['user_email'] = $user->data->user_email; 
        $allUsers[$counter]['ID'] = $user_id->user_id; 
        if($user->roles[0] == 'author'){
            $allUsers[$counter]['roles'] = 'חבר לשכה שנתי'; 
        }elseif( $user->roles[0] == 'customer'){
            $allUsers[$counter]['roles'] = 'רשום באתר -לא חבר'; 
        }elseif( $user->roles[0] == 'monthly_subscriptionnot_approve'){
            $allUsers[$counter]['roles'] = 'חבר לשכה חדש - לא מאושר'; 
        }elseif( $user->roles[0] == 'new_monthly_subscriptionnot'){
            $allUsers[$counter]['roles'] = 'חבר לשכה חתום חודשי'; 
        }

        $counter++;
        $rowNumber++;
    }
    header('Content-type: application/json');
    echo json_encode($allUsers);
    // Kint::dump($allUsers);
    exit;

}

register_rest_route(
	'captaincore/v1', '/user_order/', array(
		'methods'       => 'GET',
		'callback'      => 'get_orders_by_user_func',
		'show_in_index' => false
	)
);

function get_orders_by_user_func( $request ) {
    
    $userID = $request->get_param('userID');
    global $wpdb;
    $q="SELECT post_id FROM `wp_postmeta` WHERE `meta_key` = '_customer_user' AND `meta_value` = '{$userID}'";
    $result = $wpdb->get_results($q);
    $allUsers = array();
    $counter = 0;
    $rowNumber=1;
    $orders_arr = array();
    foreach($result as $item){
        $order = wc_get_order( $item->post_id );

        // $order_data = $order->get_data();
        $items = $order->get_items();

        foreach ( $items as $item ) {
            $orders_arr[$counter]['product_name'] = $item->get_name();
            $orders_arr[$counter]['product_id'] = $item->get_product_id();
        }
        // var_dump($order_items);
        $counter++;
        $rowNumber++;
    }
    header('Content-type: application/json');
    echo json_encode($orders_arr);

    exit;

}
/** END Users_by_district **/

/** get_purchased_users_by_product **/
register_rest_route(
	'captaincore/v1', '/purchased_users/', array(
		'methods'       => 'GET',
		'callback'      => 'get_purchased_users_func',
		'show_in_index' => false
	)
);

function get_purchased_users_func( $request ) {
    global $wpdb;
    $product_id = $request->get_param('prodcatid');
    $district = $request->get_param('district');
    $statuses = array_map( 'esc_sql', wc_get_is_paid_statuses() );
    $customer = $wpdb->get_col("
       SELECT DISTINCT pm.meta_value FROM {$wpdb->posts} AS p
       INNER JOIN {$wpdb->postmeta} AS pm ON p.ID = pm.post_id
       INNER JOIN {$wpdb->prefix}woocommerce_order_items AS i ON p.ID = i.order_id
       INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta AS im ON i.order_item_id = im.order_item_id
       WHERE p.post_status IN ( 'wc-" . implode( "','wc-", $statuses ) . "' )
       AND pm.meta_key IN ( '_customer_user' )
       AND im.meta_key IN ( '_product_id', '_variation_id' )
       AND im.meta_value = $product_id
    ");

    $allUsers = array();
    $counter = 0;
    $rowNumber=1;
    foreach($customer as $user_id){
        $userMeta = get_user_meta ( $user_id);
        if($userMeta['district'][0] == $district){
            // Kint::dump($userMeta);
            $allUsers[$counter]['rowNumber'] = $rowNumber; 
            $allUsers[$counter]['first_name'] = $userMeta['first_name'][0]; 
            $allUsers[$counter]['last_name'] = $userMeta['last_name'][0]; 
            $allUsers[$counter]['phone'] = $userMeta['phone'][0]; 
            $allUsers[$counter]['district'] = $userMeta['district'][0]; 
            $allUsers[$counter]['member_purchase_date'] = $userMeta['member_purchase_date'][0]; 
            $allUsers[$counter]['member_expiry_date'] = $userMeta['member_expiry_date'][0]; 
            $allUsers[$counter]['district'] = $userMeta['district'][0]; 
            $user = get_user_by ( 'ID',$user_id);
            $allUsers[$counter]['user_email'] = $user->data->user_email; 
            $allUsers[$counter]['ID'] = $user_id; 
            if($user->roles[0] == 'author'){
                $allUsers[$counter]['roles'] = 'חבר לשכה שנתי'; 
            }elseif( $user->roles[0] == 'customer'){
                $allUsers[$counter]['roles'] = 'רשום באתר -לא חבר'; 
            }elseif( $user->roles[0] == 'monthly_subscriptionnot_approve'){
                $allUsers[$counter]['roles'] = 'חבר לשכה חדש - לא מאושר'; 
            }elseif( $user->roles[0] == 'new_monthly_subscriptionnot'){
                $allUsers[$counter]['roles'] = 'חבר לשכה חתום חודשי'; 
            }

            $counter++;
            $rowNumber++;
        }
    }
    header('Content-type: application/json');
    echo json_encode($allUsers);
    exit;

}
/** END get_purchased_users_by_product **/




// global $wpdb;
// $q = "SELECT user_id FROM `wp_usermeta` WHERE `meta_value` LIKE 'a:1:{s:6:\"author\";b:1;}'";
// $r= $wpdb->get_results($q);
// // var_dump($r);
// foreach ($r as $key => $value) {
//     $q= "SELECT meta_value as date FROM `wp_usermeta` WHERE `meta_key` LIKE 'member_purchase_date' AND user_id = {$value->user_id}";
//     $r= $wpdb->get_results($q);
//     $newDate = date($r[0]->date);
//     // echo $newDate;
//     $futureDate=date('Y-m-d', strtotime('360 days', strtotime($newDate)) );
//         if(!empty($futureDate)){
//             echo $q = "UPDATE `wp_usermeta` SET `meta_value`= '$futureDate 00:00:00' WHERE (`user_id` = {$value->user_id} AND meta_key='member_expiry_date')";
//             echo "<br>";
//             $r = $wpdb->get_results($q);
//             echo $value->user_id."= ".$futureDate."<br>";
//         }
// }

// echo "END";
// exit;

