<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Tracking Web Service.
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
  $client = new SoapClient( "./wsdl/trackingservice.wsdl", 
                            array	(
                                    'trace'			=>	true,
                                    'location'	=>	"https://webservices.purolator.com/PWS/V1/Tracking/TrackingService.asmx",
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
  TrackPackageByPin Example(s)
    EXAMPLE 01:
    Display the tracking results for a 1 piece shipment, searching by reference
    This is expected to fail because the reference number we are searching for
    is not unique within the information we provide to the service
*********************************************************************************/ 
//Create a SOAP Client for Example 01
$client = createPWSSOAPClient();

//Specify the reference to search for
$request->TrackPackageByReferenceSearchCriteria->Reference = "RMA125";
$request->TrackPackageByReferenceSearchCriteria->BillingAccountNumber = BILLING_ACCOUNT;
$request->TrackPackageByReferenceSearchCriteria->ShipmentFromDate = "2009-04-22";
$request->TrackPackageByReferenceSearchCriteria->ShipmentToDate = "2009-04-22";

//Execute the request and capture the response
$response = $client->TrackPackagesByReference($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:TrackPackagesByReferenceRequest><ns1:TrackPackageByReferenceSearchCriteria><ns1:Reference>RMA125</ns1:Reference><ns1:BillingAccountNumber>0554632</ns1:BillingAccountNumber><ns1:ShipmentFromDate>2009-04-22</ns1:ShipmentFromDate><ns1:ShipmentToDate>2009-04-22</ns1:ShipmentToDate></ns1:TrackPackageByReferenceSearchCriteria></ns1:TrackPackagesByReferenceRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/
  
/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><TrackPackagesByReferenceResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors><Error><Code>2800002</Code><Description>The search criteria provided results in more than one PIN returned.  Please refine the search criteria.</Description><AdditionalInformation>Tracking Error</AdditionalInformation></Error></Errors><InformationalMessages i:nil="true"/></ResponseInformation><TrackingInformationList i:nil="true"/></TrackPackagesByReferenceResponse></s:Body></s:Envelope>
**/
 
//Determine the services and associated charges for this shipment
print_r($response);

/**
  * EXPECTED RESULTS from PWS
stdClass Object
(
    [ResponseInformation] => stdClass Object
        (
            [Errors] => stdClass Object
                (
                    [Error] => stdClass Object
                        (
                            [Code] => 2800002
                            [Description] => The search criteria provided results in more than one PIN returned.  Please refine the search criteria.
                            [AdditionalInformation] => Tracking Error
                        )

                )

            [InformationalMessages] => 
        )

    [TrackingInformationList] => 
)**/
