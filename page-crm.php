<?php 
if (!session_id()) {
  session_start();
  if(isset($_GET['district'])){
    $_SESSION['district'] = $_GET['district'];
  }

  if(isset($_GET['view'])){  
    $_SESSION['view'] = $_GET['view'];
  }

  // echo "district :". $_SESSION['district']."<BR>";
  // echo "view :". $_SESSION['view']."<BR>";

}

/* Template Name: page crm */ 
get_header();

wp_enqueue_script( 'react-js', get_stylesheet_directory_uri().'/reactFiles/react.min.js', array(), false, true );
wp_enqueue_script( 'reactdom-js', get_stylesheet_directory_uri().'/reactFiles/react-dom.min.js' , array(), false, true );

wp_enqueue_script( 'axios-js', 'https://unpkg.com/axios/dist/axios.min.js' , array(), false, true );

// wp_enqueue_script( 'react-bootstrap-table-js', 'https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js' , array(), false, true );
// wp_enqueue_style('react-bootstrap-table-css', 'https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css', array(), false, true );

wp_register_script( 'babel-js', 'https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.24/browser.min.js', array(), false, true );
wp_localize_script( 'babel-js', 'wpReactLogin', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'nonce' => wp_create_nonce( 'wp_react_login' ) , 'nonceApi' => wp_create_nonce( 'wp_rest' )) );
wp_enqueue_script( 'babel-js' );

?>
<link href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>

<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/export/bootstrap-table-export.min.js"></script>

<h1>מערכת ניהול מתווכים</h1>
<div class="form-wrapper" style="position: relative;">
    <?php if(!is_user_logged_in()){ ?>
      <div class="react_login"></div>
      <script src="<?=get_stylesheet_directory_uri()?>/reactFiles/ReactLoginForm.js" type="text/babel"></script>
    <?php }else{ 
      
      //במידה והמשתמש מנהל אז מאפשר לו גישה לכל המחוזות
      if(get_field('crm', 'user_'.get_current_user_id())){
        ?>
        <div class="row">
          <div class="col-md-12">
            <?php
              $user_meta=get_userdata(get_current_user_id());
              $user_roles=$user_meta->roles;
              if($user_roles[1] == 'administrator'){
                //עמוד ניהול לאדמיניסטרטור
                include('reactFiles/admin_dashboard.php');
              }
              if(isset($_SESSION['view'])){
                if($_SESSION['view'] == '1'){
                  //הצגת המתווכים של המחוז
                  include('reactFiles/UsersByDistrict.php');
                }else{
                  //הצגת מתווכים שרכשו את המוצר/כנס
                  include('reactFiles/catagory_pro_list.php');
                }
              } 
            ?>
          </div>
        </div>
        <?php

      }else{
        echo "<h1>אין לך הרשאות גישה</h1>";
      }
      
      
      ?>


    <?php }?>
 </div>
 
<?php

get_footer();