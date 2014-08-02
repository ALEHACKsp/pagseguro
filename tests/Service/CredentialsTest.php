<?php
namespace PHPSC\PagSeguro\Service;

class CredentialsTest extends \PHPUnit_Framework_TestCase
{
    public function testRealCase01()
    {
        $email = 'contato@phpsc.com.br';
        $token = md5(time());
        $credentials = new Credentials($email, $token);

        $this->assertEquals($email, $credentials->getEmail());
        $this->assertEquals($token, $credentials->getToken());
    }
}
