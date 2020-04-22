<?php 
/* Template Name: page_cronjob_users_status */ 
// http://realtors.link-in.co.il/%d7%91%d7%93%d7%99%d7%a7%d7%aa-%d7%9e%d7%a0%d7%95%d7%99/
echo "<h1>page_cronjob_users</h1>";


global $wpdb;

//$query="SELECT user_id FROM {$wpdb->prefix}usermeta WHERE `meta_key` = 'status' AND meta_value ='חבר לשכה'";

$query = "SELECT u.ID, m2.meta_value as member_purchase_date, m1.meta_value as capabilities
FROM wp_users u
INNER JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'wp_capabilities'
INNER JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'member_purchase_date'
AND m2.meta_value != ''";


$results = $wpdb->get_results( $query, OBJECT );
Kint::dump($results);
$today=date('Y-m-d');
$datetime2 = new DateTime($today);


// foreach($results as $t){
    
//     $district=get_field('district','user_'.$t->ID);
//     if($district == 'מחוז ירושלים'){
//         var_dump($t->ID);
//         echo "<hr>";
//         update_field('member_purchase_date','1.12.2020','user_'.$t->ID);
//         update_field('member_expiry_date','31.12.2020','user_'.$t->ID);
//         $user_id = wp_update_user(array("ID"=>$t->ID,"role"=>"author"));
//     }
// //   exit;
// }

// exit;



foreach($results as $t){
    if(user_can( $t->ID, 'manage_options' )){
        continue;
    }
    $datetime1 = new DateTime($t->member_purchase_date);
    $interval = $datetime1->diff($datetime2);
    // var_dump($interval->days);

    if($interval->days <= 1){
        // echo $t->ID."user: ";
        // echo "1 days";
        // echo "<BR>";
        //sendEmail($t->ID,$interval->days);
    }elseif($interval->days <= 14){
        // echo $t->ID."user: ";
        // echo "14 days";
        // echo "<BR>";
        //sendEmail($t->ID,$interval->days);
    }elseif($interval->days <= 30){
        // echo $t->ID."user: ";
        // echo "30 days";
        // echo "<BR>";
        //sendEmail($t->ID,$interval->days);
    }elseif($interval->days >= 360){
        echo $t->ID."user: ";
        echo "360 days";
        
        //update_field( 'field_5d7a0d56f000e', 'מסרב', 'user_'.$t->ID );
        $user_id = wp_update_user(array("ID"=>$t->ID,"role"=>"expired_membership"));
        var_dump($user_id);
        echo "<BR>";
    }else{
        //echo "active member<BR>";
        //update_field( 'field_5d7a0d56f000e', 'חבר לשכה', 'user_'.$t->ID );
        //$user_id = wp_update_user(array("ID"=>$t->ID,"role"=>"author"));
    }
}