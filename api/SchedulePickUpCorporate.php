<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com
  
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
define("BILLING_ACCOUNT", "9999999999");
define("REGISTERED_ACCOUNT", "9999999999");

function createPWSSOAPClient()
{	
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( "./wsdl/PickUpService.wsdl", 
                            array	(
					'trace'			=>	true,
					'location'	=>	"https://devwebservices.purolator.com/EWS/V1/PickUp/PickUpService.asmx",				    
					'uri'				=>	"http://purolator.com/pws/datatypes/v1",
					'login'			=>	PRODUCTION_KEY,
					'password'	=>	PRODUCTION_PASS
                                  )
                          );
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.2',
                                        'Language'          =>  'en',
                                        'GroupID'           =>  'xxx',
                                        'RequestReference'  =>  'Rating Example'
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

$request->BillingAccountNumber = BILLING_ACCOUNT;
$request->PartnerID = "";
$request->PickupInstruction->Date = "2010-05-13";
$request->PickupInstruction->AnyTimeAfter = "1200";
$request->PickupInstruction->UntilTime = "1500";

$request->PickupInstruction->TotalWeight->Value = "1";
$request->PickupInstruction->TotalWeight->WeightUnit = "kg";
$request->PickupInstruction->TotalPieces = "1";
$request->PickupInstruction->BoxIndicator = "";
$request->PickupInstruction->PickUpLocation = "BackDoor";
$request->PickupInstruction->AdditionalInstructions = "";
$request->PickupInstruction->SupplyRequestCodes->SupplyRequestCode = "PuroletterExpressEnvelope";												      

$request->PickupInstruction->LoadingDockAvailable=false;
$request->PickupInstruction->TrailerAccessible=false;
$request->PickupInstruction->ShipmentOnSkids=false;
$request->PickupInstruction->NumberOfSkids=0;

$request->Address->Name = "PWS User";
$request->Address->Company = "Company";
$request->Address->Department = "Department";
$request->Address->StreetNumber = "5280";
$request->Address->StreetSuffix = "";
$request->Address->StreetName ="Solar";
$request->Address->StreetType ="Drive";
$request->Address->StreetDirection = "";
$request->Address->Suite = "";
$request->Address->Floor = "";
$request->Address->StreetAddress2 = "";
$request->Address->StreetAddress3 = "";
$request->Address->City = "Mississauga";
$request->Address->Province = "ON";
$request->Address->Country = "CA";
$request->Address->PostalCode = "L4W5M8";
$request->Address->PhoneNumber->CountryCode = "1";
$request->Address->PhoneNumber->AreaCode = "905";
$request->Address->PhoneNumber->Phone = "7128101";
$request->NotificationEmails->NotificationEmail="your_email@email.com";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->DestinationCode="DOM";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->ModeOfTransport= "Ground";//Express, Ground, Express/Ground.
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->TotalPieces="70";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->TotalWeight->Value = "100";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->TotalWeight->WeightUnit = "kg";

//Execute the request and capture the response
$response = $client->SchedulePickUp($request);

print "<pre>\n"; 
print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
print "</pre>";
  
  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:SchedulePickUpRequest><ns1:BillingAccountNumber>9999999999</ns1:BillingAccountNumber><ns1:PartnerID></ns1:PartnerID><ns1:PickupInstruction><ns1:Date>2009-08-07</ns1:Date><ns1:AnyTimeAfter>1200</ns1:AnyTimeAfter><ns1:UntilTime>1400</ns1:UntilTime><ns1:TotalWeight><ns1:Value>1</ns1:Value><ns1:WeightUnit>kg</ns1:WeightUnit></ns1:TotalWeight><ns1:TotalPieces>1</ns1:TotalPieces><ns1:PickUpLocation>BackDoor</ns1:PickUpLocation><ns1:AdditionalInstructions></ns1:AdditionalInstructions><ns1:SupplyRequestCodes><ns1:SupplyRequestCode>PurolatorExpressBox</ns1:SupplyRequestCode></ns1:SupplyRequestCodes><ns1:TrailerAccessible>false</ns1:TrailerAccessible><ns1:LoadingDockAvailable>false</ns1:LoadingDockAvailable><ns1:ShipmentOnSkids>false</ns1:ShipmentOnSkids><ns1:NumberOfSkids>0</ns1:NumberOfSkids></ns1:PickupInstruction><ns1:Address><ns1:Name>PWS User</ns1:Name><ns1:Company>Company</ns1:Company><ns1:Department>Department</ns1:Department><ns1:StreetNumber>52805</ns1:StreetNumber><ns1:StreetSuffix></ns1:StreetSuffix><ns1:StreetName>Solar</ns1:StreetName><ns1:StreetType>Drive</ns1:StreetType><ns1:StreetDirection></ns1:StreetDirection><ns1:Suite></ns1:Suite><ns1:Floor></ns1:Floor><ns1:StreetAddress2></ns1:StreetAddress2><ns1:StreetAddress3></ns1:StreetAddress3><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>7128101</ns1:Phone></ns1:PhoneNumber></ns1:Address><ns1:ShipmentSummary><ns1:ShipmentSummaryDetails><ns1:ShipmentSummaryDetail><ns1:DestinationCode>DOM</ns1:DestinationCode><ns1:TotalPieces>70</ns1:TotalPieces><ns1:TotalWeight><ns1:Value>100</ns1:Value><ns1:WeightUnit>kg</ns1:WeightUnit></ns1:TotalWeight></ns1:ShipmentSummaryDetail></ns1:ShipmentSummaryDetails></ns1:ShipmentSummary><ns1:NotificationEmails><ns1:NotificationEmail>your_email@email.com</ns1:NotificationEmail></ns1:NotificationEmails></ns1:SchedulePickUpRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>

**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><SchedulePickUpResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><PickUpConfirmationNumber>01365863</PickUpConfirmationNumber></SchedulePickUpResponse></s:Body></s:Envelope>
  
**/

//Display the services and associated rules for this shipment
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
	[ResponseInformation] => [PickUpConfirmationNumber] => 01365863
)
**/

?>
