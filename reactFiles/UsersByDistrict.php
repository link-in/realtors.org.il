<div class="h2-box">
  <h2>חברי מחוז : <?=$_SESSION['district']?></h2>
</div>
<div class="result-number"></div>
<table
  id="table"
  data-ajax="ajaxRequestUsers"
  data-filter-control="true"
  data-detail-view="true"
  data-detail-view-icon="false"
  data-detail-view-by-click="true"
  data-detail-formatter="detailFormatter"
  data-show-export="true"
>
  <thead>
    <tr>
      <th data-formatter="runningFormatter">*</th>
      <th data-field="ID">מזהה</th>
      <th data-field="first_name" data-filter-control="input">שם פרטי</th>
      <th data-field="last_name" data-filter-control="input">שם משפחה</th>
      <th data-field="phone" data-filter-control="input">טלפון</th>
      <th data-field="roles" data-filter-control="select">סוג המינוי</th>
    </tr>
  </thead>
</table>

<script>
  // jQuery(function() {
  //   jQuery('#table').bootstrapTable()
  // });
  jQuery(function() {
        // jQuery('#table').bootstrapTable()

        var jquerytable = jQuery('#table')
        jquerytable.bootstrapTable({
            formatNoMatches: function () {
                return 'לא נמצאו תוצאות';
            },
            formatLoadingMessage: function() {
                return '<b>בטעינה נא להמתין...</b>';
            }
        }).bootstrapTable({
            exportDataType: 'all',
            exportTypes: ['csv', 'excel', 'pdf']
        });

    });
  function detailFormatter(index, row) {
    jQuery("#user_data_form").remove();
    var userData = getUserData(row.ID);
    if(userData.length == 0){
      return false;
    }
    var html = []
    console.log(userData);
    html.push('<div id="user_data_form" class="row"><div class="col-md-6"><form id="user_data">');
    html.push('<h3>פרטים אישים:</h3>');
    html.push('<input type="hidden" name="user_id" value="' + userData.user_id + '" />');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="first_name">שם פרטי</label><input type="text" class="form-control" id="first_name" value="' + userData.first_name + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="last_name">שם משפחה</label><input type="text" class="form-control" id="last_name" value="' + userData.last_name + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="shipping_address_1">כתובת</label><input type="text" class="form-control" id="shipping_address_1" value="' + userData.shipping_address_1 + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="shipping_postcode">מיקוד</label><input type="text" class="form-control" id="shipping_postcode" value="' + userData.shipping_postcode + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="phone">טלפון</label><input type="text" class="form-control" id="phone" value="' + userData.phone + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="district">מחוז</label><input type="text" class="form-control" id="district" value="' + userData.district + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="license_number">מספר מתווך</label><input type="text" class="form-control" id="license_number" value="' + userData.license_number + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="office_name">משרד</label><input type="text" class="form-control" id="office_name" value="' + userData.office_name + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><label for="license_number">מספר מתווך</label><input type="text" class="form-control" id="license_number" value="' + userData.license_number + '"></div>');
    html.push('<div class="form-group col-md-6 col-xs-12"><button onclick="myFunction()" type="submit" class="btn btn-primary" style=" margin-top: 23px;">עדכן</button></div>');
    html.push('</form></div>');
    html.push('<div class="col-md-6">');
    html.push('<h3>הזמנות:</h3>');
    jQuery.each(userData.orders, function (key, line) {
      console.log(line);
      jQuery.each(line, function (key, value) {
        html.push('<p><b>'+(key+1)+' :</b> ' + value.product_name + '</p>');
      });
    });
    html.push('</div>');
    html.push('</div>');


  

    return html.join('')
  }

  function ajaxRequestUsers(params) {
        jQuery.ajax({
          url: "/wp-json/captaincore/v1/customers",
          type: 'GET',
          dataType: 'json',
          headers: {
              'X-WP-Nonce': wpReactLogin.nonceApi
          },
          data: {'district': '<?=$_SESSION['district']?>'},
          contentType: 'application/json; charset=utf-8',
          success: function (result) {
          params.success(result)
          jQuery('.result-number').text('מספר התוצאות: '+result.length)
          // CallBack(result);
          },
          error: function (error) {
              
          }
      });
  }  

  function getUserData(userID){
    var result="";
    jQuery.ajax({
          url: "/wp-json/captaincore/v1/user_data",
          async: false, 
          type: 'GET',
          dataType: 'json',
          headers: {
              'X-WP-Nonce': wpReactLogin.nonceApi
          },
          data: {'userID': userID},
          contentType: 'application/json; charset=utf-8',
          success: function (data) {
            result = data; 
          },
          error: function (error) {
              
          }
      });
      return result;
  }

  function runningFormatter(value, row, index) {
      return index;
  }

function myFunction(){
  jQuery( "#user_data" ).submit(function(event) {
    var data = jQuery('#user_data').serializeArray();
    data.push({action: 'updateuser_action'});
    //console.log(data);
    event.preventDefault();
    });
}


</script>