<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Create Shipment Web Service.
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
  $client = new SoapClient( "./wsdl/shippingservice.wsdl", 
                            array	(
                                    'trace'			=>	true,
									//Development (dev)
                                    'location'	=>	"https://devwebservices.purolator.com/PWS/V1/Shipping/ShippingService.asmx",
                                    //Production 
									//'location'	=>	"https://webservices.purolator.com/PWS/V1/Shipping/ShippingService.asmx",
									'uri'				=>	"http://purolator.com/pws/datatypes/v1",
                                    'login'			=>	PRODUCTION_KEY,
                                    'password'	=>	PRODUCTION_PASS
                                  )
                          );
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.5',
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
  Create Shipment Example(s)
    EXAMPLE 01:
    1 piece shipment, 10lbs, Purolator Express Service on a Thermal 4x6 Label
*********************************************************************************/ 
//Create a SOAP Client for Example 01
$client = createPWSSOAPClient();

//Populate the Origin Information
$request->Shipment->SenderInformation->Address->Name = "Aaron Summer";
$request->Shipment->SenderInformation->Address->StreetNumber = "1234";
$request->Shipment->SenderInformation->Address->StreetName = "Main Street";
$request->Shipment->SenderInformation->Address->City = "Mississauga";
$request->Shipment->SenderInformation->Address->Province = "ON";
$request->Shipment->SenderInformation->Address->Country = "CA";
$request->Shipment->SenderInformation->Address->PostalCode = "L4W5M8";    
$request->Shipment->SenderInformation->Address->PhoneNumber->CountryCode = "1";
$request->Shipment->SenderInformation->Address->PhoneNumber->AreaCode = "905";
$request->Shipment->SenderInformation->Address->PhoneNumber->Phone = "5555555";
//Populate the Desination Information
$request->Shipment->ReceiverInformation->Address->Name = "Aaron Summer";
$request->Shipment->ReceiverInformation->Address->StreetNumber = "2245";
$request->Shipment->ReceiverInformation->Address->StreetName = "Douglas Road";
$request->Shipment->ReceiverInformation->Address->City = "Burnaby";
$request->Shipment->ReceiverInformation->Address->Province = "BC";
$request->Shipment->ReceiverInformation->Address->Country = "CA";
$request->Shipment->ReceiverInformation->Address->PostalCode = "V5C1A1";    
$request->Shipment->ReceiverInformation->Address->PhoneNumber->CountryCode = "1";
$request->Shipment->ReceiverInformation->Address->PhoneNumber->AreaCode = "604";
$request->Shipment->ReceiverInformation->Address->PhoneNumber->Phone = "2982181";

//Future Dated Shipments - YYYY-MM-DD format
$request->Shipment->ShipmentDate = "YOUR_SHIPMENT_DATE_HERE";

//Populate the Package Information
$request->Shipment->PackageInformation->TotalWeight->Value = "10";
$request->Shipment->PackageInformation->TotalWeight->WeightUnit = "lb";
$request->Shipment->PackageInformation->TotalPieces = "1";
$request->Shipment->PackageInformation->ServiceID = "PurolatorExpress";

//Define OptionsInformation
//ResidentialSignatureDomestic
//$request->Shipment->PackageInformation->OptionsInformation->Options->OptionIDValuePair->ID = "ResidentialSignatureDomestic";
//$request->Shipment->PackageInformation->OptionsInformation->Options->OptionIDValuePair->Value = "true";

//ResidentialSignatureIntl
//$request->Shipment->PackageInformation->OptionsInformation->Options->OptionIDValuePair->ID = "ResidentialSignatureIntl";
//$request->Shipment->PackageInformation->OptionsInformation->Options->OptionIDValuePair->Value = "true";

//OriginSignatureNotRequired
$request->Shipment->PackageInformation->OptionsInformation->Options->OptionIDValuePair->ID = "OriginSignatureNotRequired";
$request->Shipment->PackageInformation->OptionsInformation->Options->OptionIDValuePair->Value = "true";

//Populate the Payment Information
$request->Shipment->PaymentInformation->PaymentType = "Sender";
$request->Shipment->PaymentInformation->BillingAccountNumber = BILLING_ACCOUNT;
$request->Shipment->PaymentInformation->RegisteredAccountNumber = REGISTERED_ACCOUNT;
//Populate the Pickup Information
$request->Shipment->PickupInformation->PickupType = "DropOff";
//Shipment Reference
$request->Shipment->TrackingReferenceInformation->Reference1 = "Reference For Shipment";
//Define the Shipment Document Type
$request->PrinterType = "Thermal";

//Define OptionsInformation
$request->OptionsInformation->Options->OptionIDValuePair->ID = "residentialsignaturedomestic";
$request->OptionsInformation->Options->OptionIDValuePair->Value = "true";


//Execute the request and capture the response
$response = $client->CreateShipment($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:CreateShipmentRequest><ns1:Shipment><ns1:SenderInformation><ns1:Address><ns1:Name>Aaron Summer</ns1:Name><ns1:StreetNumber>1234</ns1:StreetNumber><ns1:StreetName>Main Street</ns1:StreetName><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>5555555</ns1:Phone></ns1:PhoneNumber></ns1:Address></ns1:SenderInformation><ns1:ReceiverInformation><ns1:Address><ns1:Name>Aaron Summer</ns1:Name><ns1:StreetNumber>2245</ns1:StreetNumber><ns1:StreetName>Douglas Road</ns1:StreetName><ns1:City>Burnaby</ns1:City><ns1:Province>BC</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>V5C5A9</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>604</ns1:AreaCode><ns1:Phone>2982181</ns1:Phone></ns1:PhoneNumber></ns1:Address></ns1:ReceiverInformation><ns1:PackageInformation><ns1:ServiceID>PurolatorExpress</ns1:ServiceID><ns1:TotalWeight><ns1:Value>10</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:TotalWeight><ns1:TotalPieces>1</ns1:TotalPieces></ns1:PackageInformation><ns1:PaymentInformation><ns1:PaymentType>Sender</ns1:PaymentType><ns1:RegisteredAccountNumber>YOUR_ACCOUNT_HERE</ns1:RegisteredAccountNumber><ns1:BillingAccountNumber>YOUR_ACCOUNT_HERE</ns1:BillingAccountNumber></ns1:PaymentInformation><ns1:PickupInformation><ns1:PickupType>DropOff</ns1:PickupType></ns1:PickupInformation><ns1:TrackingReferenceInformation><ns1:Reference1>Reference For Shipment</ns1:Reference1></ns1:TrackingReferenceInformation></ns1:Shipment><ns1:PrinterType>Thermal</ns1:PrinterType></ns1:CreateShipmentRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><CreateShipmentResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><ShipmentPIN><Value>329014521622</Value></ShipmentPIN><PiecePINs><PIN><Value>329014521622</Value></PIN></PiecePINs><ReturnShipmentPINs/><ExpressChequePIN><Value/></ExpressChequePIN></CreateShipmentResponse></s:Body></s:Envelope>
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
            [Value] => 329014521622
        )

    [PiecePINs] => stdClass Object
        (
            [PIN] => stdClass Object
                (
                    [Value] => 329014521622
                )

        )

    [ReturnShipmentPINs] => stdClass Object
        (
        )

    [ExpressChequePIN] => stdClass Object
        (
            [Value] => 
        )

)
**/
