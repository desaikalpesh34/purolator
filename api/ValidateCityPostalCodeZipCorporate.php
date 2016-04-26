<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Validate City Postal Code/Zip Web Service.
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
  $client = new SoapClient( "./wsdl/serviceavailabilityservice.wsdl", 
                            array	(
                                    'trace'			=>	true,
                                    'location'	=>	"https://webservices.purolator.com/PWS/V1/ServiceAvailability/ServiceAvailabilityService.asmx",
                                    'uri'				=>	"http://purolator.com/pws/datatypes/v1",
                                    'login'			=>	PRODUCTION_KEY,
                                    'password'	=>	PRODUCTION_PASS
                                  )
                          );
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.3',
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
  ValidateCityPostalCodeZip Example(s)
    EXAMPLE 01:
    Determine if Postal Code V5E4H9 is valid
*********************************************************************************/ 

//Create a SOAP Client for Example 02
$client = createPWSSOAPClient();

//Populate the Origin Information
$request->Addresses->ShortAddress->City = "Burnaby";
$request->Addresses->ShortAddress->Province = "BC";
$request->Addresses->ShortAddress->Country = "CA";
$request->Addresses->ShortAddress->PostalCode = "V5E4H9";    

//Execute the request and capture the response
$response = $client->ValidateCityPostalCodeZip($request);

/** 
  * SOAP Request Envelope (Request sent to Web Service)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:ValidateCityPostalCodeZipRequest><ns1:Addresses><ns1:ShortAddress><ns1:City>Burnaby</ns1:City><ns1:Province>BC</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>V5E4H9</ns1:PostalCode></ns1:ShortAddress></ns1:Addresses></ns1:ValidateCityPostalCodeZipRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/
 
/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><ValidateCityPostalCodeZipResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><SuggestedAddresses><SuggestedAddress><Address><City>Burnaby</City><Province>BC</Province><Country>CA</Country><PostalCode>V5E4H9</PostalCode></Address><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation></SuggestedAddress></SuggestedAddresses></ValidateCityPostalCodeZipResponse></s:Body></s:Envelope>
**/
 
//Display the services and associated rules for this shipment
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

    [SuggestedAddresses] => stdClass Object
        (
            [SuggestedAddress] => stdClass Object
                (
                    [Address] => stdClass Object
                        (
                            [City] => Burnaby
                            [Province] => BC
                            [Country] => CA
                            [PostalCode] => V5E4H9
                        )

                    [ResponseInformation] => stdClass Object
                        (
                            [Errors] => stdClass Object
                                (
                                )

                            [InformationalMessages] => 
                        )

                )

        )

)

**/

