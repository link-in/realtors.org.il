<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$membership = false;
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

	if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
    if($_product->get_id() == '3930'){
      $membership = true;

    }
	}
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

if(!is_user_logged_in()){
	?>

	    <div id="wait" style="width: 289px;position: absolute;top: 20%;left: calc(50% - 90px);padding: 2px;text-align: center;visibility: hidden;background: #fff;padding: 40px;border-radius: 5px;">
			<img id="ajax-img" src='<?=get_template_directory_uri()?>/assets/images/demo_wait.gif' width="64" height="64" />
			<br>
			<div id="ajax-text"></div>
		</div>
		<h3 class="member-box-title">בדיקת רישיון תיווך - ראשית יש לבצע בדיקת אימות</h3>
		<div class="member-box">
			<div class="field-box fname-box">
			<div class="form-label"><label for="st-fname">שם פרטי<abbr class="required" title="נדרש" style="color: red; font-weight: 700; border: 0!important; text-decoration: none;">*</abbr></label></div>
			<div class="field"><input type="text" autocomplete="off" name="fname" id="st-fname" value="" /></div>
			<span class="valid-text">שדה חובה!</span>
			</div>
			<div class="field-box lname-box">
			<div class="form-label"><label for="st-lname">שם משפחה<abbr class="required" title="נדרש" style="color: red; font-weight: 700; border: 0!important; text-decoration: none;">*</abbr></label></div>
			<div class="field"><input type="text" autocomplete="off" name="lname" id="st-lname" value="" /></div>
			<span class="valid-text">שדה חובה!</span>
			</div>
			<div class="field-box licenseNumber-box">
			<div class="form-label"><label for="st-licenseNumber">מספר רישון<abbr class="required" title="נדרש" style="color: red; font-weight: 700; border: 0!important; text-decoration: none;">*</abbr></label></div>
			<div class="field"><input type="text" autocomplete="off" name="licenseNumber" id="st-licenseNumber" value="" /></div>
			<span class="valid-text">שדה חובה!</span>
			</div>
			<div class="field-box">
			<div class="field">
			<div class="frm-button"><input type="button" id="isMember" value="אימות פרטים מול הלשכה" /></div>   
			<input type="hidden" name="ismember" id="isMemberStatus" value="false">
			</div>  
			</div> 
			<div class="ismember-error" style="visibility: hidden;display: block;height: 50px;float: right;width: 100%;margin-bottom: 30px;">
				<ul class="woocommerce-error" role="alert">
				<li>
				יש לבצע בדיקה רישיון תיווך		</li>
				</ul>
			</div>
		</div>



	<?php
	}else{
    ?>
    <style>
      p#district_field {
          display: none!important;
      }
    </style>
    <?php
  }
?>

<form id="checkout-form" name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

	<?php if ( $checkout->get_checkout_fields() ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

		<div class="col2-set" id="customer_details">
			<div class="col-1">
				<?php do_action( 'woocommerce_checkout_billing' ); ?>
			</div>

			<div class="col-2">
				<?php do_action( 'woocommerce_checkout_shipping' ); ?>
			</div>
		</div>

		<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

	<?php endif; ?>
	
	<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	<?php if($membership == true){ ?>
    <h3 id="order_review_heading">תקנון ואישורים</h3>
    <div class="legal_approval_box" style="border: 1px solid rgba(0,0,0,.1); margin: 0 0 24px -1px; text-align: right; width: 100%; border-collapse: separate; border-radius: 5px;">
      <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-text validate-required" id="license_number_field" data-priority="100">
        <span class="woocommerce-checkbox-wrapper">
          <input type="checkbox" class="checkbox-text " name="legal_approval" id="legal_approval" placeholder="" value="true">
          אני מאשר/ת את <a href="<?=site_url();?>/%D7%AA%D7%A0%D7%90%D7%99-%D7%A9%D7%99%D7%9E%D7%95%D7%A9/" target="_blank" style="color:#337ab7"> את תנאי השימוש ומדיניות הפרטיות.</a>
          <abbr class="required" title="נדרש">*</abbr> 
        </span>
      </p>

      <!-- <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-text validate-required" id="license_number_field" data-priority="100">
        <span class="woocommerce-checkbox-wrapper">
          <input type="checkbox" class="checkbox-text " name="legal_approval_2" id="legal_approval_2" placeholder="" value="true">
          אני מאשר/ת כי קראתי את 
          <a href="<?=site_url();?>/%d7%aa%d7%a7%d7%a0%d7%95%d7%9f-%d7%90%d7%aa%d7%99%d7%a7%d7%94/" target="_blank" style="color:#337ab7">תקנון האתיקה</a>
          של לשכת המתווכים ומאשר/ת את תוכנו, לרבות בדבר הליך הבוררות לחברי לשכת המתווכים.
          <abbr class="required" title="נדרש">*</abbr> 
        </span>
      </p> -->

      <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-text validate-required" id="license_number_field" data-priority="100">
        <span class="woocommerce-checkbox-wrapper">
          <input type="checkbox" class="checkbox-text " name="legal_approval_2" id="legal_approval_2" placeholder="" value="true">
          אני מאשר/ת כי קראתי את  
          <a href="<?=site_url();?>/%d7%aa%d7%a7%d7%a0%d7%95%d7%9f-%d7%90%d7%aa%d7%99%d7%a7%d7%94/" target="_blank" style="color:#337ab7">תקנון האתיקה</a>
          של לשכת המתווכים ומאשר/ת את תוכנו
          <br>
          אני מתחייב/ת בזאת כי בכל מקרה של תלונה ו/או סכסוך ו/או מחלוקת ביני לבין חבר/י הלשכה ו/או ביני לבין לקוח שיתן את הסכמתו לכך, בכל עניין הקשור לפעילותי כמתווך, יובא המקרה לדיון בפני ועדת הבוררות של הלשכה, הליכי הבוררות יהיו בהתאם לנוהלי בוררות של הלשכה ויהיו כפופים להוראות חוק הבוררות התשכ"ח 1968 ואני מתחייב למלא אחר החלטות מוסד הבוררות של הלשכה.
          <abbr class="required" title="נדרש">*</abbr> 
        </span>
      </p>

      <p class="form-row form-row-wide thwcfd-field-wrapper thwcfd-field-text validate-required" id="license_number_field" data-priority="100">
        <span class="woocommerce-checkbox-wrapper">
          <input type="checkbox" class="checkbox-text " name="legal_approval_3" id="legal_approval_3" placeholder="" value="true" checked>
          אני מאשר/ת קבלת דברי פרסומת, לרבות באמצעות דוא"ל וסלולר והעברת הפרטים שנמסרו על-ידי לצדדים שלישיים.
        </span>
      </p>

    </div>  
  <?php } ?>
	<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>



	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>

</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>

<script>
 
 jQuery(document).ready(function(){

    function ajaxStart(){
        jQuery('#ajax-img').attr("src","<?=get_template_directory_uri()?>/assets/images/demo_wait.gif");
      jQuery('.member-box').css('opacity', '0.3');
        jQuery('.registration-title').css('opacity', '0.3');
        jQuery("#wait").css('visibility', 'visible');
    };

    jQuery(document).ajaxComplete(function(){
      setTimeout(function(){
        jQuery("#wait").css('visibility', 'hidden');
    },3000);
    });
    
    function isValid(selctor,val,valid){

      if(val == '' || val == 'נא לבחור מחוז' || val == 'נא לבחור תחום'){
        // alert(selctor)
        jQuery("#st-"+selctor+"").css({
          'background-color': '#FFFFCC',
          'border-color': '#a94442'
        });
        jQuery('.'+selctor+'-box .valid-text').show();
        return false;
      }else{
        jQuery("#st-"+selctor+"").css({
          'background-color': '#ffffff',
          'border-color': '#cccccc'
        });
        jQuery('.'+selctor+'-box .valid-text').hide();

        if(valid == false){
          return false;
        }else{
          return true;
        }
      }
    }

    jQuery('#isMember').on('click',function(){
      var  valid = true;
      var firname = jQuery("#st-fname").val();
      valid = isValid('fname',firname,valid);

      var lasname = jQuery("#st-lname").val();
      valid = isValid('lname',lasname,valid);

      var licenseNumber = jQuery("#st-licenseNumber").val();
      valid = isValid('licenseNumber',licenseNumber,valid);
      jQuery('#ajax-text').text('אנו בודקים את המידע ... סבלנות').css({"color":"#5e5e5e","font-size":"16px"});
      if(valid == true){  
      ajaxStart();	
        var data = {
          action: 'isMember_action',
          firname: firname,
          lasname: lasname,
          licenseNumber: licenseNumber
          
        };

        jQuery.post( ajaxurl, data, function(res){ // ajaxurl must be defined previously

          var obj = JSON.parse(res);
          //console.log(obj)
          if(obj.valid == 'true'){

            jQuery('#ajax-img').attr("src","<?=get_template_directory_uri()?>/assets/images/v.jpg");
            jQuery('#ajax-text').text('ברוכים הבאים .. נמשיך בתהליך ההרשמה');
            jQuery('#billing_first_name').val(jQuery("#st-fname").val());
            jQuery('#billing_last_name').val(jQuery("#st-lname").val());
            jQuery('#license_number').val(jQuery("#st-licenseNumber").val());
            
            jQuery('#isMemberStatus').val('true');
            jQuery('.ismember-error').css("visibility","hidden");
            setTimeout(function(){
                  jQuery('.member-box').css('opacity', '0.3');
                  jQuery('.registration-title').css('opacity', '1');
            },3000);


            setTimeout(function(){    
              jQuery('html, body').animate({
                scrollTop: jQuery(".woocommerce-billing-fields").offset().top
              }, 1000); 
            },4500);

          }else{
            jQuery('#ajax-img').hide();
            jQuery('#ajax-text').text('לא נמצא, נא לבדוק שכל הפרטים נכונים').css({"color":"red","font-size":"16px"});
            setTimeout(() => {
              jQuery('.member-box').css('opacity', '1');  
              jQuery('.registration-title').css('opacity', '1');
            }, 3000);
            
          }
        });
        // jQuery("#error-message").html(res);
      }
    });
  
    jQuery('#register-me').on('click',function(){
      var valid = true;
      var action = 'register_action';
        
      var username = jQuery("#st-username").val();
      
      if(username == ''){
        jQuery("#st-username").css("border-color", "#a94442!important");
        valid = false;
      }

      var mail_id = jQuery("#st-email").val();
      valid = isValid('email',mail_id,valid);

      var firname = jQuery("#st-fname").val();
      var lasname = jQuery("#st-lname").val();
      
      var phone = jQuery("#st-phone").val();
      valid = isValid('phone',phone,valid);

      var validID = jQuery("#validID").val();
      var licenseNumber = jQuery("#st-licenseNumber").val();
      valid = isValid('licenseNumber',licenseNumber,valid);

      var office_name = jQuery("#st-office_name").val();
      valid = isValid('office_name',office_name,valid);

      var district = jQuery("#st-district").val();
      valid = isValid('district',district,valid);

      var expertise = jQuery("#st-expertise").val();
      valid = isValid('expertise',expertise,valid);

      if(valid == true){
          var ajaxdata = {
            
          action: 'register_action',
          username: username,
          mail_id: mail_id,
          firname: firname,
          lasname: lasname,
          phone: phone,
          validID: validID,
          licenseNumber: licenseNumber,
          office_name: office_name,
          district: district,
          expertise: expertise
          };
          // debugger;
          //console.log(ajaxdata);
          jQuery('#ajax-text').text('המידע נשלח ... נא להמתין');
          jQuery.post( ajaxurl, ajaxdata, function(res){ 
            console.log('obj',obj);
            var obj = JSON.parse(res);
            if(obj.user_registered == 'true'){
              jQuery("#wait").css('visibility', 'hidden');
              jQuery('.r-form').hide();
              jQuery('.f_name').text(jQuery("#st-fname").val());
              jQuery('.user_registered').show();
            }else{
              jQuery("#error-message").append(obj.error);
            }
            
          });
      }
    });
  
    jQuery( 'form.checkout' ).on( 'checkout_place_order', function() {
      var $payment_method = jQuery( 'form.checkout input[name="payment_method"]:checked' ).val();
      if (  jQuery('#isMemberStatus').val() == 'false' ) {
          // prevent the submit AJAX call
      jQuery('.ismember-error').css("visibility","visible");
      jQuery('html, body').animate({
        scrollTop: jQuery(".member-box-title").offset().top
      }, 1000)       
        return false;
      }else{
      jQuery('.ismember-error').css("visibility","hidden");
    }

    return true;
 });

 jQuery('#district').change(function(){
      if(jQuery(this).val() == 'מחוז גוש דן'){ 
        jQuery('p#sub_district_1_field').css("display", "block");
      }
      if(jQuery(this).val() == 'מחוז אילת'){ 
        jQuery('p#sub_district_2_field').css("display", "block");
      }
      // if(jQuery(this).val() == 'מחוז אילת'){ 
      //   jQuery('p#sub_district_2_field').css("display", "block");
      // }

      // if(jQuery(this).val() == 'מחוז השפלה'){ 
      //   jQuery('p#sub_district_3_field').css("display", "block");
      // }

      // if(jQuery(this).val() == 'מחוז השרון'){ 
      //   jQuery('p#sub_district_4_field').css("display", "block");
      // }

      // if(jQuery(this).val() == 'מחוז חיפה והגליל המערבי'){ 
      //   jQuery('p#sub_district_5_field').css("display", "block");
      // }

      // if(jQuery(this).val() == 'מחוז חיפה והגליל המערבי'){ 
      //   jQuery('p#sub_district_5_field').css("display", "block");
      // }

      // if(jQuery(this).val() == 'מחוז פתח תקוה ראש העין והשומרון'){ 
      //   jQuery('p#sub_district_7_field').css("display", "block");
      // }
      
  });

});//documentready

</script>

<style>

  #sub_district_1_field,
  #sub_district_2_field,
  #sub_district_3_field,
  #sub_district_4_field,
  #sub_district_5_field,
  #sub_district_6_field,
  #sub_district_7_field{
    display:none;
  }

  span.optional {
      display: none;
  }
  .form-row-sub-district {
      float: right;
      margin-right: 53%!important;
  }
  p#sub_district_1_field {
      display: none;
  }
  input#isMember,input#register-me {
    background: #337ab7;
    color: #fff;
    border: none;
    border-radius: 3px;
    margin-top: 30px;
    height: 44px;
    width: 100%;
    max-width: 180px;
  }

  .field-box {
    float: right;
    width: calc(50% - 20px);
    margin: 0 10px; 
    min-height: 110px;
  }
  select.browser-default.custom-select {
    width: 100%;
    height: 44px;
    background: #fff;
  }

  .valid-text {
    color: #a94442;
    display: none;
  }

  input#st-email {
      direction: ltr;
      text-align: right;
  }

  .f_name{
    font-weight: 400;
  }
  
  div#error-message {
    color: #f36464;
    /* border: 1px solid #f36464; */
    padding: 20px;
    font-weight: 600;
  }
  ul.woocommerce-error {
    float: right;
    width: 100%;
  }

</style>
