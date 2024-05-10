<?php 

namespace App\Controllers;
                                                                                             
use App\Controllers\Controller;
use Exception;

class PaymentController extends Controller{
	
	public function create($_get){
		
		try {                                                     
			$headers = getallheaders();
			if (!isset($headers['X-Mock-Status'])) {
				throw new Exception("X-Mock-Status is not set.",422);
			}
            // reurn a url that get a payment gateway
			$mock_url='http:://example.payment.com/someparamas';
			return json_response([                                                             
				'status' => 'success',
				'message' => null,
				'data' => ['payment_url'=>$mock_url],
			],200);
		}catch(Exception $e) {                                                                                                                                                                                                                    
			return json_response([
				'status' => 'failed',
				'errors' => $e->getMessage(),
				'data' => [],
			],$e->getCode());
		}
	}

	public function create_payment($_post){
		
		try {
			$user_id=$_post['user_id'];
			#store neccessary information accordingly for all scenarios, and generate a transaction ID
			$transaction_id=strRandom(20); #custom function, It is a helper function. It is located in app -> Helper -> functions.php
			$callback_url=env('APP_URL')."/api-v1-callback?status=success&user_id=".$user_id."&transaction_id=".$transaction_id;
			return json_response([
				'status' => 'success',
				'message' => 'Payment is created.',
				'data' => ['callback_url'=>$callback_url],
			],200);
		}catch(Exception $e) {
			$callback_url=env('APP_URL')."/api-v1-callback?status=failed";
			return json_response([
				'status' => 'failed',
				'errors' => $e->getMessage(),
				'data' => ['callback_url'=>$callback_url],
			],$e->getCode());
		}
	}

	public function callback($_get){
	
		try {
			$status=$_get['status'];
			if($status=='failed'){
			   throw new Exception("Something is wrong.",400);
			}
			$user_id=$_get["user_id"];
			$transaction_id=$_get['transaction_id'];

			#update the record into database here

			return json_response([
				'status' => 'success',
				'message' => "Payment is completed succesfully.",
				'data' => [],
			],200);
		}catch(Exception $e) {
			return json_response([
				'status' => 'failed',
				'errors' => $e->getMessage(),
				'data' => [],
			],$e->getCode());
		}
	}

}