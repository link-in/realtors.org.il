
<link href="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.css" rel="stylesheet">
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>

<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js"></script>
<script src="https://unpkg.com/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.16.0/dist/extensions/export/bootstrap-table-export.min.js"></script>

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
        jquerytable.bootstrapTable('destroy').bootstrapTable({
            exportDataType: 'all',
            exportTypes: ['csv', 'excel', 'pdf']
        });

    });
  function detailFormatter(index, row) {
    var orders = getUserOrders(row.ID);
    if(orders.length == 0){
      return false;
    }
    var html = []
    jQuery.each(orders, function (key, value) {
      console.log(value);
      
      html.push('<p><b>מוצר :</b> ' + value.product_name + '</p>')
    })
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
          data: {'district': '<?=$district?>'},
          contentType: 'application/json; charset=utf-8',
          success: function (result) {
          params.success(result)
          
          // CallBack(result);
          },
          error: function (error) {
              
          }
      });
  }  

  function getUserOrders(userID){
    var result="";
    jQuery.ajax({
          url: "/wp-json/captaincore/v1/user_order",
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
  
</script>