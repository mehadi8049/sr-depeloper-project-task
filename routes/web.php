<?php

	Router::get('/api-v1-create', 'App\Controllers\PaymentController@create');

	Router::post('/api-v1-create-payment', 'App\Controllers\PaymentController@create_payment');

	Router::get('/api-v1-callback', 'App\Controllers\PaymentController@callback');

