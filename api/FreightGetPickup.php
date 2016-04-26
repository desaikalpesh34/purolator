<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Services Options Web Service.
*********************************************************************************/ 

//Define the Production (or development) Key and Password
define("PRODUCTION_KEY", "YOUR_PRODUCTION_KEY_HERE");
define("PRODUCTION_PASS", "YOUR_PRODUCTION_PASS_HERE");

//Define the Billing account and the account that is registered with PWS
define("BILLING_ACCOUNT", "YOUR_ACCOUNT_HERE");
define("REGISTERED_ACCOUNT", "YOUR_ACCOUNT_HERE");

function createPWSSOAPClient()
{	
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( "./wsdl/FreightPickUpService.wsdl", 
                            array	(
					'trace'			=>	true,
					'location' => "https://devwebservices.purolator.com/PWS/V1/FreightPickUp/FreightPickUpService.asmx",
					'uri'				=>	"http://purolator.com/pws/datatypes/v1",
					'login'			=>	PRODUCTION_KEY,
					'password'	=>	PRODUCTION_PASS
                                  )
                          );
						 
						  
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.0',
                                        'Language'          =>  'en',
                                        'GroupID'           =>  'xxx',
                                        'RequestReference'  =>  'PickUp Example'
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
	Schedule PickUp Example(s)
	EXAMPLE 01:    
*********************************************************************************/ 

//Create a SOAP Client for this Example
$client = createPWSSOAPClient();

$request->PickUp->SenderInformation->Address->Name = "PWS User";
$request->PickUp->SenderInformation->Address->Company = "Company";
$request->PickUp->SenderInformation->Address->Department = "Department";
$request->PickUp->SenderInformation->Address->StreetNumber = "5280";
$request->PickUp->SenderInformation->Address->StreetSuffix = "";
$request->PickUp->SenderInformation->Address->StreetName ="Solar";
$request->PickUp->SenderInformation->Address->StreetType ="Drive";
$request->PickUp->SenderInformation->Address->StreetDirection = "";
$request->PickUp->SenderInformation->Address->Suite = "";
$request->PickUp->SenderInformation->Address->Floor = "";
$request->PickUp->SenderInformation->Address->StreetAddress2 = "";
$request->PickUp->SenderInformation->Address->StreetAddress3 = "";
$request->PickUp->SenderInformation->Address->City = "Mississauga";
$request->PickUp->SenderInformation->Address->Province = "ON";
$request->PickUp->SenderInformation->Address->Country = "CA";
$request->PickUp->SenderInformation->Address->PostalCode = "M2R3G7";
$request->PickUp->SenderInformation->Address->PhoneNumber->CountryCode = "1";
$request->PickUp->SenderInformation->Address->PhoneNumber->AreaCode = "905";
$request->PickUp->SenderInformation->Address->PhoneNumber->Phone = "7128101";
$request->PickUp->SenderInformation->EmailAddress="YOUR EMAIL ADDRESS";

$request->PickUp->ReceiverInformation->Address->Name = "PWS User";
$request->PickUp->ReceiverInformation->Address->Company = "Company";
$request->PickUp->ReceiverInformation->Address->Department = "Department";
$request->PickUp->ReceiverInformation->Address->StreetNumber = "5280";
$request->PickUp->ReceiverInformation->Address->StreetSuffix = "";
$request->PickUp->ReceiverInformation->Address->StreetName ="Solar";
$request->PickUp->ReceiverInformation->Address->StreetType ="Drive";
$request->PickUp->ReceiverInformation->Address->StreetDirection = "";
$request->PickUp->ReceiverInformation->Address->Suite = "";
$request->PickUp->ReceiverInformation->Address->Floor = "";
$request->PickUp->ReceiverInformation->Address->StreetAddress2 = "";
$request->PickUp->ReceiverInformation->Address->StreetAddress3 = "";
$request->PickUp->ReceiverInformation->Address->City = "Mississauga";
$request->PickUp->ReceiverInformation->Address->Province = "ON";
$request->PickUp->ReceiverInformation->Address->Country = "CA";
$request->PickUp->ReceiverInformation->Address->PostalCode = "L5R3T8";
$request->PickUp->ReceiverInformation->Address->PhoneNumber->CountryCode = "1";
$request->PickUp->ReceiverInformation->Address->PhoneNumber->AreaCode = "905";
$request->PickUp->ReceiverInformation->Address->PhoneNumber->Phone = "7128101";
$request->PickUp->ReceiverInformation->EmailAddress="YOUR EMAIL ADDRESS";


$request->PickUp->PaymentInformation->BillingAccountNumber = BILLING_ACCOUNT;
$request->PickUp->PaymentInformation->RegisteredAccountNumber = REGISTERED_ACCOUNT;
$request->PickUp->PaymentInformation->PaymentType = "Sender";

$request->PickUp->ShipmentDetails->ServiceTypeCode="1";
$request->PickUp->ShipmentDetails->ShipmentDate = "YOUR SHIPMENT DATE";

$request->PickUp->ShipmentDetails->DeclaredValue="1";
$request->PickUp->ShipmentDetails->SpecialInstructions="TEST";

$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->LineNumber="1";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Pieces="2";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->HandlingUnit=1;
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->HandlingUnitType="Skid";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Description="Test Item";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Weight->Value="5100";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Weight->WeightUnit="lb";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Length->Value="48";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Length->DimensionUnit="in";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Width->Value="48";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Width->DimensionUnit="in";

$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Height->Value="48";
$request->PickUp->ShipmentDetails->LineItemDetails->LineItem->Height->DimensionUnit="in";


$request->PickUp->ShipmentDetails->AccesorialParameters->BoolValuePair->Keyword="RESID";
$request->PickUp->ShipmentDetails->AccesorialParameters->BoolValuePair->Value="true";


$request->PickUp->ShipmentDetails->CustomerReferences->CustomerReference->Code="as";
$request->PickUp->ShipmentDetails->CustomerReferences->CustomerReference->Sequence="1";


$request->PickUp->PickupInformation->PickupDate="YOUR PICKUP DATE";
$request->PickUp->PickupInformation->ReadyTime="12:00";
$request->PickUp->PickupInformation->CloseTime="18:00";

$request->PickUp->PickupInformation->PickUpOptions->BoolValuePair->Keyword="DG";
$request->PickUp->PickupInformation->PickUpOptions->BoolValuePair->Value="false";

$request->PickUp->PickupInformation->OtherOption="a";
$request->PickUp->PickupInformation->StopNotes="a";
$request->PickUp->PickupInformation->DriverNotes="a";



//Execute the request and capture the response
$response = $client->GetFreightPickUp($request);

print $request;

print "<pre>\n"; 
print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
print "</pre>";
  
  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>PickUp Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:FreightGetPickUpRequest><ns1:PickUp><ns1:SenderInformation><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>5280</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>M2R3G7</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:SenderInformation><ns1:ReceiverInformation><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>5280</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L5R3T8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:ReceiverInformation><ns1:PaymentInformation><ns1:PaymentType>Sender</ns1:PaymentType><ns1:RegisteredAccountNumber>3478037</ns1:RegisteredAccountNumber><ns1:BillingAccountNumber>3478037</ns1:BillingAccountNumber></ns1:PaymentInformation><ns1:ShipmentDetails><ns1:ServiceTypeCode>1</ns1:ServiceTypeCode><ns1:ShipmentDate>2015-03-10</ns1:ShipmentDate><ns1:DeclaredValue>1</ns1:DeclaredValue><ns1:SpecialInstructions>TEST</ns1:SpecialInstructions><ns1:LineItemDetails><ns1:LineItem><ns1:LineNumber>1</ns1:LineNumber><ns1:Pieces>2</ns1:Pieces><ns1:HandlingUnit>1</ns1:HandlingUnit><ns1:HandlingUnitType>Skid</ns1:HandlingUnitType><ns1:Description>Test Item</ns1:Description><ns1:Weight><ns1:Value>5100</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:Weight><ns1:Length><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Length><ns1:Width><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Width><ns1:Height><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Height></ns1:LineItem></ns1:LineItemDetails><ns1:AccesorialParameters><ns1:BoolValuePair><ns1:Keyword>RESID</ns1:Keyword><ns1:Value>false</ns1:Value></ns1:BoolValuePair></ns1:AccesorialParameters><ns1:CustomerReferences><ns1:CustomerReference><ns1:Sequence>1</ns1:Sequence><ns1:Code>as</ns1:Code></ns1:CustomerReference></ns1:CustomerReferences></ns1:ShipmentDetails><ns1:PickupInformation><ns1:PickupDate>2015-03-10</ns1:PickupDate><ns1:ReadyTime>12:00</ns1:ReadyTime><ns1:CloseTime>18:00</ns1:CloseTime><ns1:PickUpOptions><ns1:BoolValuePair><ns1:Keyword>DG</ns1:Keyword><ns1:Value>false</ns1:Value></ns1:BoolValuePair></ns1:PickUpOptions><ns1:OtherOption>a</ns1:OtherOption><ns1:StopNotes>a</ns1:StopNotes><ns1:DriverNotes>a</ns1:DriverNotes></ns1:PickupInformation></ns1:PickUp></ns1:FreightGetPickUpRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>


**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>PickUp Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetPickUpResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><PickupNumber>433</PickupNumber></GetPickUpResponse></s:Body></s:Envelope>

  
**/

//Display the services and associated rules for this shipment
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
	 [ResponseInformation] => [PickupNumber] => 433 
)
**/

?>
