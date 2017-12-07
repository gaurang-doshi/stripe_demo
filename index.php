<?php 
error_reporting(E_ALL);

function getStripeResponse($cardNo,$exMonth,$exYear,$cvc,$currency,$amount,$description)
{

	require_once('stripe/init.php');

	\Stripe\Stripe::setApiKey('Your test key');
try {

	$response =\Stripe\Token::create(array(
	  "card" => array(
	    "number" => $cardNo,
	    "exp_month" => $exMonth,
	    "exp_year" => $exYear,
	    "cvc" => $cvc
	  )
	));
}
catch(\Stripe\Error\Card $e){
	return $e->getMessage();
    //echo $e->getMessage();
}

//pr($response1);
	$response = $response->__toArray(true);
	/*echo "<pre>";
	 print_r($response1);
	 exit;*/

	\Stripe\Stripe::setApiKey('sk_test_Gg5hYZnTggVnKgcy00Ujm4K6');

	$response = \Stripe\Charge::create(array(
	  "amount" => $amount,
	  "currency" => $currency,
	  "source" => $response['id'], // obtained with Stripe.js //"tok_198T11Kboj5use19xjO2vaHR"
	  "description" => $description
	));

	return $response;
	exit;
}

	if (isset($_POST["payamout"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
		extract($_POST);
		
		//print_r($_POST);
		//exit;

		$objPost = new stdClass();

		$objPost->amount = (int) isset($amount) ? $amount : 0;
		$objPost->exmonth = (int) isset($exmonth) ? $exmonth : 0;
		$objPost->exyear = (int) isset($exyear) ? $exyear : 0;
		$objPost->cvc = (int) isset($cvc) ? $cvc : 0;
		$objPost->cardno = (int) isset($cardno) ? $cardno : 0;

		if ($objPost->amount != '' && $objPost->exmonth != '' && $objPost->exyear != '' && $objPost->cvc != '' && $objPost->cardno != '') {
			
			

			$cardNo = $objPost->cardno;
			$exMonth = $objPost->exmonth;
			$exYear = $objPost->exyear;
			$cvc = $objPost->cvc;
			$currency = 'usd';
			$amount = $objPost->amount;
			$description = 'payment';
			
			$getPaymentRes = getStripeResponse($cardNo,$exMonth,$exYear,$cvc,$currency,$amount,$description);

			 $getPaymentRes['id'];
			 $getPaymentRes['amount'];
			 $getPaymentRes['description'];//
			 $getPaymentRes['failure_message'];//
			 $getPaymentRes['paid'];//1 
			 $getPaymentRes['outcome']['seller_message'];//Payment complete.

			 print_r($getPaymentRes).'</br>';
			 exit;


		}


	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Stripe demo</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
	<div class="col-lg-3"></div>
	<div class="col-lg-6" align="center" style="border: 1px solid black; align:center">
		<form action="index.php" name="frm" id="frm" method="post" >
			<div class="form-group">
		        <label>Stripe</label>                                
		    </div>
		    <div class="form-group">
		        <label><font color="#FF0000">*</font>Amount</label>
		        <input type="text" class="form-control" id="amount" name="amount">
		    </div>
		    <div class="form-group">
		        <label><font color="#FF0000">*</font>Card No</label>
		        <input type="text" class="form-control" id="cardno" name="cardno">
		    </div>
		    <div class="form-group">
		         <label><font color="#FF0000">*</font>Expiry Month</label>
		         <select name="exmonth" class="form-control">
		         	<option value="">Select Month</option>
		         	<option value=1>1</option>
		         	<option value=2>2</option>
		         	<option value=3>3</option>
		         	<option value=4>4</option>
		         	<option value=5>5</option>
		         	<option value=6>6</option>
		         	<option value=7>7</option>
		         	<option value=8>8</option>
		         	<option value=9>9</option>
		         	<option value=10>10</option>
		         	<option value=11>11</option>
		         	<option value=12>12</option>
		         </select>
		     </div>

		     <div class="form-group">
		         <label><font color="#FF0000">*</font>Expiry Year</label>
		         <select name="exyear" class="form-control">
				     <option value="">Select Year</option>
				     <option value=2017>2017</option>
				     <option value=2018>2018</option>
				     <option value=2019>2019</option>
				     <option value=2020>2020</option>
				     <option value=2021>2021</option>
				     <option value=2022>2022</option>
				     <option value=2023>2023</option>
				     <option value=2024>2024</option>
				     <option value=2025>2025</option>
				     <option value=2026>2026</option>
				     <option value=2027>2027</option>
				     <option value=2028>2028</option>
				     <option value=2029>2029</option>
				     <option value=2030>2030</option>
				     <option value=2031>2031</option>
				     <option value=2032>2032</option>
		     	</select>
		     </div>
		    <div class="form-group">
		         <label ><font color="#FF0000">*</font>CVV No</label>
		         <input type="text" class="form-control" id="cvc" name="cvc">
		    </div>
			<button type="submit" name="payamout" class="btn btn-primary">Pay</button>			
		</form>
	</div>   
</body>
</html>
