<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Services Options Web Service.
*********************************************************************************/ 

require(__DIR__ . '/../config/main.php');
require(__DIR__ .'/base.php');

function createPWSSOAPClient()
{	
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( WSDL_URL."/FreightEstimatingService.wsdl", 
                            array	(
					'trace'			=>	true,
					'location' => "https://devwebservices.purolator.com/PWS/V1/FreightEstimating/FreightEstimatingService.asmx",
					'uri'				=>	"http://purolator.com/pws/datatypes/v1",
					'login'			=>	PRODUCTION_KEY,
					'password'	=>	PRODUCTION_PASS
                                  )
                          );						
						  
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.1',
                                        'Language'          =>  'en',
                                        'GroupID'           =>  'xxx',
                                        'RequestReference'  =>  'Estimate Example',
                                        'UserToken'         =>  USER_TOKEN //activation key
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
	Schedule Estimate Example(s)
	EXAMPLE 01:    
*********************************************************************************/ 

//Create a SOAP Client for this Example
$client = createPWSSOAPClient();
$request = new FreightEstimatingService();
$request->Estimate->SenderInformation->Address->Name = "Kalpesh Desai";
$request->Estimate->SenderInformation->Address->Company = "Medicon";
$request->Estimate->SenderInformation->Address->Department = "Sales";
$request->Estimate->SenderInformation->Address->StreetNumber = "234";
$request->Estimate->SenderInformation->Address->StreetSuffix = "";
$request->Estimate->SenderInformation->Address->StreetName ="Laurier Avenue West";
$request->Estimate->SenderInformation->Address->StreetType ="Drive";
$request->Estimate->SenderInformation->Address->StreetDirection = "";
$request->Estimate->SenderInformation->Address->Suite = "";
$request->Estimate->SenderInformation->Address->Floor = "";
$request->Estimate->SenderInformation->Address->StreetAddress2 = "";
$request->Estimate->SenderInformation->Address->StreetAddress3 = "";
$request->Estimate->SenderInformation->Address->City = "Ottawa";
$request->Estimate->SenderInformation->Address->Province = "ON";
$request->Estimate->SenderInformation->Address->Country = "CA";
$request->Estimate->SenderInformation->Address->PostalCode = "K1A0G9";
@$request->Estimate->SenderInformation->Address->PhoneNumber->CountryCode = "1";
$request->Estimate->SenderInformation->Address->PhoneNumber->AreaCode = "905";
$request->Estimate->SenderInformation->Address->PhoneNumber->Phone = "7128101";
$request->Estimate->SenderInformation->EmailAddress="kalpesh@varshaawebteam.com";

@$request->Estimate->ReceiverInformation->Address->Name = "Jay";
$request->Estimate->ReceiverInformation->Address->Company = "android";
$request->Estimate->ReceiverInformation->Address->Department = "Purchase";
$request->Estimate->ReceiverInformation->Address->StreetNumber = "5280";
$request->Estimate->ReceiverInformation->Address->StreetSuffix = "";
$request->Estimate->ReceiverInformation->Address->StreetName ="Solar";
$request->Estimate->ReceiverInformation->Address->StreetType ="Drive";
$request->Estimate->ReceiverInformation->Address->StreetDirection = "";
$request->Estimate->ReceiverInformation->Address->Suite = "";
$request->Estimate->ReceiverInformation->Address->Floor = "";
$request->Estimate->ReceiverInformation->Address->StreetAddress2 = "";
$request->Estimate->ReceiverInformation->Address->StreetAddress3 = "";
$request->Estimate->ReceiverInformation->Address->City = "Mississauga";
$request->Estimate->ReceiverInformation->Address->Province = "ON";
$request->Estimate->ReceiverInformation->Address->Country = "CA";
$request->Estimate->ReceiverInformation->Address->PostalCode = "L5R3T8";
@$request->Estimate->ReceiverInformation->Address->PhoneNumber->CountryCode = "1";
$request->Estimate->ReceiverInformation->Address->PhoneNumber->AreaCode = "905";
$request->Estimate->ReceiverInformation->Address->PhoneNumber->Phone = "7128101";
$request->Estimate->ReceiverInformation->EmailAddress="jay@varshaawebteam.com";

$request->Estimate->PaymentInformation->BillingAccountNumber = BILLING_ACCOUNT;
$request->Estimate->PaymentInformation->RegisteredAccountNumber = REGISTERED_ACCOUNT;
$request->Estimate->PaymentInformation->PaymentType = "Sender";

$request->Estimate->ShipmentDetails->ServiceTypeCode="1";
$request->Estimate->ShipmentDetails->ShipmentDate = "2016-04-07"; //YYYY-MM_DD

$request->Estimate->ShipmentDetails->DeclaredValue="1";
$request->Estimate->ShipmentDetails->SpecialInstructions="TEST";

$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->LineNumber="1";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Pieces="2";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->HandlingUnit=1;
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->HandlingUnitType="Skid";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Description="Test Item";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Weight->Value="5100";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Weight->WeightUnit="lb";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Length->Value="48";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Length->DimensionUnit="in";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Width->Value="48";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Width->DimensionUnit="in";

$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Height->Value="48";
$request->Estimate->ShipmentDetails->LineItemDetails->LineItem->Height->DimensionUnit="in";


$request->Estimate->ShipmentDetails->AccesorialParameters->BoolValuePair->Keyword="2MEN";
$request->Estimate->ShipmentDetails->AccesorialParameters->BoolValuePair->Value="true";


$request->Estimate->ShipmentDetails->CustomerReferences->CustomerReference->Code="as";
$request->Estimate->ShipmentDetails->CustomerReferences->CustomerReference->Sequence="1";


$request->Estimate->PickupInformation->PickupDate="2016-04-06";
$request->Estimate->PickupInformation->ReadyTime="12:00";
$request->Estimate->PickupInformation->CloseTime="18:00";

$request->Estimate->PickupInformation->PickUpOptions->BoolValuePair->Keyword="DG";
$request->Estimate->PickupInformation->PickUpOptions->BoolValuePair->Value="false";

$request->Estimate->PickupInformation->OtherOption="a";
$request->Estimate->PickupInformation->StopNotes="a";
$request->Estimate->PickupInformation->DriverNotes="a";



//Execute the request and capture the response
$response = $client->GetEstimate($request);

//print_r($request);


//echo "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
//print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
//print "</pre>";
  
  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>PickUp Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:FreightGetEstimateRequest><ns1:Estimate><ns1:SenderInformation><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>5280</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>M2R3G7</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:SenderInformation><ns1:ReceiverInformation><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>5280</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L5R3T8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:ReceiverInformation><ns1:PaymentInformation><ns1:PaymentType>Sender</ns1:PaymentType><ns1:RegisteredAccountNumber>3478037</ns1:RegisteredAccountNumber><ns1:BillingAccountNumber>3478037</ns1:BillingAccountNumber></ns1:PaymentInformation><ns1:ShipmentDetails><ns1:ServiceTypeCode>1</ns1:ServiceTypeCode><ns1:ShipmentDate>2015-03-10</ns1:ShipmentDate><ns1:DeclaredValue>1</ns1:DeclaredValue><ns1:SpecialInstructions>TEST</ns1:SpecialInstructions><ns1:LineItemDetails><ns1:LineItem><ns1:LineNumber>1</ns1:LineNumber><ns1:Pieces>2</ns1:Pieces><ns1:HandlingUnit>1</ns1:HandlingUnit><ns1:HandlingUnitType>Skid</ns1:HandlingUnitType><ns1:Description>Test Item</ns1:Description><ns1:Weight><ns1:Value>5100</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:Weight><ns1:Length><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Length><ns1:Width><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Width><ns1:Height><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Height></ns1:LineItem></ns1:LineItemDetails><ns1:AccesorialParameters><ns1:BoolValuePair><ns1:Keyword>2MEN</ns1:Keyword><ns1:Value>false</ns1:Value></ns1:BoolValuePair></ns1:AccesorialParameters></ns1:ShipmentDetails></ns1:Estimate></ns1:FreightGetEstimateRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>



**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>PickUp Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetEstimateResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><TariffCode>PURO2015</TariffCode><DiscountPoint>70</DiscountPoint><TransitDays>0</TransitDays><EstimatedDeliveryDate>2015-03-11</EstimatedDeliveryDate><TotalPrice>300.87</TotalPrice><LineItemDetails><LineItem><LineNumber>1</LineNumber><Pieces>2</Pieces><HandlingUnit>1</HandlingUnit><HandlingUnitType i:nil="true"/><Description>1 Skids OF FREIGHT</Description><Weight><Value>5100</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass>100</FreightClass><Length><Value>48</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>48</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>48</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>17.19</BasePrice><Charge>876.69</Charge></LineItem><LineItem><LineNumber>2</LineNumber><Pieces>0</Pieces><HandlingUnit>0</HandlingUnit><HandlingUnitType i:nil="true"/><Description>DISCOUNT: -70%</Description><Weight><Value>0</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass/><Length><Value>0</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>0</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>0</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>0</BasePrice><Charge>-613.68</Charge></LineItem><LineItem><LineNumber>5</LineNumber><Pieces>0</Pieces><HandlingUnit>0</HandlingUnit><HandlingUnitType i:nil="true"/><Description>48"x48"x48"x1 = 640Lbs</Description><Weight><Value>0</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass/><Length><Value>0</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>0</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>0</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>0</BasePrice><Charge>0</Charge></LineItem></LineItemDetails><AccessorialDetails><AccessorialItem><Code>VALUE</Code><Description>DECLARED VALUE/VAL DÉCLARÉE</Description><Charge>3.25</Charge></AccessorialItem></AccessorialDetails><ShipmentTaxes><Tax><Amount>34.61</Amount><Type>GST</Type><Description>GST / HST TAX = 13%</Description></Tax></ShipmentTaxes></GetEstimateResponse></s:Body></s:Envelope>

  
**/

//Display the services and associated rules for this shipment
echo "<pre>\n"; 
print_r(get_object_vars($response));

/**
  * EXPECTED RESULTS from PWS
(
	[ResponseInformation] => [TariffCode] => PURO2015 [DiscountPoint] => 70 [TransitDays] => 0 [EstimatedDeliveryDate] => 2015-03-11 [TotalPrice] => 300.87 [LineItemDetails] => stdClass Object ( [LineItem] => Array ( [0] => stdClass Object ( [LineNumber] => 1 [Pieces] => 2 [HandlingUnit] => 1 [HandlingUnitType] => [Description] => 1 Skids OF FREIGHT [Weight] => stdClass Object ( [Value] => 5100 [WeightUnit] => lb ) [FreightClass] => 100 [Length] => stdClass Object ( [Value] => 48 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 48 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 48 [DimensionUnit] => in ) [BasePrice] => 17.19 [Charge] => 876.69 ) [1] => stdClass Object ( [LineNumber] => 2 [Pieces] => 0 [HandlingUnit] => 0 [HandlingUnitType] => [Description] => DISCOUNT: -70% [Weight] => stdClass Object ( [Value] => 0 [WeightUnit] => lb ) [FreightClass] => [Length] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [BasePrice] => 0 [Charge] => -613.68 ) [2] => stdClass Object ( [LineNumber] => 5 [Pieces] => 0 [HandlingUnit] => 0 [HandlingUnitType] => [Description] => 48"x48"x48"x1 = 640Lbs [Weight] => stdClass Object ( [Value] => 0 [WeightUnit] => lb ) [FreightClass] => [Length] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [BasePrice] => 0 [Charge] => 0 ) ) ) [AccessorialDetails] => stdClass Object ( [AccessorialItem] => stdClass Object ( [Code] => VALUE [Description] => DECLARED VALUE/VAL DÉCLARÉE [Charge] => 3.25 ) ) [ShipmentTaxes] => stdClass Object ( [Tax] => stdClass Object ( [Amount] => 34.61 [Type] => GST [Description] => GST / HST TAX = 13% ) )
	
)
**/

?>
