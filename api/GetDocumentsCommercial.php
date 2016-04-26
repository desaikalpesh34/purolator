<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Get Documents Web Service.
*********************************************************************************/ 

//Define the Production (or development) Key and Password
define("PRODUCTION_KEY", "YOUR_PRODUCTION_KEY_HERE");
define("PRODUCTION_PASS", "YOUR_PRODUCTION_PASS_HERE");
//Define the Billing account and the account that is registered with PWS
define("BILLING_ACCOUNT", "YOUR_ACCOUNT_HERE");
define("REGISTERED_ACCOUNT", "YOUR_ACCOUNT_HERE");
define("USER_TOKEN", "YOUR_USER_TOKEN_HERE");

function createPWSSOAPClient()
{
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( "./wsdl/shippingdocumentsservice.wsdl", 
                            array	(
                                    'trace'			=>	true,
                                    'location'	=>	"https://webservices.purolator.com/PWS/V1/ShippingDocuments/ShippingDocumentsService.asmx",
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
                                        'RequestReference'  =>  'Example Code',
                                        'UserToken'         =>  USER_TOKEN
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
  Get Documents Example(s)
    EXAMPLE 01:
    Returns the URL to download your shipping documents
*********************************************************************************/ 
//Create a SOAP Client for Example 01
$client = createPWSSOAPClient();

$request->DocumentCriterium->DocumentCriteria->PIN->Value = "329015010179";
$request->DocumentCriterium->DocumentCriteria->DocumentTypes->DocumentType = "DomesticBillOfLading";

//Execute the request and capture the response
$response = $client->GetDocuments($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Example Code</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetDocumentsRequest><ns1:DocumentCriterium><ns1:DocumentCriteria><ns1:PIN><ns1:Value>329015010179</ns1:Value></ns1:PIN></ns1:DocumentCriteria></ns1:DocumentCriterium></ns1:GetDocumentsRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Example Code</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetDocumentsResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><Documents><Document><PIN><Value>329015010179</Value></PIN><DocumentDetails><DocumentDetail><DocumentType>DomesticBillOfLadingThermal</DocumentType><Description>Domestic Bill of Lading - Thermal</Description><DocumentStatus>Completed</DocumentStatus><URL>https://certeshiponline.purolator.com/ShipOnline/shipment/getLabel.ashx?i=AlfwEOYRBbcuzZoJMh2o0fukgvWuIQK0ZQxJEckoAXD0qTAd%2baAObmw4HpYo0Ndypm7KQ5w4kOuL6AIPmoinj9gDF4rvtx2xlkYPwOpsjyDXJ%2bI4e5ZDjIfp%2bdRGpMx9hmo3Vl4dUVUJ8yU5nUsdCA%3d%3d</URL></DocumentDetail></DocumentDetails></Document></Documents></GetDocumentsResponse></s:Body></s:Envelope>
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

    [Documents] => stdClass Object
        (
            [Document] => stdClass Object
                (
                    [PIN] => stdClass Object
                        (
                            [Value] => 329015010179
                        )

                    [DocumentDetails] => stdClass Object
                        (
                            [DocumentDetail] => stdClass Object
                                (
                                    [DocumentType] => DomesticBillOfLadingThermal
                                    [Description] => Domestic Bill of Lading - Thermal
                                    [DocumentStatus] => Completed
                                    [URL] => https://certeshiponline.purolator.com/ShipOnline/shipment/getLabel.ashx?i=AlfwEOYRBbcuzZoJMh2o0fukgvWuIQK0ZQxJEckoAXD0qTAd%2baAObmw4HpYo0Ndypm7KQ5w4kOuL6AIPmoinj9gDF4rvtx2xlkYPwOpsjyDXJ%2bI4e5ZDjIfp%2bdRGpMx9hmo3Vl4dUVUJ8yU5nUsdCA%3d%3d
                                )

                        )

                )

        )

)


**/
