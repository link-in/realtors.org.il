<?php
$product = wc_get_product( $_SESSION['view'] );
?>
<div class="h2-box">
    <h2>
        רכישות:
        <?=$product->name ?>
    </h2>
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

    function ajaxRequestUsers(params) {
            jQuery.ajax({
            url: "/wp-json/captaincore/v1/purchased_users",
            type: 'GET',
            dataType: 'json',
            headers: {
                'X-WP-Nonce': wpReactLogin.nonceApi
            },
            data: {'prodcatid':'<?=$_SESSION['view']?>','district':'<?=$_SESSION['district']?>'},
            contentType: 'application/json; charset=utf-8',
            success: function (result) {
                jQuery('.result-number').text('מספר התוצאות: '+result.length)
                params.success(result)
                // console.log(result);
            
            // CallBack(result);
            },
            error: function (error) {
                
            }
        });
    }  

    function detailFormatter(index, row) {
        var html = []
        console.log(row);
        
        jQuery.each(row, function (key, value) {
            console.log(value);
            
            html.push('<p>'+ value + '</p>')
        })
        return html.join('')
    }
    function runningFormatter(value, row, index) {
        return index;
    }

</script>