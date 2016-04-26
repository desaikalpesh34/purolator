<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Returns Management Web Service.
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
  $client = new SoapClient( "./wsdl/returnsmanagementservice.wsdl", 
                            array	(
                                    'trace'			=>	true,
                                    'location'	=>	"https://webservices.purolator.com/PWS/V1/ReturnsManagement/ReturnsManagementService.asmx",
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
                                        'RequestReference'  =>  'Example Code'
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
  Returns Management Shipment Example(s)
    EXAMPLE 01:
    Create a 1 piece returns management shipment
*********************************************************************************/ 
//Create a SOAP Client for Example 01
$client = createPWSSOAPClient();

//Specify the Sender Information for the Returns Management Shipment
$request->RMA = "RMA123";
$request->ReturnsManagementShipment->SenderInformation->Address->Name = "Aaron Summer";
$request->ReturnsManagementShipment->SenderInformation->Address->Company = "Purolator Courier Ltd";
$request->ReturnsManagementShipment->SenderInformation->Address->Department = "Client Services";
$request->ReturnsManagementShipment->SenderInformation->Address->StreetNumber = "2245";
$request->ReturnsManagementShipment->SenderInformation->Address->StreetName = "Main";
$request->ReturnsManagementShipment->SenderInformation->Address->StreetType = "Street";
$request->ReturnsManagementShipment->SenderInformation->Address->City = "Mississauga";
$request->ReturnsManagementShipment->SenderInformation->Address->Province = "ON";
$request->ReturnsManagementShipment->SenderInformation->Address->PostalCode = "L4W5M8";
$request->ReturnsManagementShipment->SenderInformation->Address->Country = "CA";
$request->ReturnsManagementShipment->SenderInformation->Address->PhoneNumber->CountryCode = "1";
$request->ReturnsManagementShipment->SenderInformation->Address->PhoneNumber->AreaCode = "800";
$request->ReturnsManagementShipment->SenderInformation->Address->PhoneNumber->Phone = "4595599";

//Specify the Receiver Information for the shipment
$request->ReturnsManagementShipment->ReceiverInformation->Address->Name = "Aaron Summer";
$request->ReturnsManagementShipment->ReceiverInformation->Address->Company = "Purolator Courier Ltd";
$request->ReturnsManagementShipment->ReceiverInformation->Address->Department = "Client Services";
$request->ReturnsManagementShipment->ReceiverInformation->Address->StreetNumber = "2245";
$request->ReturnsManagementShipment->ReceiverInformation->Address->StreetName = "Main";
$request->ReturnsManagementShipment->ReceiverInformation->Address->StreetType = "Street";
$request->ReturnsManagementShipment->ReceiverInformation->Address->City = "Mississauga";
$request->ReturnsManagementShipment->ReceiverInformation->Address->Province = "ON";
$request->ReturnsManagementShipment->ReceiverInformation->Address->PostalCode = "L4W5M8";
$request->ReturnsManagementShipment->ReceiverInformation->Address->Country = "CA";
$request->ReturnsManagementShipment->ReceiverInformation->Address->PhoneNumber->CountryCode = "1";
$request->ReturnsManagementShipment->ReceiverInformation->Address->PhoneNumber->AreaCode = "800";
$request->ReturnsManagementShipment->ReceiverInformation->Address->PhoneNumber->Phone = "4595599";

//Populate the Package Information
$request->ReturnsManagementShipment->PackageInformation->TotalWeight->Value = "10";
$request->ReturnsManagementShipment->PackageInformation->TotalWeight->WeightUnit = "lb";
$request->ReturnsManagementShipment->PackageInformation->TotalPieces = "1";
$request->ReturnsManagementShipment->PackageInformation->ServiceID = "PurolatorExpress";
//Populate the Payment Information
$request->ReturnsManagementShipment->PaymentInformation->PaymentType = "Sender";
$request->ReturnsManagementShipment->PaymentInformation->BillingAccountNumber = BILLING_ACCOUNT;
$request->ReturnsManagementShipment->PaymentInformation->RegisteredAccountNumber = REGISTERED_ACCOUNT;
//Populate the Pickup Information
$request->ReturnsManagementShipment->PickupInformation->PickupType = "DropOff";
//ReturnsManagementShipment Reference
$request->ReturnsManagementShipment->TrackingReferenceInformation->Reference1 = "RMA123";
//Define the ReturnsManagementShipment Document Type
$request->PrinterType = "Thermal";

//Define OptionsInformation
$request->OptionsInformation->Options->OptionIDValuePair->ID = "residentialsignaturedomestic";
$request->OptionsInformation->Options->OptionIDValuePair->Value = "true";


//Execute the request and capture the response
$response = $client->CreateReturnsManagementShipment($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Example Code</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:CreateReturnsManagementShipmentRequest><ns1:RMA>RMA123</ns1:RMA><ns1:ReturnsManagementShipment><ns1:SenderInformation><ns1:Address><ns1:Name>Aaron Summer</ns1:Name><ns1:Company>Purolator Courier Ltd</ns1:Company><ns1:Department>Client Services</ns1:Department><ns1:StreetNumber>2245</ns1:StreetNumber><ns1:StreetName>Main</ns1:StreetName><ns1:StreetType>Street</ns1:StreetType><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>800</ns1:AreaCode><ns1:Phone>4595599</ns1:Phone></ns1:PhoneNumber></ns1:Address></ns1:SenderInformation><ns1:ReceiverInformation><ns1:Address><ns1:Name>Aaron Summer</ns1:Name><ns1:Company>Purolator Courier Ltd</ns1:Company><ns1:Department>Client Services</ns1:Department><ns1:StreetNumber>2245</ns1:StreetNumber><ns1:StreetName>Main</ns1:StreetName><ns1:StreetType>Street</ns1:StreetType><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>800</ns1:AreaCode><ns1:Phone>4595599</ns1:Phone></ns1:PhoneNumber></ns1:Address></ns1:ReceiverInformation><ns1:PackageInformation><ns1:ServiceID>PurolatorExpress</ns1:ServiceID><ns1:TotalWeight><ns1:Value>10</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:TotalWeight><ns1:TotalPieces>1</ns1:TotalPieces></ns1:PackageInformation><ns1:PaymentInformation><ns1:PaymentType>Sender</ns1:PaymentType><ns1:RegisteredAccountNumber>YOUR_ACCOUNT_HERE</ns1:RegisteredAccountNumber><ns1:BillingAccountNumber>YOUR_ACCOUNT_HERE</ns1:BillingAccountNumber></ns1:PaymentInformation><ns1:PickupInformation><ns1:PickupType>DropOff</ns1:PickupType></ns1:PickupInformation><ns1:TrackingReferenceInformation><ns1:Reference1>RMA123</ns1:Reference1></ns1:TrackingReferenceInformation></ns1:ReturnsManagementShipment><ns1:PrinterType>Thermal</ns1:PrinterType></ns1:CreateReturnsManagementShipmentRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/
 
/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Example Code</h:ResponseReference></h:ResponseContext></s:Header><s:Body><CreateReturnsManagementShipmentResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><ShipmentPIN><Value>329015010179</Value></ShipmentPIN><PiecePINs><PIN><Value>329015010179</Value></PIN></PiecePINs><RMA>RMA123</RMA></CreateReturnsManagementShipmentResponse></s:Body></s:Envelope>
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

    [ShipmentPIN] => stdClass Object
        (
            [Value] => 329015010179
        )

    [PiecePINs] => stdClass Object
        (
            [PIN] => stdClass Object
                (
                    [Value] => 329015010179
                )

        )

    [RMA] => RMA123
)
**/
