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
define("USER_TOKEN", "YOUR_USER_TOKEN_HERE");

//Define your pickup confirmation number that you want voided.
define("YOUR_PICKUP_CONFIRMATION_NUMBER","01365850");


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
  Void Pick Up Example(s)
    EXAMPLE 01:    
*********************************************************************************/ 

//Create a SOAP Client for Example 02
$client = createPWSSOAPClient();

$request->PickUpConfirmationNumber = YOUR_PICKUP_CONFIRMATION_NUMBER;
$response = $client->VoidPickUp($request);
	print "<pre>\n"; 
	print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
	print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
	print "</pre>";
    
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:VoidPickUpRequest><ns1:PickUpConfirmationNumber>12312312</ns1:PickUpConfirmationNumber></ns1:VoidPickUpRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><VoidPickUpResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><PickUpVoided>true</PickUpVoided></VoidPickUpResponse></s:Body></s:Envelope>
**/
//Display the response for this PickUp Service
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
    [ResponseInformation] => [PickUpVoided] => 1   
)
**/

?>

