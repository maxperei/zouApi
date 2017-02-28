<?php

namespace AppBundle\Tests\Rest;

use Guzzle\Http\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRestTest extends \PHPUnit\Framework\TestCase
{
    public function testRegister()
    {
        $client = new Client('http://localhost:8000', array(
            'request.options' => array(
                'exceptions' => false,
            )
        ));

        $pseudo = 'NickName'.rand(0, 999);
        $pass = base64_encode(random_bytes(20));
        $char = "0123456789abcdefghijklmnopqrstuvwxyz";
        $dom = array("com", "net", "gov", "org", "edu", "biz", "info");
        $email = substr($char, mt_rand(0, strlen($char)), 5). "@".substr($char, mt_rand(0, strlen($char)), 7).".". $dom[mt_rand(0, (sizeof($dom)-1))];

        $data = array(
            'username' => $pseudo,
            'plainPassword' => $pass,
            'email' => $email
        );

        $request = $client->post('/register', null, json_encode($data));
        $response = $request->send();

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $this->assertEquals('POST', $response->getHeader('Allow'));
        $this->assertEquals('application/json', $response->getHeader('Content-Type'));
    }
}
