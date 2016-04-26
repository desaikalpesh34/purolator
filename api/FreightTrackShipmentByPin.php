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
  $client = new SoapClient( WSDL_URL."FreightTrackingService.wsdl", 
                            array	(
					'trace'			=>	true,
					'location' => "https://devwebservices.purolator.com/PWS/V1/FreightTracking/FreightTrackingService.asmx",
					'uri'				=>	"http://purolator.com/pws/datatypes/v1",
					'login'			=>	PRODUCTION_KEY,
					'password'	=>	PRODUCTION_PASS
                                  )
                          );						
						  
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.0',
                                        'Language'          =>  'fr',
                                        'GroupID'           =>  'xxx',
                                        'RequestReference'  =>  'Tracking Example',
                                        'UserToken'         =>  USER_TOKEN //activation key
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
	Schedule Tracking Example(s)
	EXAMPLE 01:    
*********************************************************************************/ 

//Create a SOAP Client for this Example
$client = createPWSSOAPClient();

$request = new FreightTrackingService();

$request->PINs->PIN->Value = "8805743880";


//Execute the request and capture the response
$response = $client->TrackPackagesByPin($request);

//print $request;
  
  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>PickUp Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:TrackPackageByPINSearchCriteria><ns1:PINs><ns1:PIN><ns1:Value>8805146712</ns1:Value></ns1:PIN></ns1:PINs></ns1:TrackPackageByPINSearchCriteria></SOAP-ENV:Body></SOAP-ENV:Envelope>

**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>PickUp Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><TrackingResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><TrackingInformationList><TrackingInformation><ShipmentDetails><SenderInformation><Address><Name>Test  </Name><Company>1234</Company><Department i:nil="true"/><StreetNumber i:nil="true"/><StreetSuffix i:nil="true"/><StreetName>333 2222 123 dd Solar Road NE</StreetName><StreetType i:nil="true"/><StreetDirection i:nil="true"/><Suite i:nil="true"/><Floor i:nil="true"/><StreetAddress2>aaaaaaaaaaa Addresss 3</StreetAddress2><StreetAddress3 i:nil="true"/><City>Mississauga</City><Province>ON</Province><Country i:nil="true"/><PostalCode>M2R3G7</PostalCode><PhoneNumber><CountryCode i:nil="true"/><AreaCode>222</AreaCode><Phone>2123456</Phone><Extension>712345</Extension></PhoneNumber><FaxNumber i:nil="true"/></Address><EmailAddress i:nil="true"/></SenderInformation><ReceiverInformation><Address><Name>Dana  </Name><Company>Danar</Company><Department i:nil="true"/><StreetNumber i:nil="true"/><StreetSuffix i:nil="true"/><StreetName>666 6 12 S Main Street NW</StreetName><StreetType i:nil="true"/><StreetDirection i:nil="true"/><Suite i:nil="true"/><Floor i:nil="true"/><StreetAddress2>DDDDDDDD</StreetAddress2><StreetAddress3 i:nil="true"/><City>Toronto</City><Province>ON</Province><Country i:nil="true"/><PostalCode>M6P3Y2</PostalCode><PhoneNumber><CountryCode i:nil="true"/><AreaCode>905</AreaCode><Phone>1234567</Phone><Extension>888</Extension></PhoneNumber><FaxNumber i:nil="true"/></Address><EmailAddress i:nil="true"/></ReceiverInformation><ThirdPartyInformation><Address><Name i:nil="true"/><Company>1234</Company><Department i:nil="true"/><StreetNumber i:nil="true"/><StreetSuffix i:nil="true"/><StreetName>333 2222 123 dd Solar Road NE aaaaaaaaaaa Addresss 3</StreetName><StreetType i:nil="true"/><StreetDirection i:nil="true"/><Suite i:nil="true"/><Floor i:nil="true"/><StreetAddress2 i:nil="true"/><StreetAddress3 i:nil="true"/><City>Mississauga</City><Province>ON</Province><Country i:nil="true"/><PostalCode>M2R3G7</PostalCode><PhoneNumber i:nil="true"/><FaxNumber i:nil="true"/></Address></ThirdPartyInformation><ProNumber>8805146365</ProNumber><Trn>0</Trn><BOLNo>8805146365</BOLNo><ShipDate>2015-03-02</ShipDate><Pieces>6000</Pieces><Weight>221</Weight><Pallets>75</Pallets><ServiceTypeCode>0</ServiceTypeCode><ServiceTypeDesc>Expedited LTL</ServiceTypeDesc><InternalPro>8805146365</InternalPro><POType>PO</POType><PONumber>1</PONumber></ShipmentDetails><ShipmentStatus><ShipmentStatus>              ****** R A T E   Q U O T E   O N L Y !! ******* </ShipmentStatus><Delivered>false</Delivered><DelDate i:nil="true"/><DelTime/><SignedBy/><DelStatCode i:nil="true"/><DelStatDesc i:nil="true"/><AppDateStart i:nil="true"/><AppDateEnd i:nil="true"/><AppTimeStart i:nil="true"/><AppTimeEnd/><AppContact/><ImageType i:nil="true"/><ImageLink i:nil="true"/></ShipmentStatus><ShipmentPinHistory i:nil="true"/></TrackingInformation></TrackingInformationList></TrackingResponse></s:Body></s:Envelope>

  
**/

//Display the services and associated rules for this shipment
echo '<pre>';
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
	[ResponseInformation] => [TrackingInformationList] => stdClass Object ( [TrackingInformation] => stdClass Object ( [ShipmentDetails] => stdClass Object ( [SenderInformation] => stdClass Object ( [Address] => stdClass Object ( [Name] => Test [Company] => 1234 [Department] => [StreetNumber] => [StreetSuffix] => [StreetName] => 333 2222 123 dd Solar Road NE [StreetType] => [StreetDirection] => [Suite] => [Floor] => [StreetAddress2] => aaaaaaaaaaa Addresss 3 [StreetAddress3] => [City] => Mississauga [Province] => ON [Country] => [PostalCode] => M2R3G7 [PhoneNumber] => stdClass Object ( [CountryCode] => [AreaCode] => 222 [Phone] => 2123456 [Extension] => 712345 ) [FaxNumber] => ) [EmailAddress] => ) [ReceiverInformation] => stdClass Object ( [Address] => stdClass Object ( [Name] => Dana [Company] => Danar [Department] => [StreetNumber] => [StreetSuffix] => [StreetName] => 666 6 12 S Main Street NW [StreetType] => [StreetDirection] => [Suite] => [Floor] => [StreetAddress2] => DDDDDDDD [StreetAddress3] => [City] => Toronto [Province] => ON [Country] => [PostalCode] => M6P3Y2 [PhoneNumber] => stdClass Object ( [CountryCode] => [AreaCode] => 905 [Phone] => 1234567 [Extension] => 888 ) [FaxNumber] => ) [EmailAddress] => ) [ThirdPartyInformation] => stdClass Object ( [Address] => stdClass Object ( [Name] => [Company] => 1234 [Department] => [StreetNumber] => [StreetSuffix] => [StreetName] => 333 2222 123 dd Solar Road NE aaaaaaaaaaa Addresss 3 [StreetType] => [StreetDirection] => [Suite] => [Floor] => [StreetAddress2] => [StreetAddress3] => [City] => Mississauga [Province] => ON [Country] => [PostalCode] => M2R3G7 [PhoneNumber] => [FaxNumber] => ) ) [ProNumber] => 8805146365 [Trn] => 0 [BOLNo] => 8805146365 [ShipDate] => 2015-03-02 [Pieces] => 6000 [Weight] => 221 [Pallets] => 75 [ServiceTypeCode] => 0 [ServiceTypeDesc] => Expedited LTL [InternalPro] => 8805146365 [POType] => PO [PONumber] => 1 ) [ShipmentStatus] => stdClass Object ( [ShipmentStatus] => ****** R A T E Q U O T E O N L Y !! ******* [Delivered] => [DelDate] => [DelTime] => [SignedBy] => [DelStatCode] => [DelStatDesc] => [AppDateStart] => [AppDateEnd] => [AppTimeStart] => [AppTimeEnd] => [AppContact] => [ImageType] => [ImageLink] => ) [ShipmentPinHistory] => ) )
)
**/

?>
