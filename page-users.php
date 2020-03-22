<?php 
/* Template Name: users_page */ 
get_header();
global $wpdb;

// if(!empty($_POST)){
//     var_dump($_POST);
// }
$to_search='';
$no_results = false;
$_name = sanitize_text_field($_POST['name_']);
if (!empty($_name)) {
    $full_name = explode(" ",$_name);
    // exit;
    $to_search.=$_name;
    if(count($full_name) > 1){
        $query = "SELECT DISTINCT u.ID  as user_id
        FROM wp_users u
        INNER JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'first_name' AND m1.meta_value LIKE'%".$full_name[0]."%'
        INNER JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name' AND m2.meta_value LIKE '%".$full_name[1]."%'";
        $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
        if(empty($users_ids)){
            $query = "SELECT DISTINCT u.ID  as user_id
            FROM wp_users u
            INNER JOIN wp_usermeta m1 ON u.ID = m1.user_id AND m1.meta_key = 'first_name' AND m1.meta_value LIKE '%".$full_name[1]."%'
            INNER JOIN wp_usermeta m2 ON u.ID = m2.user_id AND m2.meta_key = 'last_name' AND m2.meta_value LIKE'%".$full_name[0]."%'";
            $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));      
        }
    }else{
        $query = "SELECT DISTINCT $wpdb->usermeta.user_id FROM `$wpdb->usermeta` 
                WHERE $wpdb->usermeta.meta_value LIKE '%".$_name."%' 
                AND($wpdb->usermeta.meta_key = 'first_name'
                    OR $wpdb->usermeta.meta_key = 'last_name'
                    OR $wpdb->usermeta.meta_key = 'full_name')  
                    ORDER BY
                    CASE
                        WHEN wp_usermeta.meta_value LIKE '".$_name."' THEN 1
                        WHEN wp_usermeta.meta_value LIKE '".$_name."' THEN 3
                        ELSE 2
                    END, wp_usermeta.meta_value ASC
                ";
                // exit;
        $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
    }
    
    // var_dump($users_ids);
    // exit;
    if(empty($users_ids)){
        $no_results = true;
    }

}

$license_number_ = sanitize_text_field($_POST['license_number_']);
if (!empty($license_number_)) {
    if(!empty($to_search)){$to_search.=" / ";}
    $to_search.=$license_number_;
    $ids=array();
     $query = "SELECT DISTINCT $wpdb->usermeta.user_id FROM `$wpdb->usermeta` 
    WHERE $wpdb->usermeta.meta_value LIKE '%".$license_number_."%' 
    AND (wp_usermeta.meta_key = 'license_number' OR wp_usermeta.meta_key = 'phone' OR wp_usermeta.meta_key = 'office_name')
    ";
    // exit;
    $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
    if(empty($users_ids)){
        $no_results = true;
    }
} 

$district_ = sanitize_text_field($_POST['district_']);
if(!empty($district_)){
    $dist=get_field_object('district',"user_5");
    $district= $dist["choices"][$district_];
    if(!empty($to_search)){$to_search.=" / ";}
    $to_search.=$district; 
}
if (!empty($district_) && empty($users_ids) && $no_results == false) {
    $ids=array();
    $query = "SELECT DISTINCT $wpdb->usermeta.user_id FROM `$wpdb->usermeta` 
    WHERE $wpdb->usermeta.meta_value LIKE '%".$district_."%' 
    AND $wpdb->usermeta.meta_key = 'district' 
    ";
    $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
    if(empty($users_ids)){
        $no_results = true;
    }
} 

$resat_ = sanitize_text_field($_POST['resat_']);
if((empty($users_ids) || $resat_ == 'on') && $no_results == false){
    $to_search='';
    $_name='';
    $license_number_='';
    $district_='';

    $users = get_users( [ 'role__in' => [ 'new_monthly_subscriptionnot','monthly_subscriptionnot_approve','author' ] ] );
    //$users = get_users( 'role=new_monthly_subscriptionnot' );
    // monthly_subscriptionnot_approve
    // var_dump($users);

    $ids=array();
    foreach($users as $user){
        $ids[] = $user->data->ID;
        // array_push($ids,$user->data->ID);
        // var_dump($user->data->ID);
        // exit;
    }

    // Kint::dump($ids);
    
} 
// $expertise_ = sanitize_text_field($_POST['expertise_']);
// if (!empty($expertise_)) {
//     $to_search=$expertise_;
//     $ids=array();
//     $query = "SELECT DISTINCT $wpdb->usermeta.user_id FROM `$wpdb->usermeta` 
//     WHERE $wpdb->usermeta.meta_value LIKE '%".$expertise_."%' 
//     AND $wpdb->usermeta.meta_key = 'expertise' 
//     ";
//     $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
// } 

// if (!empty($_POST['telephone_'])) {
//     $query = "SELECT DISTINCT $wpdb->usermeta.user_id FROM `$wpdb->usermeta` 
//     WHERE $wpdb->usermeta.meta_value LIKE '%".$_POST['telephone_']."%' 
//     AND $wpdb->usermeta.meta_key = 'telephone' 
//     ";
//     $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
// } 
// if (!empty($_POST['office_name_'])) {
//     $query = "SELECT DISTINCT $wpdb->usermeta.user_id FROM `$wpdb->usermeta` 
//     WHERE $wpdb->usermeta.meta_value LIKE '%".$_POST['office_name_']."%' 
//     AND $wpdb->usermeta.meta_key = 'office_name' 
//     ";
//     $users_ids = $wpdb->get_results( $wpdb->prepare($query, $level ));
//     // array_push($users_ids,)


// }
// var_dump($users_ids);
if(!empty($users_ids)){
    foreach($users_ids as $id){
        $ids[] = $id->user_id;
    }
}

// Kint::dump($ids);



// echo $search_term = sanitize_text_field( stripslashes( 'test3333' ));



?>
<div id="container">
    <div class="layout-content boxed"><!-- Layout Content -->
        <div id="primary-">
            <div class="container">
                <div id="content" class="row">
                    <section id="main" class="col-sm-12 col-md-12 full-width" role="main">
                        <div class="elementor-row">
                            <div class="elementor-element elementor-column elementor-col-30 elementor-inner-column">
                                <div class="search-users-sidebar">
                                   <h2> חיפוש חברי הלשכה</h2>
                                   <?php include(dirname(__FILE__)."/search_users/search_users_form.php");?>
                                </div>
                            </div>

                            <div class="elementor-element elementor-column elementor-col-70 elementor-inner-column">
                                <div class="search-users-main">
                                    <div id="authorlist">
                                            <?php include(dirname(__FILE__)."/search_users/search_users_results.php");?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>





<style>
#authorlist ul{
list-style: none;
width: 600px;
margin: 0;
padding: 0;
}
#authorlist li {
margin: 0 0 5px 0;
list-style: none;
height: 90px;
padding: 15px 0 15px 0;
border-bottom: 1px solid #ececec;
}
 
#authorlist img.photo {
max-width: 110px;
max-height: 110px;
float: left;
margin: 0 15px 0 0;
padding: 3px;
border: 1px solid #ececec;
}
 
#authorlist div.authname {
margin: 20px 0 0 10px;
}

section#main.row-user {
    border: 1px solid #ddd;
    padding: 20px;
}
div.content- {
    width: 100%;
    display: block;
    float: right;
    margin-bottom: 15px;
}

button#btn-resat {
    float: left;
}
.search-users-main {
    width: 100%;
}

button#btn-search {
    background: #0e486e;
    padding: 5px 114px;
    width: 100%;
}

button#btn-resat {
    background: #b9b6b6;
    padding: 5px 40px;
}
.r-side {
    display: block;
    float: right;
    width: 50%;
}
.l-side {
    display: block;
    float: left;
    width: 50%;
}

.pagination {
    display: inline-block;
  }

  .pagination a {
    color: black;
    float: right;
    padding: 8px 16px;
    text-decoration: none;
  }

  .pagination a.active {
    background-color: #0e486e;
    color: white;
  }

  .pagination a:hover:not(.active) {background-color: #0e486e;}

</style>
<?php if($district_){ ?>
    <script>
    jQuery('.filter-price option[value=<?=$district_?>]').attr('selected','selected');
    </script>
<?php } ?>

<?php
get_footer();