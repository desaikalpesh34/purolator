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

function createPWSSOAPClient()
{
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( "./wsdl/EstimatingService.wsdl", 
                            array	(
                                    'trace'			=>	true,
									// Development (dev)
                                    'location'	=>	"https://devwebservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx",
                                    // Production 
									// 'location'	=>	"https://webservices.purolator.com/PWS/V1/Estimating/EstimatingService.asmx",
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
                                        'RequestReference'  =>  'Rating Example'
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
  GetQuickEstimate Example(s)
    EXAMPLE 01:
    1 piece shipment, 10lbs, Customer Packaging
*********************************************************************************/ 
//Create a SOAP Client for Example 01
$client = createPWSSOAPClient();

//Populate the Billing Account Number
$request->BillingAccountNumber = BILLING_ACCOUNT;
//Populate the Origin Information
$request->SenderPostalCode = "L4W5M8";
//Populate the Desination Information
$request->ReceiverAddress->City = "Burnaby";
$request->ReceiverAddress->Province = "BC";
$request->ReceiverAddress->Country = "CA";
$request->ReceiverAddress->PostalCode = "V5C5A9";  
 //Populate the Package Information
$request->PackageType = "CustomerPackaging";
//Populate the Shipment Weight
$request->TotalWeight->Value = "10";
$request->TotalWeight->WeightUnit = "lb";
//Execute the request and capture the response
$response = $client->GetQuickEstimate($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetQuickEstimateRequest><ns1:BillingAccountNumber xsi:nil="true"/><ns1:SenderPostalCode>L4W5M8</ns1:SenderPostalCode><ns1:ReceiverAddress><ns1:City>Burnaby</ns1:City><ns1:Province>BC</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>V5C5A9</ns1:PostalCode></ns1:ReceiverAddress><ns1:PackageType>CustomerPackaging</ns1:PackageType><ns1:TotalWeight><ns1:Value>10</ns1:Value><ns1:WeightUnit>lb</ns1:WeightUnit></ns1:TotalWeight></ns1:GetQuickEstimateRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetQuickEstimateResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><ShipmentEstimates><ShipmentEstimate><ServiceID>PurolatorExpress9AM</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>62.35</BasePrice><Surcharges><Surcharge><Amount>2.81</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>1</Amount><Type>ResidentialPickup</Type><Description>Residential Pickup</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>3.4</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>71.41</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorExpress10:30AM</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>55</BasePrice><Surcharges><Surcharge><Amount>2.48</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>1</Amount><Type>ResidentialPickup</Type><Description>Residential Pickup</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>3.02</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>63.35</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorExpress</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>46.15</BasePrice><Surcharges><Surcharge><Amount>2.08</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>1</Amount><Type>ResidentialPickup</Type><Description>Residential Pickup</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>2.55</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>53.63</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorExpressEvening</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-17</ExpectedDeliveryDate><EstimatedTransitDays>1</EstimatedTransitDays><BasePrice>72.15</BasePrice><Surcharges><Surcharge><Amount>3.25</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge><Surcharge><Amount>1</Amount><Type>ResidentialPickup</Type><Description>Residential Pickup</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>3.82</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>80.22</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorGround</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-22</ExpectedDeliveryDate><EstimatedTransitDays>4</EstimatedTransitDays><BasePrice>29.6</BasePrice><Surcharges><Surcharge><Amount>1.33</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge><Surcharge><Amount>1.85</Amount><Type>ResidentialDelivery</Type><Description>Residential Delivery</Description></Surcharge><Surcharge><Amount>1</Amount><Type>ResidentialPickup</Type><Description>Residential Pickup</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>1.69</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>35.47</TotalPrice></ShipmentEstimate><ShipmentEstimate><ServiceID>PurolatorGroundEvening</ServiceID><ShipmentDate>2009-04-16</ShipmentDate><ExpectedDeliveryDate>2009-04-22</ExpectedDeliveryDate><EstimatedTransitDays>4</EstimatedTransitDays><BasePrice>55.6</BasePrice><Surcharges><Surcharge><Amount>2.5</Amount><Type>Fuel</Type><Description>Fuel</Description></Surcharge><Surcharge><Amount>1</Amount><Type>ResidentialPickup</Type><Description>Residential Pickup</Description></Surcharge></Surcharges><Taxes><Tax><Amount>0</Amount><Type>PSTQST</Type><Description>PST/QST</Description></Tax><Tax><Amount>0</Amount><Type>HST</Type><Description>HST</Description></Tax><Tax><Amount>2.96</Amount><Type>GST</Type><Description>GST</Description></Tax></Taxes><OptionPrices i:nil="true"/><TotalPrice>62.06</TotalPrice></ShipmentEstimate></ShipmentEstimates></GetQuickEstimateResponse></s:Body></s:Envelope>
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

//Optional - see the whole response
//print_r($response);

/**
  * EXPECTED RESULTS from PWS
  * Note: The prices displayed are for example purposes ONLY
  *
  * PurolatorExpress9AM is available for $ 71.41
  * PurolatorExpress10:30AM is available for $ 63.35
  * PurolatorExpress is available for $ 53.63
  * PurolatorExpressEvening is available for $ 80.22
  * PurolatorGround is available for $ 35.47
  * PurolatorGroundEvening is available for $ 62.06
  *
**/
