<?php

function jahanpayd_config() 
{
    return array(
		 'FriendlyName' => array('Type' => 'System', 'Value'=>'جهان پي'),
		 'merchantID' => array('FriendlyName' => 'merchantID', 'Type' => 'text', 'Size' => '50', ),
		 'Currencies' => array('FriendlyName' => 'Currencies', 'Type' => 'dropdown', 'Options' => 'Rial,Toman', ),
	);	
}

function jahanpayd_link($params) 
{

	$merchantID = $params['merchantID'];
    $currencies = $params['Currencies'];
   
    

	$invoiceid = $params['invoiceid'];
	$description = $params['description'];
    $amount = $params['amount']; # Format: ##.##
    $currency = $params['currency']; # Currency Code

	# Client Variables
	$firstname = $params['clientdetails']['firstname'];
	$lastname = $params['clientdetails']['lastname'];
	$email = $params['clientdetails']['email'];
	$address1 = $params['clientdetails']['address1'];
	$address2 = $params['clientdetails']['address2'];
	$city = $params['clientdetails']['city'];
	$state = $params['clientdetails']['state'];
	$postcode = $params['clientdetails']['postcode'];
	$country = $params['clientdetails']['country'];
	$phone = $params['clientdetails']['phonenumber'];

	# System Variables
	$companyname = $params['companyname'];
	$systemurl = $params['systemurl'];
	$currency = $params['currency'];

	$code = '
    <form method="post" action="./jahanpayd.php">
        <input type="hidden" name="merchantID" value="'.$merchantID.'" />
        <input type="hidden" name="invoiceid" value="'.$invoiceid.'" />
        <input type="hidden" name="amount" value="'.$amount.'" />
        <input type="hidden" name="currencies" value="'.$currencies.'" />
        <input type="hidden" name="systemurl" value="'.$systemurl.'" />
        <input type="submit" name="pay" value=" پرداخت " />
    </form>
    ';

	return $code;
}
?>