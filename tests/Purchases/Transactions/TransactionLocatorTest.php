<?php
namespace PHPSC\PagSeguro\Purchases\Transactions;

use PHPSC\PagSeguro\Credentials;
use PHPSC\PagSeguro\Client\Client;

class TransactionLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Credentials
     */
    protected $credentials;

    /**
     * @var Client|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $client;

    /**
     * @var TransactionDecoder|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $decoder;

    /**
     * @var Transaction|\PHPUnit_Framework_MockObject_MockObject
     */
    private $transaction;

    protected function setUp()
    {
        $environment = $this->getMockForAbstractClass('PHPSC\PagSeguro\Environment');

        $environment->expects($this->any())
                    ->method('getHost')
                    ->willReturn('test.com');

        $environment->expects($this->any())
                    ->method('getWsHost')
                    ->willReturn('ws.test.com');

        $this->credentials = new Credentials('a@a.com', 't', $environment);
        $this->client = $this->getMock('PHPSC\PagSeguro\Client\Client', array(), array(), '', false);

        $this->decoder = $this->getMock(
            'PHPSC\PagSeguro\Purchases\Transactions\TransactionDecoder',
            array(),
            array(),
            '',
            false
        );

        $this->transaction = $this->getMock(
            'PHPSC\PagSeguro\Purchases\Transactions\Transaction',
            array(),
            array(),
            '',
            false
        );
    }

    /**
     * @test
     */
    public function getByCodeShouldDoAGetRequestAddingCredentialsData()
    {
        $xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><data />');

        $this->client->expects($this->once())
                     ->method('get')
                     ->with('https://ws.test.com/v2/transactions/1?email=a%40a.com&token=t')
                     ->willReturn($xml);

        $this->decoder->expects($this->once())
                      ->method('decode')
                      ->with($xml)
                      ->willReturn($this->transaction);

        $service = new TransactionLocator($this->credentials, $this->client, $this->decoder);

        $this->assertSame($this->transaction, $service->getByCode(1));
    }

    /**
     * @test
     */
    public function getByNotificationShouldDoAGetRequestAddingCredentialsData()
    {
        $xml = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><data />');

        $this->client->expects($this->once())
                     ->method('get')
                     ->with('https://ws.test.com/v2/transactions/notifications/1?email=a%40a.com&token=t')
                     ->willReturn($xml);

        $this->decoder->expects($this->once())
                      ->method('decode')
                      ->with($xml)
                      ->willReturn($this->transaction);

        $service = new TransactionLocator($this->credentials, $this->client, $this->decoder);

        $this->assertSame($this->transaction, $service->getByNotification(1));
    }
}
