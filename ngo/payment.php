<?php
require('connection.inc.php');
 $name =$_POST['name'];
 $email=$_POST['email'];
 $mobile=$_POST['mobile'];
 $amount=$_POST['amount'];
 $purpose='donation';

//  $sql="INSERT INTO `users` (`name`, `email`, `mobile`, `amount`) VALUES ('$name', '$email', '$mobile', '$amount')";
//  $res=mysqli_query($con,$sql);
 
 include 'Instamojo.php';
 $api = new Instamojo\Instamojo('test_88a4d24425b475c595e1b22de1c','test_e2f511e311b651247d464503d97', 'https://test.instamojo.com/api/1.1/');
 
 try {
    $response = $api->paymentRequestCreate(array(
        "purpose" => $purpose,
        "amount" => $amount,
        "send_email" => true,
        "email" => $email,
		"buyer_name"=>$name,
		"phone"	=> $mobile,
		"send_sms"=> true,
		"allow_repeated_payments"=> false,
        "redirect_url" => "http://localhost/ngo/thankyou.php"
		//"webhook"=>
        ));
    print_r($response);
    // die();
    $sql="INSERT INTO `users` (`name`, `email`, `mobile`, `amount`) VALUES ('$name', '$email', '$mobile', '$amount')";
    $res=mysqli_query($con,$sql);
	$pay_url=$response['longurl'];
	header("location:$pay_url");
	}
catch (Exception $e) {
    print('Error: ' . $e->getMessage());
	}
