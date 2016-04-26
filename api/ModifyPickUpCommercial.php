<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com                
  
  Requires    : PHP SOAP extension enabled
              : Local copy of the PickUp Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Services Options Web Service.
*********************************************************************************/ 

//Define the Production (or development) Key and Password
define("PRODUCTION_KEY", "YOUR_PRODUCTION_KEY_HERE");
define("PRODUCTION_PASS", "YOUR_PRODUCTION_PASS_HERE");
define("USER_TOKEN", "YOUR_USER_TOKEN_HERE");


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
                                        'RequestReference'  =>  'Rating Example',
                                        'UserToken'         =>  USER_TOKEN
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
	Modify PickUp Example(s)
	EXAMPLE 01:    
*********************************************************************************/ 

//Create a SOAP Client for this Example
$client = createPWSSOAPClient();
            
$request->BillingAccountNumber = BILLING_ACCOUNT;
$request->ConfirmationNumber = "your confirmation number";
$request->ModifyPickupInstruction->UntilTime = "1800";
$request->ModifyPickupInstruction->PickUpLocation = "BackDoor";
$request->ModifyPickupInstruction->SupplyRequestCodes->SupplyRequestCode = "PuroletterExpressEnvelope";												      
$request->ModifyPickupInstruction->LoadingDockAvailable=false;
$request->ModifyPickupInstruction->TrailerAccessible=false;
$request->ModifyPickupInstruction->ShipmentOnSkids=false;
$request->ModifyPickupInstruction->NumberOfSkids=0;
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->DestinationCode="DOM";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->TotalPieces="2";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->TotalWeight->Value = "7";
$request->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail->TotalWeight->WeightUnit = "kg";

//Execute the request and capture the response
$response = $client->ModifyPickUp($request);

print "<pre>\n"; 
print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
print "</pre>";
  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:ModifyPickUpRequest><ns1:BillingAccountNumber>9999999999</ns1:BillingAccountNumber><ns1:ConfirmationNumber>01365850</ns1:ConfirmationNumber><ns1:ModifyPickupInstruction><ns1:UntilTime>1800</ns1:UntilTime><ns1:PickUpLocation>BackDoor</ns1:PickUpLocation><ns1:SupplyRequestCodes><ns1:SupplyRequestCode>PuroletterExpressEnvelope</ns1:SupplyRequestCode></ns1:SupplyRequestCodes><ns1:TrailerAccessible>false</ns1:TrailerAccessible><ns1:LoadingDockAvailable>false</ns1:LoadingDockAvailable><ns1:ShipmentOnSkids>false</ns1:ShipmentOnSkids><ns1:NumberOfSkids>0</ns1:NumberOfSkids></ns1:ModifyPickupInstruction><ns1:ShipmentSummary><ns1:ShipmentSummaryDetails><ns1:ShipmentSummaryDetail><ns1:DestinationCode>DOM</ns1:DestinationCode><ns1:TotalPieces>2</ns1:TotalPieces><ns1:TotalWeight><ns1:Value>7</ns1:Value><ns1:WeightUnit>kg</ns1:WeightUnit></ns1:TotalWeight></ns1:ShipmentSummaryDetail></ns1:ShipmentSummaryDetails></ns1:ShipmentSummary></ns1:ModifyPickUpRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><ModifyPickUpResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><PickUpConfirmationNumber>01365850</PickUpConfirmationNumber></ModifyPickUpResponse></s:Body></s:Envelope>
**/

//Display the response
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
	stdClass Object 
	( 
		[ResponseInformation] => 
		[PickUpConfirmationNumber] => 01365850 
	) 

	
)
**/

?>

