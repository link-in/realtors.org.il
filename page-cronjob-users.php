<?php 
/* Template Name: page_cronjob_users */ 
// http://realtors.link-in.co.il/%d7%91%d7%93%d7%99%d7%a7%d7%aa-%d7%9e%d7%a0%d7%95%d7%99/
// echo "<h1>page_cronjob_users</h1>";





global $wpdb;

$query="SELECT user_id FROM {$wpdb->prefix}usermeta WHERE `meta_key` = 'status' AND meta_value ='חבר לשכה'";

$query = "SELECT u.ID, m2.meta_value as member_purchase_date
FROM wp_users u
INNER JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'status'
INNER JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'member_purchase_date'
AND m2.meta_value != ''";


$results = $wpdb->get_results( $query, OBJECT );
Kint::dump($results);
exit;

