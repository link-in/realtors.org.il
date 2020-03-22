<?php 
    if($no_results == false){ 
        ?> 
        <div class="elementor-row">
            <div class="elementor-element elementor-column elementor-col-50 elementor-inner-column">
                <h2>חברי הלשכה</h2>        
            </div>
            <div class="elementor-element elementor-column elementor-col-50 elementor-inner-column" style=" margin: 15px 0; line-height: 36px; ">
                <?php
                    if(!empty($to_search)){
                     echo 'לחיפוש: '.$to_search;   
                    }
                ?>
            </div>
        </div>  
        <?php
    }else{
        echo "<h2 style='font-size: 80px;'>לא נמצאו תוצאות...</h2>"; 
    }


    $page = ! empty( $_GET['page_'] ) ? (int) $_GET['page_'] : 1;
    $total = count( $ids ); //total items in array    
    $limit = 15; //per page    
    $totalPages = ceil( $total/ $limit ); //calculate total pages
    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;
    
    $ids = array_slice( $ids, $offset, $limit );   
     
    // var_dump($ids);
    
    
?>
<div class="container">
<?php 
$count = 0;
if(!empty($ids)){
    foreach ($ids as $id ) {
        $member=get_user_by('id',$id);
       
        $userMeta=get_user_meta($id);
        // var_dump($userMeta['wp_capabilities'][0]);
        $wp_capabilities = unserialize($userMeta['wp_capabilities'][0]);
        $role_ = key($wp_capabilities);
        // var_dump($role_);
        if($role_ == 'author'){
            if($wp_capabilities['author'] != true){continue;}
        }
        elseif($role_ == 'new_monthly_subscriptionnot'){
            if($wp_capabilities['new_monthly_subscriptionnot'] != true){continue;}
        }elseif($role_ == 'monthly_subscriptionnot_approve'){
            // var_dump($wp_capabilities['monthly_subscriptionnot_approve']);
            // exit;
            if($wp_capabilities['monthly_subscriptionnot_approve'] != true){continue;}
        }else{
            continue;
        }

        $district = $userMeta['district'][0];
        // var_dump($district);
        // var_dump($district_);
        if(!empty($district_)){
            if($district_ != $district){
                continue;
            }
        }
        $dist=get_field_object('district',"user_5");
        $district_name= $dist["choices"][$district];

        // expertise
        $expertise=unserialize($userMeta['expertise'][0]);
        $userMeta['expertise'][0] = $expertise[0];
        
        // var_dump(unserialize($userMeta['district'][0]));
        // exit;
        $count++;
    ?>
    
    <div id="" class="row content-">
        <section id="main" class="col-sm-12 col-md-12 full-width row-user " role="main">
            <div class="elementor-row">
                <div class="elementor-element elementor-column elementor-col-30 elementor-inner-column avatar-box">
                    <div class="search-users-sidebar">
                        <?php echo get_avatar($member->ID,150);?>
                    </div>
                </div>

                <div class="elementor-element elementor-column elementor-col-70 elementor-inner-column list-box">
                    <div class="search-users-main">
                        <div id="authorlist">


                            <div class="r-side">
                                <b>שם:</b>  
                                <span style="color:#95a5a6"><?=$member->data->display_name?></span>
                                <br>
                                <?php 
                                if(!empty($userMeta['expertise'][0])){
                                    ?>
                                    <b>תחום התמחות:</b>
                                    <?=$userMeta['expertise'][0]?>
                                    <br>
                                    <?php
                                }
                                ?>
                                <?php
                                if(!empty($userMeta['license_number'][0]) && intval($userMeta['license_number'][0])){
                                    ?>
                                    <b>מספר רישיון:</b>
                                    <?=$userMeta['license_number'][0]?>
                                    <br>
                                    <?php    
                                }
                                ?>
                                <?php 
                                if(!empty($userMeta['phone'][0])){
                                    ?>
                                    <b>מספר טלפון:</b>
                                    <?=$userMeta['phone'][0]?>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="l-side">
                                <?php 
                                if(!empty($userMeta['expertise'][0])){
                                    ?>
                                    <b>שם המשרד:</b>
                                    <?=$userMeta['office_name'][0]?>
                                    <br>
                                    <?php
                                }
                                ?>
                                <?php 
                                if(!empty($district_name)){
                                    ?>
                                    <b>מחוז:</b>
                                    <?=$district_name?>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php
}
}
?>
<div class="row">
    <div class="elementor-element elementor-column elementor-col-50 elementor-inner-column" style=" margin: 15px 0; line-height: 36px; ">
        <?php
            if(!empty($to_search)){
                echo 'סה״כ תוצאות מוצגות: '.$count ;   
            }
        ?>
    </div>
</div>
<div class="row">
        <div class="pagination">
            <!-- <a href="#" >&laquo;</a> -->
            <?php
            // var_dump($totalPages);
            if($totalPages > 16){
                $toLoop=16;
            }else{
                $toLoop=$totalPages;
            } 

            if($page < 16){
                for($i=1;$i < $toLoop;$i++){    
                    echo "<a href='?page_=$i' class='".($page==$i ? 'active' : '')."'>$i</a>";                
                }
                if($totalPages > 16){
                echo "<a href='?page_=16' class='".($page==16 ? 'active' : '')."'>>></a>";    
                }
            }
            
            if($page >=16){
                for($i=16;$i < $totalPages;$i++){    
                    echo "<a href='?page_=$i' class='".($page==$i ? 'active' : '')."'>$i</a>";                
                }
            }
            ?>
            <!-- <a href="">&raquo;</a> -->
        </div>
    </div>    
</div>

