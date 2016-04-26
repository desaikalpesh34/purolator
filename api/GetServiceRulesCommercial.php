<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com

  Requires    : PHP SOAP extension enabled
              : Local copy of the Estimating Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Service Rules Web Service.
*********************************************************************************/ 

//Define the Production (or development) Key and Password
define("PRODUCTION_KEY", "YOUR_PRODUCTION_KEY_HERE");
define("PRODUCTION_PASS", "YOUR_PRODUCTION_PASS_HERE");
define("USER_TOKEN", "YOUR_USER_TOKEN_HERE");

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
                                        'RequestReference'  =>  'Rating Example',
                                        'UserToken'         =>  USER_TOKEN
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
  GetServiceRules Example(s)
    EXAMPLE 01:
    Determine all service rules between origin and destination
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
//Populate the Payment Information
$request->BillingAccountNumber = BILLING_ACCOUNT;
//Populate the Pickup Information

//Execute the request and capture the response
$response = $client->GetServiceRules($request);

/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetServiceRulesRequest><ns1:BillingAccountNumber>YOUR_ACCOUNT_HERE</ns1:BillingAccountNumber><ns1:SenderAddress><ns1:City>Mississauga</ns1:City><ns1:Province>ON</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>L4W5M8</ns1:PostalCode></ns1:SenderAddress><ns1:ReceiverAddress><ns1:City>Burnaby</ns1:City><ns1:Province>BC</ns1:Province><ns1:Country>CA</ns1:Country><ns1:PostalCode>V5C5A9</ns1:PostalCode></ns1:ReceiverAddress></ns1:GetServiceRulesRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/
 
/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetServiceRulesResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation><Errors/><InformationalMessages i:nil="true"/></ResponseInformation><ServiceRules><ServiceRule><ServiceID>PurolatorExpress9AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>100</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>999</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>96</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>23</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>23</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>144</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpress10:30AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>100</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>999</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>96</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>23</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>23</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>144</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpress</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>100</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>999</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>150</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>96</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>23</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>23</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>144</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressEnvelope9AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressEnvelope10:30AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressEnvelope</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressPack9AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressPack10:30AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressPack</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressBox9AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressBox10:30AM</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>70</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorExpressBox</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>1</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>150</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>150</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>0</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorGround</ServiceID><MinimumTotalPieces>1</MinimumTotalPieces><MaximumTotalPieces>100</MaximumTotalPieces><MinimumTotalWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>999</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>1</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>150</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>120</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>47</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>47</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>216</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule><ServiceRule><ServiceID>PurolatorGroundDistribution</ServiceID><MinimumTotalPieces>4</MinimumTotalPieces><MaximumTotalPieces>100</MaximumTotalPieces><MinimumTotalWeight><Value>60</Value><WeightUnit>lb</WeightUnit></MinimumTotalWeight><MaximumTotalWeight><Value>999</Value><WeightUnit>lb</WeightUnit></MaximumTotalWeight><MinimumPieceWeight><Value>15</Value><WeightUnit>lb</WeightUnit></MinimumPieceWeight><MaximumPieceWeight><Value>150</Value><WeightUnit>lb</WeightUnit></MaximumPieceWeight><MinimumPieceLength><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceLength><MaximumPieceLength><Value>120</Value><DimensionUnit>in</DimensionUnit></MaximumPieceLength><MinimumPieceWidth><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceWidth><MaximumPieceWidth><Value>47</Value><DimensionUnit>in</DimensionUnit></MaximumPieceWidth><MinimumPieceHeight><Value>0</Value><DimensionUnit>in</DimensionUnit></MinimumPieceHeight><MaximumPieceHeight><Value>47</Value><DimensionUnit>in</DimensionUnit></MaximumPieceHeight><MaximumSize><Value>216</Value><DimensionUnit>in</DimensionUnit></MaximumSize><MaximumDeclaredValue>5000</MaximumDeclaredValue></ServiceRule></ServiceRules><ServiceOptionRules/><OptionRules><OptionRule><OptionIDValuePair><ID>ChainOfSignature</ID><Value>true</Value></OptionIDValuePair><Exclusions><OptionIDValuePair><ID>SaturdayDelivery</ID><Value>true</Value></OptionIDValuePair><OptionIDValuePair><ID>SaturdayPickup</ID><Value>true</Value></OptionIDValuePair></Exclusions><Inclusions/></OptionRule><OptionRule><OptionIDValuePair><ID>DangerousGoods</ID><Value>true</Value></OptionIDValuePair><Exclusions><OptionIDValuePair><ID>SaturdayPickup</ID><Value>true</Value></OptionIDValuePair></Exclusions><Inclusions><OptionIDValuePair><ID>DangerousGoodsMode</ID><Value>Air</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsMode</ID><Value>Ground</Value></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>DangerousGoodsMode</ID><Value>Air</Value></OptionIDValuePair><Exclusions><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>LessThan500kgExempt</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>LimitedQuantities</Value></OptionIDValuePair></Exclusions><Inclusions><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>FullyRegulated</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>UN3373</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>UN1845</Value></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>DangerousGoodsMode</ID><Value>Ground</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>FullyRegulated</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>UN3373</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>UN1845</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>LessThan500kgExempt</Value></OptionIDValuePair><OptionIDValuePair><ID>DangerousGoodsClass</ID><Value>LimitedQuantities</Value></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>HoldForPickup</ID><Value>true</Value></OptionIDValuePair><Exclusions/><Inclusions/></OptionRule><OptionRule><OptionIDValuePair><ID>ExpressCheque</ID><Value>true</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>Cheque</Value></OptionIDValuePair><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>PostDatedCheque</Value></OptionIDValuePair><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>CertifiedCheque</Value></OptionIDValuePair><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>MoneyOrder</Value></OptionIDValuePair><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>BankDraft</Value></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>BankDraft</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>ExpressChequeAmount</ID><Value i:nil="true"/></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>MoneyOrder</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>ExpressChequeAmount</ID><Value i:nil="true"/></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>CertifiedCheque</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>ExpressChequeAmount</ID><Value i:nil="true"/></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>PostDatedCheque</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>ExpressChequeAmount</ID><Value i:nil="true"/></OptionIDValuePair></Inclusions></OptionRule><OptionRule><OptionIDValuePair><ID>ExpressChequeMethodOfPayment</ID><Value>Cheque</Value></OptionIDValuePair><Exclusions/><Inclusions><OptionIDValuePair><ID>ExpressChequeAmount</ID><Value i:nil="true"/></OptionIDValuePair></Inclusions></OptionRule></OptionRules></GetServiceRulesResponse></s:Body></s:Envelope>
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

    [ServiceRules] => stdClass Object
        (
            [ServiceRule] => Array
                (
                    [0] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpress9AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 100
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 999
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 96
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 23
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 23
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 144
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [1] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpress10:30AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 100
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 999
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 96
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 23
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 23
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 144
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [2] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpress
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 100
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 999
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 150
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 96
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 23
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 23
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 144
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [3] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressEnvelope9AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [4] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressEnvelope10:30AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [5] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressEnvelope
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [6] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressPack9AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [7] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressPack10:30AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [8] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressPack
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [9] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressBox9AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [10] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressBox10:30AM
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 70
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [11] => stdClass Object
                        (
                            [ServiceID] => PurolatorExpressBox
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 1
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 150
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 150
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [12] => stdClass Object
                        (
                            [ServiceID] => PurolatorGround
                            [MinimumTotalPieces] => 1
                            [MaximumTotalPieces] => 100
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 999
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 1
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 150
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 120
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 47
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 47
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 216
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                    [13] => stdClass Object
                        (
                            [ServiceID] => PurolatorGroundDistribution
                            [MinimumTotalPieces] => 4
                            [MaximumTotalPieces] => 100
                            [MinimumTotalWeight] => stdClass Object
                                (
                                    [Value] => 60
                                    [WeightUnit] => lb
                                )

                            [MaximumTotalWeight] => stdClass Object
                                (
                                    [Value] => 999
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceWeight] => stdClass Object
                                (
                                    [Value] => 15
                                    [WeightUnit] => lb
                                )

                            [MaximumPieceWeight] => stdClass Object
                                (
                                    [Value] => 150
                                    [WeightUnit] => lb
                                )

                            [MinimumPieceLength] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceLength] => stdClass Object
                                (
                                    [Value] => 120
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceWidth] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceWidth] => stdClass Object
                                (
                                    [Value] => 47
                                    [DimensionUnit] => in
                                )

                            [MinimumPieceHeight] => stdClass Object
                                (
                                    [Value] => 0
                                    [DimensionUnit] => in
                                )

                            [MaximumPieceHeight] => stdClass Object
                                (
                                    [Value] => 47
                                    [DimensionUnit] => in
                                )

                            [MaximumSize] => stdClass Object
                                (
                                    [Value] => 216
                                    [DimensionUnit] => in
                                )

                            [MaximumDeclaredValue] => 5000
                        )

                )

        )

    [ServiceOptionRules] => stdClass Object
        (
        )

    [OptionRules] => stdClass Object
        (
            [OptionRule] => Array
                (
                    [0] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ChainOfSignature
                                    [Value] => true
                                )

                            [Exclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => SaturdayDelivery
                                                    [Value] => true
                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => SaturdayPickup
                                                    [Value] => true
                                                )

                                        )

                                )

                            [Inclusions] => stdClass Object
                                (
                                )

                        )

                    [1] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => DangerousGoods
                                    [Value] => true
                                )

                            [Exclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => stdClass Object
                                        (
                                            [ID] => SaturdayPickup
                                            [Value] => true
                                        )

                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsMode
                                                    [Value] => Air
                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsMode
                                                    [Value] => Ground
                                                )

                                        )

                                )

                        )

                    [2] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => DangerousGoodsMode
                                    [Value] => Air
                                )

                            [Exclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => LessThan500kgExempt
                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => LimitedQuantities
                                                )

                                        )

                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => FullyRegulated
                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => UN3373
                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => UN1845
                                                )

                                        )

                                )

                        )

                    [3] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => DangerousGoodsMode
                                    [Value] => Ground
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => FullyRegulated
                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => UN3373
                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => UN1845
                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => LessThan500kgExempt
                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => DangerousGoodsClass
                                                    [Value] => LimitedQuantities
                                                )

                                        )

                                )

                        )

                    [4] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => HoldForPickup
                                    [Value] => true
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                )

                        )

                    [5] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ExpressCheque
                                    [Value] => true
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => Array
                                        (
                                            [0] => stdClass Object
                                                (
                                                    [ID] => ExpressChequeMethodOfPayment
                                                    [Value] => Cheque
                                                )

                                            [1] => stdClass Object
                                                (
                                                    [ID] => ExpressChequeMethodOfPayment
                                                    [Value] => PostDatedCheque
                                                )

                                            [2] => stdClass Object
                                                (
                                                    [ID] => ExpressChequeMethodOfPayment
                                                    [Value] => CertifiedCheque
                                                )

                                            [3] => stdClass Object
                                                (
                                                    [ID] => ExpressChequeMethodOfPayment
                                                    [Value] => MoneyOrder
                                                )

                                            [4] => stdClass Object
                                                (
                                                    [ID] => ExpressChequeMethodOfPayment
                                                    [Value] => BankDraft
                                                )

                                        )

                                )

                        )

                    [6] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ExpressChequeMethodOfPayment
                                    [Value] => BankDraft
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => stdClass Object
                                        (
                                            [ID] => ExpressChequeAmount
                                            [Value] => 
                                        )

                                )

                        )

                    [7] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ExpressChequeMethodOfPayment
                                    [Value] => MoneyOrder
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => stdClass Object
                                        (
                                            [ID] => ExpressChequeAmount
                                            [Value] => 
                                        )

                                )

                        )

                    [8] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ExpressChequeMethodOfPayment
                                    [Value] => CertifiedCheque
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => stdClass Object
                                        (
                                            [ID] => ExpressChequeAmount
                                            [Value] => 
                                        )

                                )

                        )

                    [9] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ExpressChequeMethodOfPayment
                                    [Value] => PostDatedCheque
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => stdClass Object
                                        (
                                            [ID] => ExpressChequeAmount
                                            [Value] => 
                                        )

                                )

                        )

                    [10] => stdClass Object
                        (
                            [OptionIDValuePair] => stdClass Object
                                (
                                    [ID] => ExpressChequeMethodOfPayment
                                    [Value] => Cheque
                                )

                            [Exclusions] => stdClass Object
                                (
                                )

                            [Inclusions] => stdClass Object
                                (
                                    [OptionIDValuePair] => stdClass Object
                                        (
                                            [ID] => ExpressChequeAmount
                                            [Value] => 
                                        )

                                )

                        )

                )

        )

)

**/

