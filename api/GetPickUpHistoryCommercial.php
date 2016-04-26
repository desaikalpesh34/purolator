<?php

/********************************************************************************* 
  Purolator Public Web Services Example Code
  
  Written By  : Client Services, Purolator Courier Ltd.
                webservices@purolator.com
  
  Requires    : PHP SOAP extension enabled
              : Local copy of the PickUp Service WSDL
              : Valid Development/Production Key and Password
  
  This example covers the creation of a proper SOAP Client (including envelope 
  headers) to communicate with the Services Options Web Service.
*********************************************************************************/ 

//Define the Production (or development) Key and Password

define("PRODUCTION_KEY", "YOUR_PRODUCTION_KEY_HERE");
define("PRODUCTION_PASS", "YOUR_PRODUCTION_PASS_HERE");
define("USER_TOKEN", "YOUR_USER_TOKEN_HERE");

//Define the Billing account and the account that is registered with PWS
define("BILLING_ACCOUNT", "9999999999");
define("REGISTERED_ACCOUNT", "9999999999");


function createPWSSOAPClient()
{	
  /** Purpose : Creates a SOAP Client in Non-WSDL mode with the appropriate authentication and 
    *           header information
  **/
  //Set the parameters for the Non-WSDL mode SOAP communication with your Development/Production credentials
  $client = new SoapClient( "./wsdl/PickUpService.wsdl", 
                            array	(
                                    'trace'			=>	true,				        
				    'location'	=>	"https://devwebservices.purolator.com/EWS/V1/PickUp/PickUpService.asmx",				    
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
                                        'RequestReference'  =>  'Rating Example',
                                        'UserToken'         =>  USER_TOKEN
                                      )
                              ); 
  //Apply the SOAP Header to your client                            
  $client->__setSoapHeaders($headers);

  return $client;
}

/********************************************************************************* 
	Schedule PickUp Example(s)
	EXAMPLE 01:    
*********************************************************************************/ 

//Create a SOAP Client for this Example
$client = createPWSSOAPClient();

$request->PickUpHistorySearchCriteria->AccountNumber = "";
$request->PickUpHistorySearchCriteria->ConfirmationNumber = "";
$request->PickUpHistorySearchCriteria->FromDate = "2010-03-20";
$request->PickUpHistorySearchCriteria->MaxNumOfRecords = 10;
$request->PickUpHistorySearchCriteria->SortColumn = "";
$request->PickUpHistorySearchCriteria->SortDirection = "";
$request->PickUpHistorySearchCriteria->Status = "";
$request->PickUpHistorySearchCriteria->ToDate = "2010-03-30";
$request->PickUpHistorySearchCriteria->SortDirection = "";

//Execute the request and capture the response
$response = $client->GetPickUpHistory($request);


print "<pre>\n"; 
print "Request :\n".htmlspecialchars($client->__getLastRequest()) ."\n"; 
print "Response:\n".htmlspecialchars($client->__getLastResponse())."\n"; 
print "</pre>";
  
/** 
  * SOAP Request Envelope (Request Made from the SOAP Client)
  
  * <?xml version="1.0" encoding="UTF-8"?>
  * <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://purolator.com/pws/datatypes/v1"><SOAP-ENV:Header><ns1:RequestContext><ns1:Version>1.0</ns1:Version><ns1:Language>en</ns1:Language><ns1:GroupID>xxx</ns1:GroupID><ns1:RequestReference>Rating Example</ns1:RequestReference></ns1:RequestContext></SOAP-ENV:Header><SOAP-ENV:Body><ns1:GetPickUpHistoryRequest><ns1:PickUpHistorySearchCriteria><ns1:FromDate>2010-02-10</ns1:FromDate><ns1:ToDate>2010-03-19</ns1:ToDate><ns1:ConfirmationNumber>01365850</ns1:ConfirmationNumber><ns1:AccountNumber></ns1:AccountNumber><ns1:Status></ns1:Status><ns1:MaxNumOfRecords>10</ns1:MaxNumOfRecords><ns1:SortColumn></ns1:SortColumn><ns1:SortDirection></ns1:SortDirection></ns1:PickUpHistorySearchCriteria></ns1:GetPickUpHistoryRequest></SOAP-ENV:Body></SOAP-ENV:Envelope>
**/

/** 
  * SOAP Response Envelope (Request Returned from the Web Service)
  * <s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Header><h:ResponseContext xmlns:h="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><h:ResponseReference>Rating Example</h:ResponseReference></h:ResponseContext></s:Header><s:Body><GetPickUpHistoryResponse xmlns="http://purolator.com/pws/datatypes/v1" xmlns:i="http://www.w3.org/2001/XMLSchema-instance"><ResponseInformation i:nil="true"/><PickUpDetailList><PickUpDetail><BillingAccountNumber>1643671</BillingAccountNumber><PartnerId i:nil="true"/><ConfirmationNumber>01365850</ConfirmationNumber><PickupStatus>Scheduled</PickupStatus><PickupType>Regular</PickupType><PickupInstruction><Date>2010-03-20</Date><AnyTimeAfter>1200</AnyTimeAfter><UntilTime>1700</UntilTime><TotalWeight i:nil="true"/><TotalPieces>0</TotalPieces><BoxesIndicator i:nil="true"/><PickUpLocation>BackDoor</PickUpLocation><AdditionalInstructions i:nil="true"/><SupplyRequestCodes><SupplyRequestCode>PuroletterExpressEnvelope</SupplyRequestCode></SupplyRequestCodes><TrailerAccessible>false</TrailerAccessible><LoadingDockAvailable>false</LoadingDockAvailable><ShipmentOnSkids>false</ShipmentOnSkids><NumberOfSkids>0</NumberOfSkids></PickupInstruction><Address><Name i:nil="true"/><Company>ANOTHER COMPANY</Company><Department/><StreetNumber>5995</StreetNumber><StreetSuffix/><StreetName>AVEBURY</StreetName><StreetType>Road</StreetType><StreetDirection/><Suite>567</Suite><Floor>9</Floor><StreetAddress2 i:nil="true"/><StreetAddress3 i:nil="true"/><City>MISSISSAUGA</City><Province>ON</Province><Country>CA</Country><PostalCode>L5R3T8</PostalCode><PhoneNumber><CountryCode>1</CountryCode><AreaCode>905</AreaCode><Phone>7128101</Phone><Extension>9999</Extension></PhoneNumber><FaxNumber i:nil="true"/></Address><ShipmentSummary><ShipmentSummaryDetails><ShipmentSummaryDetail><DestinationCode>DOM</DestinationCode><TotalPieces>70</TotalPieces><TotalWeight><Value>100.0</Value><WeightUnit>kg</WeightUnit></TotalWeight></ShipmentSummaryDetail><ShipmentSummaryDetail><DestinationCode>INT</DestinationCode><TotalPieces>0</TotalPieces><TotalWeight><Value>0</Value><WeightUnit>kg</WeightUnit></TotalWeight></ShipmentSummaryDetail><ShipmentSummaryDetail><DestinationCode>USA</DestinationCode><TotalPieces>0</TotalPieces><TotalWeight><Value>0</Value><WeightUnit>kg</WeightUnit></TotalWeight></ShipmentSummaryDetail></ShipmentSummaryDetails></ShipmentSummary><NotificationEmails xmlns:a="http://schemas.microsoft.com/2003/10/Serialization/Arrays"><a:string>my.name@example.com</a:string></NotificationEmails></PickUpDetail></PickUpDetailList></GetPickUpHistoryResponse></s:Body></s:Envelope>
**/


$upper_limit=10;

PrintName("PickUp Detail List");

	if ($response->PickUpDetailList != null)
	{
		foreach( $response->PickUpDetailList as $pickupList )
		{
			$int_loop = 1;
			
			 if ( is_array($response->PickUpDetailList->PickUpDetail)) {
			 
				foreach( $response->PickUpDetailList->PickUpDetail  as $pickup )	
				{
						
					Push();									
					
					PrintPickUp($pickup, $int_loop);
									
					Pop();
					$int_loop++;
					
				}	
			}	
			else
			{
						
				foreach( $response->PickUpDetailList  as $pickup )	
				{
					PrintPickUp($pickup, 1);		
				}	
		}
		 
	Pop();

	}


	//Display the response
	//print_r($response);

}

function PrintPickUp($pickup, $stringLoop)
{

	Push();
				
				echo( "<br>" );
				PrintName("PickUp Detail " . $stringLoop);
				
				
				
					Push();
					PrintNameDesc("Billing Account:" , $pickup->BillingAccountNumber);
					PrintNameDesc("Partner ID:" , $pickup->PartnerId);
					PrintNameDesc("Confirmation Number:" ,$pickup->ConfirmationNumber);
					PrintNameDesc("Pickup Status:" ,$pickup->PickupStatus);
					PrintNameDesc("Pickup Type:" ,$pickup->PickupType);
				
					Pop();
			  
					PrintName("Pickup Instruction");
				 
						Push();
											
						PrintNameDesc("Date:" , $pickup->PickupInstruction->Date);
						PrintNameDesc("Anytime After:" , $pickup->PickupInstruction->AnyTimeAfter);
						PrintNameDesc("UntilTime:" , $pickup->PickupInstruction->UntilTime);
						PrintNameDesc("TotalPieces:" , $pickup->PickupInstruction->TotalPieces);
						PrintNameDesc("BoxesIndicator:" , $pickup->PickupInstruction->BoxesIndicator);
						PrintNameDesc("PickupLocation:" , $pickup->PickupInstruction->PickUpLocation);
						PrintNameDesc("AdditionalInstructions:" , $pickup->PickupInstruction->AdditionalInstructions);
					 
						PrintName("Supplies");
						//foreach( $response->PickUpDetailList as $pickup )
						if ($pickup->PickupInstruction->SupplyRequestCodes != null)
						{
							foreach ( $pickup->PickupInstruction->SupplyRequestCodes as $supplyreqcode )
							{
								Push();
								PrintNameDesc("SupplyRequestCodes:" ,$supplyreqcode);
								Pop();
							}
						}
						
						PrintNameDesc("Trailer Accessible:" ,$pickup->PickupInstruction->TrailerAccessible);
						PrintNameDesc("Loading Dock Available:" ,$pickup->PickupInstruction->LoadingDockAvailable);
						PrintNameDesc("Shipment On Skids:" , $pickup->PickupInstruction->ShipmentOnSkids);
						PrintNameDesc("Number of Skids:" , $pickup->PickupInstruction->NumberOfSkids);
						
						Pop();
			 
			 
					PrintName("Address");
					Push();
			
						PrintNameDesc("Contact Name:" ,$pickup->Address->Name);
						PrintNameDesc("Company Name:" ,$pickup->Address->Company);
						PrintNameDesc("Department:" ,$pickup->Address->Department);
						PrintNameDesc("Street  Number:" ,$pickup->Address->StreetNumber);
						PrintNameDesc("Street  Name:" ,$pickup->Address->StreetName);
						PrintNameDesc("Street  Suffix:" ,$pickup->Address->StreetSuffix);
						PrintNameDesc("Street  Type:" ,$pickup->Address->StreetType);
						PrintNameDesc("Street  Direction:" ,$pickup->Address->StreetDirection);
						PrintNameDesc("Suite:" ,$pickup->Address->Suite);
						PrintNameDesc("Floor:" ,$pickup->Address->Floor);
						PrintNameDesc("Address Line 2:" ,$pickup->Address->StreetAddress2);
						PrintNameDesc("Address Line 3:" ,$pickup->Address->StreetAddress3);
						PrintNameDesc("City:" ,$pickup->Address->City);
						PrintNameDesc("Province:" ,$pickup->Address->Province);	
						PrintNameDesc("Country:" ,$pickup->Address->Country);	
						PrintNameDesc("Postal Code:" ,$pickup->Address->PostalCode);	
						PrintNameDesc("Country Code:" ,$pickup->Address->PhoneNumber->CountryCode);	
						PrintNameDesc("Area Code:" ,$pickup->Address->PhoneNumber->AreaCode);	
						PrintNameDesc("Phone Number:" ,$pickup->Address->PhoneNumber->Phone);	
						PrintNameDesc("Extension:" ,$pickup->Address->PhoneNumber->Extension);	
						PrintNameDesc("Fax Number:" ,$pickup->Address->FaxNumber);	
					Pop();
			 
					PrintName("Shipment Summary Details");
					Push();
					
						foreach( $pickup->ShipmentSummary->ShipmentSummaryDetails->ShipmentSummaryDetail as $shipdetail ){
							PrintNameDesc("Destination Code:" , $shipdetail->DestinationCode);	
							PrintNameDesc("Total Pieces:" , $shipdetail->TotalPieces);	
							PrintNameDesc("Weight Unit:" , $shipdetail->TotalWeight->WeightUnit);	
							PrintNameDesc("Total Weight:" , $shipdetail->TotalWeight->Value);	
						}		 		
					Pop();
			 
					$array = (array)$pickup->NotificationEmails;
					foreach ( $array as $val){
						PrintNameDesc("Notification Email:" ,$val);	
					}
					
	Pop();
				


}

	function PrintNameDesc($name, $desc)
        {
		global $upper_limit;
		$i = 1;	
		echo( "<br>" );
		while($i <= $upper_limit) { echo "&nbsp;"; 
			$i++;} 
		echo( $name . $desc   );
			
        }
	
	function PrintName($name)
        {
		global $upper_limit;
		$i = 1;		
		echo( "<br>" );
		while($i <= $upper_limit) { echo "&nbsp;"; 
			$i++;} 
		echo( $name);
        }
	
	
function  Pop()
        {
		global $upper_limit;
		$upper_limit =$upper_limit - 10;			
		
        }
	
function  Push()
        {
		global $upper_limit;
		$upper_limit = $upper_limit + 10;			
        }
	
	
/**
  * EXPECTED RESULTS from PWS
(
	stdClass Object ( 
		[ResponseInformation] => 
		[PickUpDetailList] => stdClass Object 
		( 	[PickUpDetail] => stdClass Object 
			( 
				[BillingAccountNumber] => 1643671 
				[PartnerId] => 
				[ConfirmationNumber] => 01365850 
				[PickupStatus] => Scheduled 
				[PickupType] => Regular 
				[PickupInstruction] => stdClass Object 
				( 
					[Date] => 2010-03-20 
					[AnyTimeAfter] => 1200 
					[UntilTime] => 1700 
					[TotalWeight] => 
					[TotalPieces] => 0 
					[BoxesIndicator] => 
					[PickUpLocation] => BackDoor 
					[AdditionalInstructions] => 
					[SupplyRequestCodes] => stdClass Object 
					( 
						[SupplyRequestCode] => PuroletterExpressEnvelope 
					) 
					[TrailerAccessible] => 
					[LoadingDockAvailable] => 
					[ShipmentOnSkids] => 
					[NumberOfSkids] => 0 
				) 
				[Address] => stdClass Object 
				( 
					[Name] => 
					[Company] => ANOTHER COMPANY 
					[Department] => 
					[StreetNumber] => 5995 
					[StreetSuffix] => 
					[StreetName] => AVEBURY 
					[StreetType] => Road 
					[StreetDirection] => 
					[Suite] => 567 
					[Floor] => 9 
					[StreetAddress2] => 
					[StreetAddress3] => 
					[City] => MISSISSAUGA 
					[Province] => ON 
					[Country] => CA 
					[PostalCode] => L5R3T8 
					[PhoneNumber] => stdClass Object 
					( 
						[CountryCode] => 1 
						[AreaCode] => 905 
						[Phone] => 7128101 
						[Extension] => 9999 
					) 
					[FaxNumber] => 
				) 
				[ShipmentSummary] => stdClass Object 
				( 
					[ShipmentSummaryDetails] => stdClass Object 
					( 
						[ShipmentSummaryDetail] => Array
						( 
							[0] => stdClass Object 
							( 
								[DestinationCode] => DOM 
								[TotalPieces] => 70 
								[TotalWeight] => stdClass Object 
								( 
									[Value] => 100.0 
									[WeightUnit] => kg 
								) 
							) 
							[1] => stdClass Object 
							( 
								[DestinationCode] => INT 
								[TotalPieces] => 0 
								[TotalWeight] => stdClass Object 
								( 
									[Value] => 0 
									[WeightUnit] => kg 
									)
								) 
							[2] => stdClass Object 
							( 
								[DestinationCode] => USA 
								[TotalPieces] => 0 
								[TotalWeight] => stdClass Object 
								( 
									[Value] => 0 
									[WeightUnit] => kg 
								) 
							) 
						) 
					) 
				) 
				[NotificationEmails] => stdClass Object ( [string] => my.name@example.com ) 
			) 
		) 
	) 
	
)
**/
?>
