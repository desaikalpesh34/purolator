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
    Display the tracking results for a 1 piece shipment
*********************************************************************************/ 
//Create a SOAP Client for Example 01
$client = createPWSSOAPClient();

//Specify the PIN to obtain tracking details for
$request->PINs->PIN->Value = "m123";

//Execute the request and capture the response
$response = $client->TrackPackagesByPin($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:TrackPackagesByPinRequest><ns1:PINs><ns1:PIN><ns1:Value>m123</ns1:Value></ns1:PIN></ns1:PINs></ns1:TrackPackagesByPinRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/
 
/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><TrackPackagesByPinResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><TrackingInformationList><TrackingInformation><PIN><Value>M123</Value></PIN><Scans><Scan><ScanType>Other</ScanType><PIN><Value>M123</Value></PIN><Depot><Name>MONTREAL SORT CTR/CTR TRIE, PQ</Name></Depot><ScanDate>2004-01-13</ScanDate><ScanTime>172300</ScanTime><Description>New Tracking Number Assigned -</Description><Comment/><SummaryScanIndicator>false</SummaryScanIndicator></Scan><Scan><ScanType>Other</ScanType><PIN><Value>M123</Value></PIN><Depot><Name>MONTREAL SORT CTR/CTR TRIE, PQ</Name></Depot><ScanDate>2004-01-13</ScanDate><ScanTime>172300</ScanTime><Description>New Tracking Number Assigned -</Description><Comment/><SummaryScanIndicator>false</SummaryScanIndicator></Scan></Scans><ResponseInformation i:nil="true"/></TrackingInformation></TrackingInformationList></TrackPackagesByPinResponse></s:Body></s:Envelope>
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
                )

            [InformationalMessages] => 
        )

    [TrackingInformationList] => stdClass Object
        (
            [TrackingInformation] => stdClass Object
                (
                    [PIN] => stdClass Object
                        (
                            [Value] => M123
                        )

                    [Scans] => stdClass Object
                        (
                            [Scan] => Array
                                (
                                    [0] => stdClass Object
                                        (
                                            [ScanType] => Other
                                            [PIN] => stdClass Object
                                                (
                                                    [Value] => M123
                                                )

                                            [Depot] => stdClass Object
                                                (
                                                    [Name] => MONTREAL SORT CTR/CTR TRIE, PQ
                                                )

                                            [ScanDate] => 2004-01-13
                                            [ScanTime] => 172300
                                            [Description] => New Tracking Number Assigned -
                                            [Comment] => 
                                            [SummaryScanIndicator] => 
                                        )

                                    [1] => stdClass Object
                                        (
                                            [ScanType] => Other
                                            [PIN] => stdClass Object
                                                (
                                                    [Value] => M123
                                                )

                                            [Depot] => stdClass Object
                                                (
                                                    [Name] => MONTREAL SORT CTR/CTR TRIE, PQ
                                                )

                                            [ScanDate] => 2004-01-13
                                            [ScanTime] => 172300
                                            [Description] => New Tracking Number Assigned -
                                            [Comment] => 
                                            [SummaryScanIndicator] => 
                                        )

                                )

                        )

                    [ResponseInformation] => 
                )

        )

)

**/
