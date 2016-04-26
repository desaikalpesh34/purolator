<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Services Options Web Service.
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
  GetServicesOptions Example(s)
    EXAMPLE 01:
    Determine all service options origin and destination
*********************************************************************************/ 

//Create a SOAP Client for Example 02
$client = createPWSSOAPClient();

//Populate the Origin Information
$request->SenderAddress->City = "Mississauga";
$request->SenderAddress->Province = "ON";
$request->SenderAddress->Country = "CA";
$request->SenderAddress->PostalCode = "L4W5M8";    
//Populate the Desination Information
$request->ReceiverAddress->City = "Burnaby";
$request->ReceiverAddress->Province = "BC";
$request->ReceiverAddress->Country = "CA";
$request->ReceiverAddress->PostalCode = "V5C5A9";  

//Future Dated Shipments - YYYY-MM-DD format
$request->ShipmentDate = "YOUR_SHIPMENT_DATE";

//Populate the Payment Information
$request->BillingAccountNumber = BILLING_ACCOUNT;
//Populate the Pickup Information

//Execute the request and capture the response
$response = $client->GetServicesOptions($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetServicesOptionsRequest><ns1:BillingAccountNumber>YOUR_ACCOUNT_HERE</ns1:BillingAccountNumber><ns1:SenderAddress><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode></ns1:SenderAddress><ns1:ReceiverAddress><ns1:City>Burnaby</ns1:City><ns1:Province>BC</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>V5C5A9</ns1:PostalCode></ns1:ReceiverAddress></ns1:GetServicesOptionsRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetServicesOptionsResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><Services><Service><ID>PurolatorExpress9AM</ID><Description>Purolator Express 9AM</Description><PackageType>CustomerPackaging</PackageType><PackageTypeDescription>Customer Packaging</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Air</Value><Description>Air</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorExpress10:30AM</ID><Description>Purolator Express 10:30AM</Description><PackageType>CustomerPackaging</PackageType><PackageTypeDescription>Customer Packaging</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Air</Value><Description>Air</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorExpress</ID><Description>Purolator Express</Description><PackageType>CustomerPackaging</PackageType><PackageTypeDescription>Customer Packaging</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Air</Value><Description>Air</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>ExpressCheque</ID><Description>ExpressCheque</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeMethodOfPayment</ID><Description>Method of Payment</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>BankDraft</Value><Description>Bank Draft</Description></OptionValue><OptionValue><Value>MoneyOrder</Value><Description>Money Order</Description></OptionValue><OptionValue><Value>CertifiedCheque</Value><Description>Certified Cheque</Description></OptionValue><OptionValue><Value>PostDatedCheque</Value><Description>Post dated Cheque</Description></OptionValue><OptionValue><Value>Cheque</Value><Description>Cheque</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeAmount</ID><Description>Amount</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SaturdayPickup</ID><Description>Saturday Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>false</Value><Description>No</Description></OptionValue><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorExpressEnvelope9AM</ID><Description>Purolator Express Envelope 9AM</Description><PackageType>ExpressEnvelope</PackageType><PackageTypeDescription>Express Envelope</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></Options></Service><Service><ID>PurolatorExpressEnvelope10:30AM</ID><Description>Purolator Express Envelope 10:30AM</Description><PackageType>ExpressEnvelope</PackageType><PackageTypeDescription>Express Envelope</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></Options></Service><Service><ID>PurolatorExpressEnvelope</ID><Description>Purolator Express Envelope</Description><PackageType>ExpressEnvelope</PackageType><PackageTypeDescription>Express Envelope</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>ExpressCheque</ID><Description>ExpressCheque</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeMethodOfPayment</ID><Description>Method of Payment</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>BankDraft</Value><Description>Bank Draft</Description></OptionValue><OptionValue><Value>MoneyOrder</Value><Description>Money Order</Description></OptionValue><OptionValue><Value>CertifiedCheque</Value><Description>Certified Cheque</Description></OptionValue><OptionValue><Value>PostDatedCheque</Value><Description>Post dated Cheque</Description></OptionValue><OptionValue><Value>Cheque</Value><Description>Cheque</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeAmount</ID><Description>Amount</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SaturdayPickup</ID><Description>Saturday Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>false</Value><Description>No</Description></OptionValue><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></Options></Service><Service><ID>PurolatorExpressPack9AM</ID><Description>Purolator Express Pack 9AM</Description><PackageType>ExpressPack</PackageType><PackageTypeDescription>Express Pack</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></Options></Service><Service><ID>PurolatorExpressPack10:30AM</ID><Description>Purolator Express Pack 10:30AM</Description><PackageType>ExpressPack</PackageType><PackageTypeDescription>Express Pack</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></Options></Service><Service><ID>PurolatorExpressPack</ID><Description>Purolator Express Pack</Description><PackageType>ExpressPack</PackageType><PackageTypeDescription>Express Pack</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>ExpressCheque</ID><Description>ExpressCheque</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeMethodOfPayment</ID><Description>Method of Payment</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>BankDraft</Value><Description>Bank Draft</Description></OptionValue><OptionValue><Value>MoneyOrder</Value><Description>Money Order</Description></OptionValue><OptionValue><Value>CertifiedCheque</Value><Description>Certified Cheque</Description></OptionValue><OptionValue><Value>PostDatedCheque</Value><Description>Post dated Cheque</Description></OptionValue><OptionValue><Value>Cheque</Value><Description>Cheque</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeAmount</ID><Description>Amount</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SaturdayPickup</ID><Description>Saturday Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>false</Value><Description>No</Description></OptionValue><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></Options></Service><Service><ID>PurolatorExpressBox9AM</ID><Description>Purolator Express Box 9AM</Description><PackageType>ExpressBox</PackageType><PackageTypeDescription>Express Box</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Air</Value><Description>Air</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorExpressBox10:30AM</ID><Description>Purolator Express Box 10:30AM</Description><PackageType>ExpressBox</PackageType><PackageTypeDescription>Express Box</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Air</Value><Description>Air</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorExpressBox</ID><Description>Purolator Express Box</Description><PackageType>ExpressBox</PackageType><PackageTypeDescription>Express Box</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Air</Value><Description>Air</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>ExpressCheque</ID><Description>ExpressCheque</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeMethodOfPayment</ID><Description>Method of Payment</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>BankDraft</Value><Description>Bank Draft</Description></OptionValue><OptionValue><Value>MoneyOrder</Value><Description>Money Order</Description></OptionValue><OptionValue><Value>CertifiedCheque</Value><Description>Certified Cheque</Description></OptionValue><OptionValue><Value>PostDatedCheque</Value><Description>Post dated Cheque</Description></OptionValue><OptionValue><Value>Cheque</Value><Description>Cheque</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeAmount</ID><Description>Amount</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SaturdayPickup</ID><Description>Saturday Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>false</Value><Description>No</Description></OptionValue><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorGround</ID><Description>Purolator Ground</Description><PackageType>CustomerPackaging</PackageType><PackageTypeDescription>Customer Packaging</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Ground</Value><Description>Ground</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>LimitedQuantities</Value><Description>Limited Quantities</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>LessThan500kgExempt</Value><Description>&lt;500 kg Exempt</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>ExpressCheque</ID><Description>ExpressCheque</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeMethodOfPayment</ID><Description>Method of Payment</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>BankDraft</Value><Description>Bank Draft</Description></OptionValue><OptionValue><Value>MoneyOrder</Value><Description>Money Order</Description></OptionValue><OptionValue><Value>CertifiedCheque</Value><Description>Certified Cheque</Description></OptionValue><OptionValue><Value>PostDatedCheque</Value><Description>Post dated Cheque</Description></OptionValue><OptionValue><Value>Cheque</Value><Description>Cheque</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeAmount</ID><Description>Amount</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service><Service><ID>PurolatorGroundDistribution</ID><Description>Purolator Ground Distribution</Description><PackageType>CustomerPackaging</PackageType><PackageTypeDescription>Customer Packaging</PackageTypeDescription><Options><Option><ID>ChainOfSignature</ID><Description>Chain Of Signature</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>DangerousGoods</ID><Description>Dangerous Goods Indicator</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsMode</ID><Description>Dangerous Goods Mode</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>Ground</Value><Description>Ground</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>DangerousGoodsClass</ID><Description>Dangerous Goods Class</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>FullyRegulated</Value><Description>Fully Regulated</Description></OptionValue><OptionValue><Value>LimitedQuantities</Value><Description>Limited Quantities</Description></OptionValue><OptionValue><Value>UN3373</Value><Description>UN3373</Description></OptionValue><OptionValue><Value>LessThan500kgExempt</Value><Description>&lt;500 kg Exempt</Description></OptionValue><OptionValue><Value>UN1845</Value><Description>UN1845</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>DeclaredValue</ID><Description>Declared Value</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option><Option><ID>ExpressCheque</ID><Description>ExpressCheque</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeMethodOfPayment</ID><Description>Method of Payment</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>BankDraft</Value><Description>Bank Draft</Description></OptionValue><OptionValue><Value>MoneyOrder</Value><Description>Money Order</Description></OptionValue><OptionValue><Value>CertifiedCheque</Value><Description>Certified Cheque</Description></OptionValue><OptionValue><Value>PostDatedCheque</Value><Description>Post dated Cheque</Description></OptionValue><OptionValue><Value>Cheque</Value><Description>Cheque</Description></OptionValue></PossibleValues><ChildServiceOptions><Option><ID>ExpressChequeAmount</ID><Description>Amount</Description><ValueType>Decimal</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues/><ChildServiceOptions/></Option></ChildServiceOptions></Option></ChildServiceOptions></Option><Option><ID>HoldForPickup</ID><Description>Hold For Pickup</Description><ValueType>Enumeration</ValueType><AvailableForPieces>false</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions/></Option><Option><ID>SpecialHandling</ID><Description>Special Handling</Description><ValueType>Enumeration</ValueType><AvailableForPieces>true</AvailableForPieces><PossibleValues><OptionValue><Value>true</Value><Description>Yes</Description></OptionValue><OptionValue><Value>false</Value><Description>No</Description></OptionValue></PossibleValues><ChildServiceOptions><Option i:nil="true"/></ChildServiceOptions></Option></Options></Service></Services></GetServicesOptionsResponse></s:Body></s:Envelope>stdClass Object
**/

//Display the services and associated rules for this shipment
print_r($response);

/**
  * EXPECTED RESULTS from PWS
(
    [ResponseInformation] => stdClass Object
        (
            [Errors] => stdClass Object
                (
                )

            [InformationalMessages] => 
        )

    [Services] => stdClass Object
        (
            [Service] => Array
                (
                    [0] => stdClass Object
                        (
                            [ID] => PurolatorExpress9AM
                            [Description] => Purolator Express 9AM
                            [PackageType] => CustomerPackaging
                            [PackageTypeDescription] => Customer Packaging
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Air
                                                                                    [Description] => Air
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [1] => stdClass Object
                        (
                            [ID] => PurolatorExpress10:30AM
                            [Description] => Purolator Express 10:30AM
                            [PackageType] => CustomerPackaging
                            [PackageTypeDescription] => Customer Packaging
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Air
                                                                                    [Description] => Air
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [2] => stdClass Object
                        (
                            [ID] => PurolatorExpress
                            [Description] => Purolator Express
                            [PackageType] => CustomerPackaging
                            [PackageTypeDescription] => Customer Packaging
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Air
                                                                                    [Description] => Air
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => ExpressCheque
                                                    [Description] => ExpressCheque
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => ExpressChequeMethodOfPayment
                                                                    [Description] => Method of Payment
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => Array
                                                                                (
                                                                                    [0] => stdClass Object
                                                                                        (
                                                                                            [Value] => BankDraft
                                                                                            [Description] => Bank Draft
                                                                                        )

                                                                                    [1] => stdClass Object
                                                                                        (
                                                                                            [Value] => MoneyOrder
                                                                                            [Description] => Money Order
                                                                                        )

                                                                                    [2] => stdClass Object
                                                                                        (
                                                                                            [Value] => CertifiedCheque
                                                                                            [Description] => Certified Cheque
                                                                                        )

                                                                                    [3] => stdClass Object
                                                                                        (
                                                                                            [Value] => PostDatedCheque
                                                                                            [Description] => Post dated Cheque
                                                                                        )

                                                                                    [4] => stdClass Object
                                                                                        (
                                                                                            [Value] => Cheque
                                                                                            [Description] => Cheque
                                                                                        )

                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => ExpressChequeAmount
                                                                                    [Description] => Amount
                                                                                    [ValueType] => Decimal
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [5] => stdClass Object
                                                (
                                                    [ID] => SaturdayPickup
                                                    [Description] => Saturday Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [6] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [3] => stdClass Object
                        (
                            [ID] => PurolatorExpressEnvelope9AM
                            [Description] => Purolator Express Envelope 9AM
                            [PackageType] => ExpressEnvelope
                            [PackageTypeDescription] => Express Envelope
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                        )

                                )

                        )

                    [4] => stdClass Object
                        (
                            [ID] => PurolatorExpressEnvelope10:30AM
                            [Description] => Purolator Express Envelope 10:30AM
                            [PackageType] => ExpressEnvelope
                            [PackageTypeDescription] => Express Envelope
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                        )

                                )

                        )

                    [5] => stdClass Object
                        (
                            [ID] => PurolatorExpressEnvelope
                            [Description] => Purolator Express Envelope
                            [PackageType] => ExpressEnvelope
                            [PackageTypeDescription] => Express Envelope
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => ExpressCheque
                                                    [Description] => ExpressCheque
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => ExpressChequeMethodOfPayment
                                                                    [Description] => Method of Payment
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => Array
                                                                                (
                                                                                    [0] => stdClass Object
                                                                                        (
                                                                                            [Value] => BankDraft
                                                                                            [Description] => Bank Draft
                                                                                        )

                                                                                    [1] => stdClass Object
                                                                                        (
                                                                                            [Value] => MoneyOrder
                                                                                            [Description] => Money Order
                                                                                        )

                                                                                    [2] => stdClass Object
                                                                                        (
                                                                                            [Value] => CertifiedCheque
                                                                                            [Description] => Certified Cheque
                                                                                        )

                                                                                    [3] => stdClass Object
                                                                                        (
                                                                                            [Value] => PostDatedCheque
                                                                                            [Description] => Post dated Cheque
                                                                                        )

                                                                                    [4] => stdClass Object
                                                                                        (
                                                                                            [Value] => Cheque
                                                                                            [Description] => Cheque
                                                                                        )

                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => ExpressChequeAmount
                                                                                    [Description] => Amount
                                                                                    [ValueType] => Decimal
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => SaturdayPickup
                                                    [Description] => Saturday Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                        )

                                )

                        )

                    [6] => stdClass Object
                        (
                            [ID] => PurolatorExpressPack9AM
                            [Description] => Purolator Express Pack 9AM
                            [PackageType] => ExpressPack
                            [PackageTypeDescription] => Express Pack
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                        )

                                )

                        )

                    [7] => stdClass Object
                        (
                            [ID] => PurolatorExpressPack10:30AM
                            [Description] => Purolator Express Pack 10:30AM
                            [PackageType] => ExpressPack
                            [PackageTypeDescription] => Express Pack
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                        )

                                )

                        )

                    [8] => stdClass Object
                        (
                            [ID] => PurolatorExpressPack
                            [Description] => Purolator Express Pack
                            [PackageType] => ExpressPack
                            [PackageTypeDescription] => Express Pack
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => ExpressCheque
                                                    [Description] => ExpressCheque
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => ExpressChequeMethodOfPayment
                                                                    [Description] => Method of Payment
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => Array
                                                                                (
                                                                                    [0] => stdClass Object
                                                                                        (
                                                                                            [Value] => BankDraft
                                                                                            [Description] => Bank Draft
                                                                                        )

                                                                                    [1] => stdClass Object
                                                                                        (
                                                                                            [Value] => MoneyOrder
                                                                                            [Description] => Money Order
                                                                                        )

                                                                                    [2] => stdClass Object
                                                                                        (
                                                                                            [Value] => CertifiedCheque
                                                                                            [Description] => Certified Cheque
                                                                                        )

                                                                                    [3] => stdClass Object
                                                                                        (
                                                                                            [Value] => PostDatedCheque
                                                                                            [Description] => Post dated Cheque
                                                                                        )

                                                                                    [4] => stdClass Object
                                                                                        (
                                                                                            [Value] => Cheque
                                                                                            [Description] => Cheque
                                                                                        )

                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => ExpressChequeAmount
                                                                                    [Description] => Amount
                                                                                    [ValueType] => Decimal
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => SaturdayPickup
                                                    [Description] => Saturday Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                        )

                                )

                        )

                    [9] => stdClass Object
                        (
                            [ID] => PurolatorExpressBox9AM
                            [Description] => Purolator Express Box 9AM
                            [PackageType] => ExpressBox
                            [PackageTypeDescription] => Express Box
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Air
                                                                                    [Description] => Air
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [10] => stdClass Object
                        (
                            [ID] => PurolatorExpressBox10:30AM
                            [Description] => Purolator Express Box 10:30AM
                            [PackageType] => ExpressBox
                            [PackageTypeDescription] => Express Box
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Air
                                                                                    [Description] => Air
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [11] => stdClass Object
                        (
                            [ID] => PurolatorExpressBox
                            [Description] => Purolator Express Box
                            [PackageType] => ExpressBox
                            [PackageTypeDescription] => Express Box
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Air
                                                                                    [Description] => Air
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => ExpressCheque
                                                    [Description] => ExpressCheque
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => ExpressChequeMethodOfPayment
                                                                    [Description] => Method of Payment
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => Array
                                                                                (
                                                                                    [0] => stdClass Object
                                                                                        (
                                                                                            [Value] => BankDraft
                                                                                            [Description] => Bank Draft
                                                                                        )

                                                                                    [1] => stdClass Object
                                                                                        (
                                                                                            [Value] => MoneyOrder
                                                                                            [Description] => Money Order
                                                                                        )

                                                                                    [2] => stdClass Object
                                                                                        (
                                                                                            [Value] => CertifiedCheque
                                                                                            [Description] => Certified Cheque
                                                                                        )

                                                                                    [3] => stdClass Object
                                                                                        (
                                                                                            [Value] => PostDatedCheque
                                                                                            [Description] => Post dated Cheque
                                                                                        )

                                                                                    [4] => stdClass Object
                                                                                        (
                                                                                            [Value] => Cheque
                                                                                            [Description] => Cheque
                                                                                        )

                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => ExpressChequeAmount
                                                                                    [Description] => Amount
                                                                                    [ValueType] => Decimal
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [5] => stdClass Object
                                                (
                                                    [ID] => SaturdayPickup
                                                    [Description] => Saturday Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [6] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [12] => stdClass Object
                        (
                            [ID] => PurolatorGround
                            [Description] => Purolator Ground
                            [PackageType] => CustomerPackaging
                            [PackageTypeDescription] => Customer Packaging
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Ground
                                                                                    [Description] => Ground
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => LimitedQuantities
                                                                                                            [Description] => Limited Quantities
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [3] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => LessThan500kgExempt
                                                                                                            [Description] => <500 kg Exempt
                                                                                                        )

                                                                                                    [4] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => ExpressCheque
                                                    [Description] => ExpressCheque
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => ExpressChequeMethodOfPayment
                                                                    [Description] => Method of Payment
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => Array
                                                                                (
                                                                                    [0] => stdClass Object
                                                                                        (
                                                                                            [Value] => BankDraft
                                                                                            [Description] => Bank Draft
                                                                                        )

                                                                                    [1] => stdClass Object
                                                                                        (
                                                                                            [Value] => MoneyOrder
                                                                                            [Description] => Money Order
                                                                                        )

                                                                                    [2] => stdClass Object
                                                                                        (
                                                                                            [Value] => CertifiedCheque
                                                                                            [Description] => Certified Cheque
                                                                                        )

                                                                                    [3] => stdClass Object
                                                                                        (
                                                                                            [Value] => PostDatedCheque
                                                                                            [Description] => Post dated Cheque
                                                                                        )

                                                                                    [4] => stdClass Object
                                                                                        (
                                                                                            [Value] => Cheque
                                                                                            [Description] => Cheque
                                                                                        )

                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => ExpressChequeAmount
                                                                                    [Description] => Amount
                                                                                    [ValueType] => Decimal
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [5] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                    [13] => stdClass Object
                        (
                            [ID] => PurolatorGroundDistribution
                            [Description] => Purolator Ground Distribution
                            [PackageType] => CustomerPackaging
                            [PackageTypeDescription] => Customer Packaging
                            [Options] => stdClass Object
                                (
                                    [Option] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ChainOfSignature
                                                    [Description] => Chain Of Signature
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoods
                                                    [Description] => Dangerous Goods Indicator
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => DangerousGoodsMode
                                                                    [Description] => Dangerous Goods Mode
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => stdClass Object
                                                                                (
                                                                                    [Value] => Ground
                                                                                    [Description] => Ground
                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => DangerousGoodsClass
                                                                                    [Description] => Dangerous Goods Class
                                                                                    [ValueType] => Enumeration
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                            [OptionValue] => Array
                                                                                                (
                                                                                                    [0] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => FullyRegulated
                                                                                                            [Description] => Fully Regulated
                                                                                                        )

                                                                                                    [1] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => LimitedQuantities
                                                                                                            [Description] => Limited Quantities
                                                                                                        )

                                                                                                    [2] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN3373
                                                                                                            [Description] => UN3373
                                                                                                        )

                                                                                                    [3] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => LessThan500kgExempt
                                                                                                            [Description] => <500 kg Exempt
                                                                                                        )

                                                                                                    [4] => stdClass Object
                                                                                                        (
                                                                                                            [Value] => UN1845
                                                                                                            [Description] => UN1845
                                                                                                        )

                                                                                                )

                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DeclaredValue
                                                    [Description] => Declared Value
                                                    [ValueType] => Decimal
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => ExpressCheque
                                                    [Description] => ExpressCheque
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => stdClass Object
                                                                (
                                                                    [ID] => ExpressChequeMethodOfPayment
                                                                    [Description] => Method of Payment
                                                                    [ValueType] => Enumeration
                                                                    [AvailableForPieces] => 
                                                                    [PossibleValues] => stdClass Object
                                                                        (
                                                                            [OptionValue] => Array
                                                                                (
                                                                                    [0] => stdClass Object
                                                                                        (
                                                                                            [Value] => BankDraft
                                                                                            [Description] => Bank Draft
                                                                                        )

                                                                                    [1] => stdClass Object
                                                                                        (
                                                                                            [Value] => MoneyOrder
                                                                                            [Description] => Money Order
                                                                                        )

                                                                                    [2] => stdClass Object
                                                                                        (
                                                                                            [Value] => CertifiedCheque
                                                                                            [Description] => Certified Cheque
                                                                                        )

                                                                                    [3] => stdClass Object
                                                                                        (
                                                                                            [Value] => PostDatedCheque
                                                                                            [Description] => Post dated Cheque
                                                                                        )

                                                                                    [4] => stdClass Object
                                                                                        (
                                                                                            [Value] => Cheque
                                                                                            [Description] => Cheque
                                                                                        )

                                                                                )

                                                                        )

                                                                    [ChildServiceOptions] => stdClass Object
                                                                        (
                                                                            [Option] => stdClass Object
                                                                                (
                                                                                    [ID] => ExpressChequeAmount
                                                                                    [Description] => Amount
                                                                                    [ValueType] => Decimal
                                                                                    [AvailableForPieces] => 
                                                                                    [PossibleValues] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                    [ChildServiceOptions] => stdClass Object
                                                                                        (
                                                                                        )

                                                                                )

                                                                        )

                                                                )

                                                        )

                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => HoldForPickup
                                                    [Description] => Hold For Pickup
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                        )

                                                )

                                            [5] => stdClass Object
                                                (
                                                    [ID] => SpecialHandling
                                                    [Description] => Special Handling
                                                    [ValueType] => Enumeration
                                                    [AvailableForPieces] => 1
                                                    [PossibleValues] => stdClass Object
                                                        (
                                                            [OptionValue] => Array
                                                                (
                                                                    [0] => stdClass Object
                                                                        (
                                                                            [Value] => true
                                                                            [Description] => Yes
                                                                        )

                                                                    [1] => stdClass Object
                                                                        (
                                                                            [Value] => false
                                                                            [Description] => No
                                                                        )

                                                                )

                                                        )

                                                    [ChildServiceOptions] => stdClass Object
                                                        (
                                                            [Option] => 
                                                        )

                                                )

                                        )

                                )

                        )

                )

        )

)
**/

