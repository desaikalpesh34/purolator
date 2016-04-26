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
require(__DIR__ . '/../config/main.php');
require(__DIR__ .'/base.php');

function createPWSSOAPClient()
{	
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( WSDL_URL."FreightShippingService.wsdl", 
                            array	(
					'trace'			=>	true,
					'location' => "https://devwebservices.purolator.com/PWS/V1/FreightShipping/FreightShippingService.asmx",
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
                                        'RequestReference'  =>  'Freight Shipping Example',
                                        'UserToken'         =>  USER_TOKEN
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
$request = new FreightShippingService();
//8805743898
//8805743906
//8805743914


if (!isset($request->Shipment)) 
    $request->Shipment = new stdClass();
  

$request->Shipment->SenderInformation->Address->Name = "PWS User";
$request->Shipment->SenderInformation->Address->Company = "Company";
$request->Shipment->SenderInformation->Address->Department = "Department";
$request->Shipment->SenderInformation->Address->StreetNumber = "5280";
$request->Shipment->SenderInformation->Address->StreetSuffix = "";
$request->Shipment->SenderInformation->Address->StreetName ="Solar";
$request->Shipment->SenderInformation->Address->StreetType ="Drive";
$request->Shipment->SenderInformation->Address->StreetDirection = "";
$request->Shipment->SenderInformation->Address->Suite = "";
$request->Shipment->SenderInformation->Address->Floor = "";
$request->Shipment->SenderInformation->Address->StreetAddress2 = "";
$request->Shipment->SenderInformation->Address->StreetAddress3 = "";
$request->Shipment->SenderInformation->Address->City = "Mississauga";
$request->Shipment->SenderInformation->Address->Province = "ON";
$request->Shipment->SenderInformation->Address->Country = "CA";
$request->Shipment->SenderInformation->Address->PostalCode = "L4W5M8";
$request->Shipment->SenderInformation->Address->PhoneNumber->CountryCode = "1";
$request->Shipment->SenderInformation->Address->PhoneNumber->AreaCode = "905";
$request->Shipment->SenderInformation->Address->PhoneNumber->Phone = "7128101";
$request->Shipment->SenderInformation->EmailAddress="kalpesh@varshaawebteam.com";


$request->Shipment->ReceiverInformation->Address->Name = "PWS User";
$request->Shipment->ReceiverInformation->Address->Company = "Company";
$request->Shipment->ReceiverInformation->Address->Department = "Department";
$request->Shipment->ReceiverInformation->Address->StreetNumber = "5280";
$request->Shipment->ReceiverInformation->Address->StreetSuffix = "";
$request->Shipment->ReceiverInformation->Address->StreetName ="Solar";
$request->Shipment->ReceiverInformation->Address->StreetType ="Drive";
$request->Shipment->ReceiverInformation->Address->StreetDirection = "";
$request->Shipment->ReceiverInformation->Address->Suite = "";
$request->Shipment->ReceiverInformation->Address->Floor = "";
$request->Shipment->ReceiverInformation->Address->StreetAddress2 = "";
$request->Shipment->ReceiverInformation->Address->StreetAddress3 = "";
$request->Shipment->ReceiverInformation->Address->City = "Mississauga";
$request->Shipment->ReceiverInformation->Address->Province = "ON";
$request->Shipment->ReceiverInformation->Address->Country = "CA";
$request->Shipment->ReceiverInformation->Address->PostalCode = "L5R3T8";
$request->Shipment->ReceiverInformation->Address->PhoneNumber->CountryCode = "1";
$request->Shipment->ReceiverInformation->Address->PhoneNumber->AreaCode = "905";
$request->Shipment->ReceiverInformation->Address->PhoneNumber->Phone = "7128101";
$request->Shipment->ReceiverInformation->EmailAddress="jay@varshaawebteam.com";


$request->Shipment->PaymentInformation->BillingAccountNumber = BILLING_ACCOUNT;
$request->Shipment->PaymentInformation->RegisteredAccountNumber = REGISTERED_ACCOUNT;
$request->Shipment->PaymentInformation->PaymentType = "Sender";


$request->Shipment->ShipmentDetails->ServiceTypeCode="1";
$request->Shipment->ShipmentDetails->ShipmentDate = "2016-04-07";

$request->Shipment->ShipmentDetails->DeclaredValue="1";
$request->Shipment->ShipmentDetails->SpecialInstructions="TEST";

$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->LineNumber="1";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Pieces="2";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->HandlingUnit=1;
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->HandlingUnitType="Skid";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Description="Test Item";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Weight->Value="5100";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Weight->WeightUnit="lb";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Length->Value="48";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Length->DimensionUnit="in";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Width->Value="48";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Width->DimensionUnit="in";

$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Height->Value="48";
$request->Shipment->ShipmentDetails->LineItemDetails->LineItem->Height->DimensionUnit="in";


$request->Shipment->ShipmentDetails->AccesorialParameters->BoolValuePair->Keyword="2MEN";
$request->Shipment->ShipmentDetails->AccesorialParameters->BoolValuePair->Value="true";


$request->Shipment->ShipmentDetails->CustomerReferences->CustomerReference->Code="as";
$request->Shipment->ShipmentDetails->CustomerReferences->CustomerReference->Sequence="1";


$request->Shipment->AppointmentFlag = "true";
$request->Shipment->AppointmentDate="2016-04-12";
$request->Shipment->AppointmentStartTime="1200";
$request->Shipment->AppointmentEndTime="1700";

$request->Shipment->PickupFlag="true";

//$request->PickUpInformation->PickupDate="YOUR PICKUP DATE";
$request->Shipment->PickupInformation->PickupDate="2016-04-11";
$request->Shipment->PickupInformation->ReadyTime="12:00";
$request->Shipment->PickupInformation->CloseTime="18:00";

$request->Shipment->PickupInformation->PickUpOptions->BoolValuePair->Keyword="DG";
$request->Shipment->PickupInformation->PickUpOptions->BoolValuePair->Value="false";

$request->Shipment->PickupInformation->OtherOption="a";
$request->Shipment->PickupInformation->StopNotes="a";
$request->Shipment->PickupInformation->DriverNotes="a";


$request->Shipment->AlertInformation->AlertDetails->AlertDetail->EmailAddress="kalpesh@varshaawebteam.com";
$request->Shipment->AlertInformation->AlertDetails->AlertDetail->Type="POD";


//Execute the request and capture the response
$response = $client->CreateShipment($request);


  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Freight Shipping Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:CreateShipmentRequest><ns1:Shipment><ns1:SenderInformation><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>5280</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>M2R3G7</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:SenderInformation><ns1:ReceiverInformation><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>5280</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L5R3T8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:ReceiverInformation><ns1:PaymentInformation><ns1:PaymentType>Sender</ns1:PaymentType><ns1:RegisteredAccountNumber>3478037</ns1:RegisteredAccountNumber><ns1:BillingAccountNumber>3478037</ns1:BillingAccountNumber></ns1:PaymentInformation><ns1:ShipmentDetails><ns1:ServiceTypeCode>1</ns1:ServiceTypeCode><ns1:ShipmentDate>2015-03-11</ns1:ShipmentDate><ns1:DeclaredValue>1</ns1:DeclaredValue><ns1:SpecialInstructions>TEST</ns1:SpecialInstructions><ns1:LineItemDetails><ns1:LineItem><ns1:LineNumber>1</ns1:LineNumber><ns1:Pieces>2</ns1:Pieces><ns1:HandlingUnit>1</ns1:HandlingUnit><ns1:HandlingUnitType>Skid</ns1:HandlingUnitType><ns1:Description>Test Item</ns1:Description><ns1:Weight><ns1:Value>5100</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:Weight><ns1:Length><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Length><ns1:Width><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Width><ns1:Height><ns1:Value>48</ns1:Value><ns1:DimensionUnit>in</ns1:DimensionUnit></ns1:Height></ns1:LineItem></ns1:LineItemDetails><ns1:AccesorialParameters><ns1:BoolValuePair><ns1:Keyword>2MEN</ns1:Keyword><ns1:Value>false</ns1:Value></ns1:BoolValuePair></ns1:AccesorialParameters><ns1:CustomerReferences><ns1:CustomerReference><ns1:Sequence>1</ns1:Sequence><ns1:Code>as</ns1:Code></ns1:CustomerReference></ns1:CustomerReferences></ns1:ShipmentDetails><ns1:AppointmentFlag>false</ns1:AppointmentFlag><ns1:AppointmentDate>2015-03-12</ns1:AppointmentDate><ns1:AppointmentStartTime>1200</ns1:AppointmentStartTime><ns1:AppointmentEndTime>1700</ns1:AppointmentEndTime><ns1:PickupFlag>false</ns1:PickupFlag><ns1:PickupInformation><ns1:PickupDate>2015-03-11</ns1:PickupDate><ns1:ReadyTime>12:00</ns1:ReadyTime><ns1:CloseTime>18:00</ns1:CloseTime><ns1:PickUpOptions><ns1:BoolValuePair><ns1:Keyword>DG</ns1:Keyword><ns1:Value>false</ns1:Value></ns1:BoolValuePair></ns1:PickUpOptions><ns1:OtherOption>a</ns1:OtherOption><ns1:StopNotes>a</ns1:StopNotes><ns1:DriverNotes>a</ns1:DriverNotes></ns1:PickupInformation><ns1:AlertInformation><ns1:AlertDetails><ns1:AlertDetail><ns1:Type>POD</ns1:Type><ns1:EmailAddress>richard.flikkema@innovapost.com</ns1:EmailAddress></ns1:AlertDetail></ns1:AlertDetails></ns1:AlertInformation></ns1:Shipment></ns1:CreateShipmentRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>


**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Freight Shipping Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><CreateShipmentResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><ProNumber>8805148387</ProNumber><PickupNumber>0</PickupNumber><TariffCode>PURO2015</TariffCode><DiscountPoint>70</DiscountPoint><TransitDays>0</TransitDays><EstimatedDeliveryDate>2015-03-12</EstimatedDeliveryDate><OriginalTerminalCode>TOR</OriginalTerminalCode><DestinationTerminalCode>TOR</DestinationTerminalCode><DestinationUniCode>55</DestinationUniCode><TotalPrice>300.87</TotalPrice><ShipmentPINs><PIN><Value>8805148387</Value></PIN></ShipmentPINs><LineItemDetails><LineItem><LineNumber>1</LineNumber><Pieces>2</Pieces><HandlingUnit>1</HandlingUnit><HandlingUnitType i:nil="true"/><Description>1 Skids Test Item</Description><Weight><Value>5100</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass>100</FreightClass><Length><Value>48</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>48</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>48</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>17.19</BasePrice><Charge>876.69</Charge></LineItem><LineItem><LineNumber>2</LineNumber><Pieces>0</Pieces><HandlingUnit>0</HandlingUnit><HandlingUnitType i:nil="true"/><Description>TEST</Description><Weight><Value>0</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass/><Length><Value>0</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>0</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>0</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>0</BasePrice><Charge>0</Charge></LineItem><LineItem><LineNumber>3</LineNumber><Pieces>0</Pieces><HandlingUnit>0</HandlingUnit><HandlingUnitType i:nil="true"/><Description>DISCOUNT: -70%</Description><Weight><Value>0</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass/><Length><Value>0</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>0</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>0</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>0</BasePrice><Charge>-613.68</Charge></LineItem><LineItem><LineNumber>6</LineNumber><Pieces>0</Pieces><HandlingUnit>0</HandlingUnit><HandlingUnitType i:nil="true"/><Description>48"x48"x48"x1 = 640Lbs</Description><Weight><Value>0</Value><WeightUnit>lb</WeightUnit></Weight><FreightClass/><Length><Value>0</Value><DimensionUnit>in</DimensionUnit></Length><Width><Value>0</Value><DimensionUnit>in</DimensionUnit></Width><Height><Value>0</Value><DimensionUnit>in</DimensionUnit></Height><BasePrice>0</BasePrice><Charge>0</Charge></LineItem></LineItemDetails><AccessorialDetails><AccessorialItem><Code>VALUE</Code><Description>DECLARED VALUE/VAL DÉCLARÉE</Description><Charge>3.25</Charge></AccessorialItem></AccessorialDetails><ShipmentTaxes><Tax><Amount>34.61</Amount><Type>GST</Type><Description>GST / HST TAX = 13%</Description></Tax></ShipmentTaxes></CreateShipmentResponse></s:Body></s:Envelope>
  
**/

//Display the services and associated rules for this shipment
echo '<pre>';
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
	[ResponseInformation] => [ProNumber] => 8805148387 [PickupNumber] => 0 [TariffCode] => PURO2015 [DiscountPoint] => 70 [TransitDays] => 0 [EstimatedDeliveryDate] => 2015-03-12 [OriginalTerminalCode] => TOR [DestinationTerminalCode] => TOR [DestinationUniCode] => 55 [TotalPrice] => 300.87 [ShipmentPINs] => stdClass Object ( [PIN] => stdClass Object ( [Value] => 8805148387 ) ) [LineItemDetails] => stdClass Object ( [LineItem] => Array ( [0] => stdClass Object ( [LineNumber] => 1 [Pieces] => 2 [HandlingUnit] => 1 [HandlingUnitType] => [Description] => 1 Skids Test Item [Weight] => stdClass Object ( [Value] => 5100 [WeightUnit] => lb ) [FreightClass] => 100 [Length] => stdClass Object ( [Value] => 48 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 48 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 48 [DimensionUnit] => in ) [BasePrice] => 17.19 [Charge] => 876.69 ) [1] => stdClass Object ( [LineNumber] => 2 [Pieces] => 0 [HandlingUnit] => 0 [HandlingUnitType] => [Description] => TEST [Weight] => stdClass Object ( [Value] => 0 [WeightUnit] => lb ) [FreightClass] => [Length] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [BasePrice] => 0 [Charge] => 0 ) [2] => stdClass Object ( [LineNumber] => 3 [Pieces] => 0 [HandlingUnit] => 0 [HandlingUnitType] => [Description] => DISCOUNT: -70% [Weight] => stdClass Object ( [Value] => 0 [WeightUnit] => lb ) [FreightClass] => [Length] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [BasePrice] => 0 [Charge] => -613.68 ) [3] => stdClass Object ( [LineNumber] => 6 [Pieces] => 0 [HandlingUnit] => 0 [HandlingUnitType] => [Description] => 48"x48"x48"x1 = 640Lbs [Weight] => stdClass Object ( [Value] => 0 [WeightUnit] => lb ) [FreightClass] => [Length] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Width] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [Height] => stdClass Object ( [Value] => 0 [DimensionUnit] => in ) [BasePrice] => 0 [Charge] => 0 ) ) ) [AccessorialDetails] => stdClass Object ( [AccessorialItem] => stdClass Object ( [Code] => VALUE [Description] => DECLARED VALUE/VAL DÉCLARÉE [Charge] => 3.25 ) ) [ShipmentTaxes] => stdClass Object ( [Tax] => stdClass Object ( [Amount] => 34.61 [Type] => GST [Description] => GST / HST TAX = 13% ) )
)
**/

?>
