<h3>אזור ניהול </h3>
<form id="district-form" >
  <div class="form-group">
    <label for="exampleFormControlSelect1">בחר מחוז: </label>
    <select class="form-control" id="district" name="district">
    <?php
    $values= get_field_object( 'field_5d4bf4ee5e5d0');
    if(isset($_GET['district'])){
        $selected = $_GET['district'];
    }else{
        $selected = '';
    }
    foreach ($values['choices'] as $key => $value) {
        echo "<option";
        if( $value == str_replace('+'," ", $selected )){
            echo 'selected';
        }
        echo ">$value</option>";
    }
    ?>  
    </select>
  </div>
</form>

<script>
    jQuery('#district').change(function () {
            jQuery( "#district-form" ).submit();
    });
</script>