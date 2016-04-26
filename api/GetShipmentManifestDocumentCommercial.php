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
				    'location'	=>	"https://devwebservices.purolator.com/EWS/V1/ShippingDocuments/ShippingDocumentsService.asmx",				    
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

$request->ShipmentManifestDocumentCriterium->ShipmentManifestDocumentCriteria->ManifestDate = "2010-03-15";

//Execute the request and capture the response
$response = $client->GetShipmentManifestDocument($request);

print "<pre>\n"; 
print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
print "</pre>";
 
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.2</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Example Code</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetShipmentManifestDocumentRequest><ns1:ShipmentManifestDocumentCriterium><ns1:ShipmentManifestDocumentCriteria><ns1:ManifestDate>2010-03-15</ns1:ManifestDate></ns1:ShipmentManifestDocumentCriteria></ns1:ShipmentManifestDocumentCriterium></ns1:GetShipmentManifestDocumentRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Example Code</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetShipmentManifestDocumentResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><ManifestBatches><ManifestBatch><ShipmentManifestDate>15/03/2010 12:00:00 AM</ShipmentManifestDate><ManifestCloseDateTime>17/03/2010 2:21:33 PM</ManifestCloseDateTime><ManifestBatchDetails><ManifestBatchDetail><DocumentType>PrepaidManifest</DocumentType><Description>Prepaid Manifest</Description><DocumentStatus>Completed</DocumentStatus><URL>https://certeshiponline.purolator.com/ShipOnline/shipment/getLabel.ashx?i=zKIJlDIGr6vw9PXYAEIVti4Y7HbIRX4wxCWyyTLH8tDlHixYmoLwQ6Fwn9Ffd2%2fFIojIbJAcf74FIEH2a83XAPAm6RDy%2fIVB9lZWds3S7wEqdQ99JE7jOjrWKwFExZA31t%2fmEG%2fMyAOdsfnoiMDYBA%3d%3d</URL></ManifestBatchDetail></ManifestBatchDetails></ManifestBatch></ManifestBatches></GetShipmentManifestDocumentResponse></s:Body></s:Envelope>
**/
 
//Determine the services and associated charges for this shipment
print_r($response);

/**
  * EXPECTED RESULTS from PWS
  
  
  stdClass Object ( 
	[ResponseInformation] => stdClass Object 
	( 
		[Errors] => stdClass Object ( ) 
		[InformationalMessages] => ) 
		[ManifestBatches] => stdClass Object 
		( 
			[ManifestBatch] => stdClass Object 
			( 
				[ShipmentManifestDate] => 15/03/2010 12:00:00 AM 
				[ManifestCloseDateTime] => 17/03/2010 2:21:33 PM 
				[ManifestBatchDetails] => stdClass Object 
				( 
					[ManifestBatchDetail] => stdClass Object 
					( 
						[DocumentType] => PrepaidManifest 
						[Description] => Prepaid Manifest 
						[DocumentStatus] => Completed 
						[URL] => https://certeshiponline.purolator.com/ShipOnline/shipment/getLabel.ashx?i=zKIJlDIGr6vw9PXYAEIVti4Y7HbIRX4wxCWyyTLH8tDlHixYmoLwQ6Fwn9Ffd2%2fFIojIbJAcf74FIEH2a83XAPAm6RDy%2fIVB9lZWds3S7wEqdQ99JE7jOjrWKwFExZA31t%2fmEG%2fMyAOdsfnoiMDYBA%3d%3d 
					) 
				) 
			) 
		) 
	) 
  
  )


**/
?>
