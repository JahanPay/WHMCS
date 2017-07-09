<?php

session_start();

	error_reporting(0);
	
	if(file_exists('../../../init.php'))
	{
		define( 'WHMCSDBCONNECT', true );
		require( '../../../init.php' );
	
	}else{
		
		require("../../../dbconnect.php");
	}
	
    include('../../../includes/functions.php');
    include('../../../includes/gatewayfunctions.php');
    include('../../../includes/invoicefunctions.php');

    $gatewaymodule = 'jahanpayd'; 

    $GATEWAY = getGatewayVariables($gatewaymodule);
    if (!$GATEWAY['type']) die('Module Not Activated'); 
    
    $invoiceid = $_GET['invoiceid'];
    $data = $_SESSION['jahanpay'][$invoiceid];
	$amount=$data['amount'];
	$transid=$data['au'];
	
	if(empty($data['amount']))
		die('error');

    $invoiceid = checkCbInvoiceID($invoiceid,$GATEWAY['name']); 

    checkCbTransID($transid); 
    $price = $amount;
   
	
	$client = new SoapClient("http://www.jpws.me/directservice?wsdl");
	$res = $client->verification($GATEWAY['merchantID'] , $data['amount'] , $data['au'] , $invoiceid, $_POST + $_GET );
    
    if($GATEWAY['Currencies']=='Rial')    
		$amount = $amount*10;
    $fee = 0;
    
    if (!empty($res) and $res['result']==1) 
	{
        addInvoicePayment($invoiceid,$res['bank_au'],$amount,$fee,$gatewaymodule); 
        logTransaction($GATEWAY['name'],$_POST,'Successful'); 
    } 
	else 
	{
        logTransaction($GATEWAY['name'],$_POST,'Unsuccessful'); 
    }
	$url = $CONFIG['SystemURL'].'/viewinvoice.php?id='.$invoiceid;
die("<script>window.location='$url';</script>");
    header('Location: '.$CONFIG['SystemURL'].'/viewinvoice.php?id='.$invoiceid);
	
    
?>