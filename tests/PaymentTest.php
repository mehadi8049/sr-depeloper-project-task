<?php

use PHPUnit\Framework\TestCase;

class PaymentTest extends TestCase{

    public function testClassConstructor()
    {
        $headers = getallheaders();
        if (!isset($headers['X-Mock-Status'])) {
           $status=false;
        }
        $this->assertFalse($status);
    }
}