<?php
$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);
 
$product_categories = get_terms( 'product_cat', $cat_args );

?>

<div class="row admin-box">
    <div class="col-md-6">
        <form id="district-form" >
            <div class="form-group">
                <label for="exampleFormControlSelect1">בחר מחוז: </label>
                <select class="form-control" id="district" name="district">
                <?php
                $values= get_field_object( 'field_5d4bf4ee5e5d0');
                if(isset($_SESSION['district'])){
                    $selected = $_SESSION['district'];
                }else{
                    $selected = '';
                }
                foreach ($values['choices'] as $key => $value) {
                    echo "<option ";
                    if( $value == $selected ){
                        echo 'selected';
                     }
                    echo ">$value</option>";
                }
                ?>  
                </select>
            </div>
        </form>
    </div>

    <div class="col-md-6">
        <label for="exampleFormControlSelect1">בחר אפשרות להצגה: </label>
<?php
if( !empty($product_categories) ){
    echo '<form id="to_view">';
    echo '<select class="form-control" id="product" name="view">';
    echo "<option value='1'>חברי המחוז</option>";
    foreach ($product_categories as $key => $category) {
        $products = wc_get_products(array(
            'category' => array($category->slug),
        ));

        foreach ($products as $pro) {
            // var_dump($pro->get_id());
            echo "<option ";
            if( $pro->get_id() == $_SESSION['view'] ){
                echo "selected ";
            }
            echo "value='{$pro->get_id()}'>{$pro->name}</option>";
        }
    }
    echo '</select>';
    echo '</form>';
}

?>
        

        
    </div>


</div>

<script>
    jQuery('#district').change(function () {
            jQuery( "#district-form" ).submit();
    });

    jQuery('#product').change(function () {
            jQuery( "#to_view" ).submit();
    });

    
</script>
    </div>


</div>
