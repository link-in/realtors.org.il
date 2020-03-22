<form action="<?php the_permalink();?>" method="post">

<!-- Search form -->
<div class="form-group col-sm-12 col-xs-12 col-md-12">
  <input class="form-control" type="text" placeholder="חפש לפי: שם" aria-label="name" name="name_" value="<?=$_name?>">
</div>
<!-- Search form -->
<div class="form-group col-sm-12 col-xs-12 col-md-12">
    <select data-filter="price" class="filter-price filter form-control" name="district_">
        <option value="">חפש לפי: מחוז</option>
        <option value="8524"> מחוז גוש דן</option>
        <option value="8535"> מחוז הדרום והנגב</option>
        <option value="8537"> הלשכה המסחרית</option>
        <option value="8521"> מחוז השפלה</option>
        <option value="8522"> מחוז השרון</option>
        <option value="8536"> מחוז חיפה והגליל המערבי</option>
        <option value="8520"> מחוז ירושלים</option>
        <option value="8538"> פתח תקווה ראש העין והשומרון</option>
        <option value="8523"> מחוז מישור החוף הצפוני</option>
    </select>
</div>

<!-- Search form -->
<!-- <div class="form-group col-sm-12 col-xs-12 col-md-12">
    <select data-filter="price" class="filter-price filter form-control" name="expertise_">
        <option value="">חפש לפי: תחום</option>
        <option value='נדל"ן פרטי'>נדל"ן פרטי</option>
        <option value='נדל"ן מסחרי'>נדל"ן מסחרי</option>
    </select>
</div> -->

<!-- Search form -->
<div class="form-group col-sm-12 col-xs-12 col-md-12">
  <input class="form-control" type="text" placeholder="חפש לפי: מספר רישיון / טלפון / משרד" aria-label="license_number" name="license_number_" value="<?=$license_number_?>">
</div>
 
<!-- Search form -->
<!-- <div class="form-group col-sm-12 col-xs-12 col-md-12">
  <input class="form-control" type="text" placeholder="חפש לפי: מספר טלפון" aria-label="telephone" name="telephone_">
</div> -->

<!-- Search form -->
<!-- <div class="form-group col-sm-12 col-xs-12 col-md-12">
  <input class="form-control" type="text" placeholder="חפש לפי: שם משרד" aria-label="office_name" name="office_name_">
</div> -->


<!-- Search form -->
<div class="form-group col-sm-12 col-xs-12 col-md-12">
    <button id="btn-search" class="btn btn-indigo btn-rounded btn-lg my-0 waves-effect waves-light" type="submit" name="search_" >חפש</button>
    <br>
    <button id="btn-search" class="btn btn-indigo btn-rounded btn-lg my-0 waves-effect waves-light" type="submit" name="resat_" value= "on"style="background:#ddd;margin-top: 10px;">נקה שדות</button>
    <!-- <button id="btn-resat" class="btn btn-elegant btn-rounded btn-md my-0 waves-effect waves-light" type="reset" name="resat_">נקה שדות</button> -->

</div>



</form>
