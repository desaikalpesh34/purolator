<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Estimating Web Services.
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
  $client = new SoapClient( "./WSDL/EstimatingService.wsdl", 
                            array	(
                                    'trace'			=>	true,
									//Development (dev)
                                    'location'	=>	"https://devwebservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx",
                                    //Production
									//'location'	=>	"https://webservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx",
									'uri'				=>	"http://purolator.com/pws/datatypes/v1",
                                    'login'			=>	PRODUCTION_KEY,
                                    'password'	=>	PRODUCTION_PASS
                                  )
                          );
  //Define the SOAP Envelope Headers
  $headers[] = new SoapHeader ( 'http://purolator.com/pws/datatypes/v1', 
                                'RequestContext', 
                                array (
                                        'Version'           =>  '1.4',
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
  GetFullEstimate Example(s)
    EXAMPLE 01:
    1 piece shipment, 10lbs, Purolator Express Service (and all other available
    services).
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
//Populate the Payment Information
$request->Shipment->PaymentInformation->PaymentType = "Sender";
$request->Shipment->PaymentInformation->BillingAccountNumber = BILLING_ACCOUNT;
$request->Shipment->PaymentInformation->RegisteredAccountNumber = REGISTERED_ACCOUNT;
//Populate the Pickup Information
$request->Shipment->PickupInformation->PickupType = "DropOff";
$request->ShowAlternativeServicesIndicator = "true";

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

//Execute the request and capture the response
$response = $client->GetFullEstimate($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetFullEstimateRequest><ns1:Shipment><ns1:SenderInformation><ns1:Address><ns1:Name>Aaron Summer</ns1:Name><ns1:StreetNumber>1234</ns1:StreetNumber><ns1:StreetName>Main Street</ns1:StreetName><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>905</ns1:AreaCode><ns1:Phone>5555555</ns1:Phone></ns1:PhoneNumber></ns1:Address></ns1:SenderInformation><ns1:ReceiverInformation><ns1:Address><ns1:Name>Aaron Summer</ns1:Name><ns1:StreetNumber>2245</ns1:StreetNumber><ns1:StreetName>Douglas Road</ns1:StreetName><ns1:City>Burnaby</ns1:City><ns1:Province>BC</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>V5C5A9</ns1:PostalCode><ns1:PhoneNumber><ns1:CountryCode>1</ns1:CountryCode><ns1:AreaCode>604</ns1:AreaCode><ns1:Phone>2982181</ns1:Phone></ns1:PhoneNumber></ns1:Address></ns1:ReceiverInformation><ns1:PackageInformation><ns1:ServiceID>PurolatorExpress</ns1:ServiceID><ns1:TotalWeight><ns1:Value>10</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:TotalWeight><ns1:TotalPieces>1</ns1:TotalPieces></ns1:PackageInformation><ns1:PaymentInformation><ns1:PaymentType>Sender</ns1:PaymentType><ns1:RegisteredAccountNumber>YOUR_ACCOUNT_HERE</ns1:RegisteredAccountNumber><ns1:BillingAccountNumber>YOUR_ACCOUNT_HERE</ns1:BillingAccountNumber></ns1:PaymentInformation><ns1:PickupInformation><ns1:PickupType>DropOff</ns1:PickupType></ns1:PickupInformation></ns1:Shipment><ns1:ShowAlternativeServicesIndicator>true</ns1:ShowAlternativeServicesIndicator></ns1:GetFullEstimateRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetFullEstimateResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><ShipmentEstimates><ShipmentEstimate><ServiceID>PurolatorExpress9AM</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>62.35</BasePrice><Surcharges><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>2.81</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>3.35</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>70.36</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorExpress10:30AM</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>55</BasePrice><Surcharges><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>2.48</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>2.97</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>62.3</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorExpress</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>46.15</BasePrice><Surcharges><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>2.08</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>2.5</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>52.58</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorGround</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-22</ExpectedDeliveryDate><EstimatedTransitDays>4</EstimatedTransitDays><BasePrice>29.6</BasePrice><Surcharges><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>1.33</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>1.64</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>34.42</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorGroundDistribution</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-22</ExpectedDeliveryDate><EstimatedTransitDays>4</EstimatedTransitDays><BasePrice>87.69</BasePrice><Surcharges><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>3.95</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>4.67</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>98.16</TotalPrice></ShipmentEstimate></ShipmentEstimates><ReturnShipmentEstimates i:nil="true"/></GetFullEstimateResponse></s:Body></s:Envelope>
**/


//Determine the services and associated charges for this shipment
if($response && $response->ShipmentEstimates->ShipmentEstimate)
{
  //Loop through each Service returned and display the ID and TotalPrice
  foreach($response->ShipmentEstimates->ShipmentEstimate as $estimate)
  {
    echo "$estimate->ServiceID is available for $ $estimate->TotalPrice\n";
  }
}

//Optional - see whole response
print_r($response);

/**
  * EXPECTED RESULTS from PWS
  * Note: The prices displayed are for example purposes ONLY
  *
  * PurolatorExpress9AM is available for $ 70.36
  * PurolatorExpress10:30AM is available for $ 62.3
  * PurolatorExpress is available for $ 52.58
  * PurolatorGround is available for $ 34.42
  * PurolatorGroundDistribution is available for $ 98.16
  *
**/
