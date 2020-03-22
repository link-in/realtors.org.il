<?php 
/* Template Name: users_registration */ 
get_header();
global $wpdb;
?>




<div class="form-wrapper" style="position: relative;">
    <h2 class="registration-title" style="color: #337ab7;font-family: &quot;Assistant&quot;, Sans-serif;">הרשמה ללשכת המתווכים הארצית</h2>

    <div id="wait" style="visibility: hidden;width: 239px;height: 109px;position: absolute;top: 30%;left: calc(50% - 120px);padding: 2px;text-align: center;">
    <img id="ajax-img" src='<?=get_template_directory_uri()?>/assets/images/demo_wait.gif' width="64" height="64" />
    <br>
    <div id="ajax-text">אנו בודקים את המידע ... סבלנות :-)</div>
  </div>
    
  <div class="user_registered" style=" border: 2px solid #2a9ed8; padding: 40px; margin-top: 90px;display:none">
    <h2>
    שלום <span class="f_name"></span> <br>
    נרשמת בהצלחה ללשכת המתווכים הארצית <br>
    פרטי ההרשמה נשלחו אלייך לאיימיל ,עכשיו תכל לרכוש מנוי שנתי ללשכה<br>
    <a href="/product/מינוי-ללשכה/" style="color:#2a9ed8">לרכישה</a>
    </h2>
  </div>


<a href="https://data.gov.il/api/action/datastore_search?resource_id=a0f56034-88db-4132-8803-854bcdb01ca1&limit=40" target="_blank">קישור למשרד המשפטים</a>
<br>

 <form method="post" name="st-register-form" class="r-form">
    <div class="member-box">
      <div class="field-box fname-box">
        <div class="form-label"><label for="st-fname">שם פרטי</label></div>
        <div class="field"><input type="text" autocomplete="off" name="fname" id="st-fname" value="" /></div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <div class="field-box lname-box">
        <div class="form-label"><label for="st-lname">שם משפחה</label></div>
        <div class="field"><input type="text" autocomplete="off" name="lname" id="st-lname" value="" /></div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <div class="field-box licenseNumber-box">
        <div class="form-label"><label for="st-licenseNumber">מספר רישון</label></div>
        <div class="field"><input type="text" autocomplete="off" name="licenseNumber" id="st-licenseNumber" value="" /></div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <div class="field-box">
      <div class="field">
        <div class="frm-button"><input type="button" id="isMember"  value="אימות פרטים מול הלשכה" /></div>   
      </div>  
      </div> 
    </div>
    <div class="all-fileds" style="display:none">
      <div class="field-box phone-box">
        <div class="form-label"><label for="st-phone">טלפון</label></div>
        <div class="field"><input type="text" autocomplete="off" name="phone" id="st-phone" value=""/></div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <div class="field-box office_name-box">
        <div class="form-label"><label for="st-office_name">שם המשרד</label></div>
        <div class="field"><input type="text" autocomplete="off" name="office_name" id="st-office_name" value=""/></div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <div class="field-box district-box">
        <div class="form-label"><label for="st-district">מחוז</label></div>
        <div class="field">
          <select id="st-district" name="st-district" class="browser-default custom-select">
            <option selected>נא לבחור מחוז</option>
            <option value="8524">מחוז גוש דן</option>
            <option value="8535">מחוז הדרום והנגב</option>
            <option value="8537">מחוז העמקים והגליל העליון</option>
            <option value="8521">מחוז השפלה</option>
            <option value="8522">מחוז השרון</option>
            <option value="8536">מחוז חיפה והגליל המערבי</option>
            <option value="8520">מחוז ירושלים</option>
            <option value="8538">מחוז מישור החוף הדרומי</option>
            <option value="8523">מחוז מישור החוף הצפוני</option>
          </select>
        </div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <div class="field-box expertise-box">
        <div class="form-label"><label for="st-expertise">תחום</label></div>
        <div class="field">
          <select id="st-expertise" name="st-expertise" class="browser-default custom-select">
            <option selected>נא לבחור תחום</option>
            <option value='נדל"ן פרטי'>נדל"ן פרטי</option>
            <option value='נדל"ן מסחרי'>נדל"ן מסחרי</option>
          </select>
        </div>
        <span class="valid-text">שדה חובה!</span>
      </div>

      <!-- <div class="field-box">
        <div class="form-label"><label for="st-username"><?php _e( 'Username', 'debate' ); ?></label></div>
        <div class="field"><input type="text" autocomplete="off" name="username" id="st-username" /></div>
      </div> -->
      <div class="field-box email-box">
        <div class="form-label"><label for="st-email">אימייל</label></div>
        <div class="field">
          <input type="email" autocomplete="off" name="mail" id="st-email" value="" />
        </div>
        <span class="valid-text">שדה חובה!</span>
      </div>
      <!-- <div class="field-box">
        <div class="form-label"><label for="st-psw"><?php _e( 'Password', 'debate' ); ?></label></div>
        <div class="field"><input type="password" name="password" id="st-psw" /></div>
      </div>   -->
      <div class="field-box">
        <input type="hidden" id="validID" name="validID" value="">
        <div class="frm-button"><input type="button" id="register-me" value="הרשמה" /></div>
      </div>

      <div class="row">
        <div id="error-message"></div>
      </div>


    </div>

 </form>
  
 </div>
 
<script>
 
 jQuery(document).ready(function(){
  

  //jQuery(document).ajaxStart(function(){
 function startAjax(){
      jQuery('#ajax-text').text('המידע נשלח ... נא להמתין');
      jQuery('#ajax-text').css('color','rgb(51, 122, 183)');
      jQuery('#ajax-img').attr("src","<?=get_template_directory_uri()?>/assets/images/demo_wait.gif");
      jQuery('#ajax-img').show();
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
    jQuery('#ajax-text').text('');
    var firname = jQuery("#st-fname").val();
    valid = isValid('fname',firname,valid);

    var lasname = jQuery("#st-lname").val();
    valid = isValid('lname',lasname,valid);

    var licenseNumber = jQuery("#st-licenseNumber").val();
    valid = isValid('licenseNumber',licenseNumber,valid);

    if(valid == true){  
      startAjax();
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
          jQuery('#ajax-text').text('ברוכים הבאים .. נמשיך בתהליך ההרשמה').css("color","rgb(13, 126, 224)");
          setTimeout(function(){
            jQuery('.member-box').css('opacity', '0.3');
            jQuery('.registration-title').css('opacity', '1');
          },3000)
          jQuery(":input[name=phone]").select();
          jQuery('#validID').val(obj.validID);
          jQuery('.all-fileds').show();
        }else{
          jQuery('#ajax-img').hide();
          jQuery('#ajax-text').text('לא נמצא, נא לבדוק שכל הפרטים נכונים').css({"color":"red","font-size":"22px"});
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
        startAjax();
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
        
        jQuery.post( ajaxurl, ajaxdata, function(res){ 
          console.log(res);
          var obj = JSON.parse(res);
          console.log('obj',obj);
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
 
});//documentready

</script>

<style>
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
</style>

<?php

get_footer();