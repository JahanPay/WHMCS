<?php
	session_start();
    $amount=strtok($_POST['amount'],'.');
    if($_POST['currencies']=='Rial')    
		$amount = $amount/10;
		
    $callBackUrl = $_POST['systemurl'].'/modules/gateways/callback/jahanpayd.php?invoiceid='.$_POST['invoiceid'];
  
	$client = new SoapClient("http://www.jpws.me/directservice?wsdl");
	$res = $client->requestpayment($_POST['merchantID'], $amount , $callBackUrl , $_POST['invoiceid']);
	
	if($res['result']==1)
	{
		$au = $res['au']; // dar database save conid b hamrahe order_id , amount
		
		$_SESSION['jahanpay'][$_POST['invoiceid']] = array(
			'au'=>$au ,
			'amount'=>$amount ,
		);
		echo "<div style='display:none'>{$res['form']}</div>Please wait ... <script language='javascript'>document.jahanpay.submit(); </script>";
		
	}
	else
	{
		echo '<meta charset=utf-8><pre>';
		$res = array_map('urldecode',$res);
		print_r($res);
		die;
	}
?>