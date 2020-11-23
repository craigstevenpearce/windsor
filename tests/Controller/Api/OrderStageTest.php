<?php
namespace App\Tests\OrderStageTest;

use App\Controller\OrderStageController;
use PHPUnit\Framework\TestCase;

class OrderStageUpdateTest extends TestCase
{
    /*
    Using Guzzle HTTP, we'll post to the end point URL for each test
    */

    /*
    Overall test to make sure the end point URL is behaving correctly
    */
    public function testPost()
    {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $data = array('request' => 'test', 'order' => 0);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        // The response contains the "Location" header
        $this->assertTrue($response->hasHeader('Location'));

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (POST TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the "request" is returned as "test"
        // ... 1 The key "request" exists
        $this->assertArrayHasKey('request', $responseData);
        // ... 2 the value of "request" is "test"
        $this->assertEquals('test', $responseData['request']);

        // Finally, make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);
    }

    /*
    Set a free trial to expired
    */
    public function testExpiredTrial() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = 1;

        $data = array('request' => 'expired', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (EXPIRE TRIAL TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Did the customer email fire off?
        $this->assertEquals('CustomerSent:Yes', $responseData['message']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Expired', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Attempt to set a contract to expired (SHOULD FAIL WITH ERROR)
    */
    public function testExpiredContract() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = 4;

        $data = array('request' => 'expired', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (EXPIRE CONTRACT TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(1, $responseData['error']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Created', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Set a contract to Signed
    */
    public function testSignedContract() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = 5;

        $data = array('request' => 'signed', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (SIGNED CONTRACT TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Did the PDF get stored?
        $this->assertEquals('PDFStored:Yes', $responseData['message']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Signed', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Attempt to set a trial to signed (SHOULD FAIL WITH ERROR)
    */
    public function testSignedTrial() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = 2;

        $data = array('request' => 'signed', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (SIGNED TRIAL TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(1, $responseData['error']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => 1);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Created', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => 1);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Set to Approved
    */
    public function testApproved() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = rand(1,6);

        $data = array('request' => 'approved', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (APPROVED TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Did the customer email fire off?
        $this->assertEquals('CustomerSent:Yes', $responseData['message']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Approved', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Set to Delivered
    */
    public function testDelivered() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = rand(1,6);

        $data = array('request' => 'delivered', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (DELIVERED TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Did the sales email fire off?
        $this->assertEquals('SalesSent:Yes', $responseData['message']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Delivered', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Set to Completed
    */
    public function testCompleted() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $id = rand(1,6);

        $data = array('request' => 'completed', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (COMPLETED TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Completed', $responseData['message']);

        // Reset order
        $data = array('request' => 'reset', 'order' => $id);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Create new trial order
    */
    public function testCreatedTrial() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $customer = rand(1,3);

        $data = array('request' => 'created', 'order' => 0, 'product' => 'Test Product', 'type' => 'trial', 'net' => 0, 'user' => 1, 'customer' => $customer);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (CREATE TRIAL TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Did the customer email fire off?
        $this->assertEquals('CustomerSent:Yes', $responseData['message']);

        $newID = $responseData['newID'];

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $newID);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Created', $responseData['message']);

        // Delete order
        $data = array('request' => 'delete', 'order' => $newID);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }

    /*
    Create new trial order
    */
    public function testCreatedContract() {
        $client = new \GuzzleHttp\Client([
          'base_uri' => 'http://webserver:80'
        ]);

        $customer = rand(1,3);

        $data = array('request' => 'created', 'order' => 0, 'product' => 'Test Product', 'type' => 'contract', 'net' => rand(100,1000), 'user' => 1, 'customer' => $customer);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        // We get the correct status code for an API call 201
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = json_decode($response->getBody(true), true);

        // I like to see the output of each test
        echo "\r\n\r\n" . 'RESPONSE (CREATE CONTRACT TEST):' . "\r\n";
        echo $response->getBody(true);

        // Make sure the error code is 0
        $this->assertEquals(0, $responseData['error']);

        // Did the customer email fire off?
        $this->assertEquals('CustomerSent:Yes', $responseData['message']);

        $newID = $responseData['newID'];

        // Check that the change has gone through
        $data = array('request' => 'check', 'order' => $newID);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);

        echo "\r\n\r\n" . $response->getBody(true);

        $responseData = json_decode($response->getBody(true), true);

        $this->assertEquals('Created', $responseData['message']);

        // Delete order
        $data = array('request' => 'delete', 'order' => $newID);

        $response = $client->post('/api/orderstage', ['body' => json_encode($data)]);
    }
}
?>
