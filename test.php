<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://www.bmby.com/WebServices/srv/price_offers.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "<soapenv:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\" xmlns:pric=\"http://www.bmby.com/WebServices/srv/price_offers.php\">\n   <soapenv:Header/>\n   <soapenv:Body>\n      <pric:GetAll soapenv:encodingStyle=\"http://schemas.xmlsoap.org/soap/encoding/\">\n         <Parameters xsi:type=\"pric:GetAllInput\">\n            <!--You may enter the following 13 items in any order-->\n   <Login xsi:type=\"xsd:string\">mekarkein</Login>\n            <Password xsi:type=\"xsd:string\">310719</Password>\n            <ProjectID xsi:type=\"xsd:int\">8524</ProjectID>\n                  <ClientID xsi:type=\"xsd:int\">1115894682</ClientID>\n            <OwnerID xsi:type=\"xsd:int\"></OwnerID>\n            <ContractID xsi:type=\"xsd:int\">1115894682</ContractID>\n            <Dynamic xsi:type=\"xsd:int\"></Dynamic>\n            <Limit xsi:type=\"xsd:int\">100</Limit>\n            <Offset xsi:type=\"xsd:int\"></Offset>\n            <OrderDesc xsi:type=\"xsd:int\"></OrderDesc>\n            <FromDate xsi:type=\"xsd:string\"></FromDate>\n            <ToDate xsi:type=\"xsd:string\"></ToDate>\n            <Type xsi:type=\"soapenc:Array\" xmlns:soapenc=\"http://schemas.xmlsoap.org/soap/encoding/\">\n               <!--You may enter ANY elements at this point-->\n              \n\n            </Type>\n\n            <TypeString xsi:type=\"xsd:string\"></TypeString>\n            <SetPrivate xsi:type=\"xsd:int\"></SetPrivate>\n         </Parameters>\n      </pric:GetAll>\n   </soapenv:Body>\n</soapenv:Envelope>",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Connection: keep-alive",
    "Content-Type: application/xml",
    "Host: www.bmby.com",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);




if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}