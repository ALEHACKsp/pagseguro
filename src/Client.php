<?php
namespace PHPSC\PagSeguro;

use Guzzle\Common\Event;
use Guzzle\Http\Client as HttpClient;

/**
 * @author Luís Otávio Cobucci Oblonczyk <lcobucci@gmail.com>
 */
class Client
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client = null)
    {
        $this->client = $client ?: new HttpClient();
        $this->client->getEventDispatcher()->addListener('request.error', array($this, 'handleError'));
    }

    /**
     * @param Event $event
     *
     * @throws PagSeguroException
     */
    public function handleError(Event $event)
    {
        if (!in_array($event['request']->getHost(), array(BaseService::HOST, BaseService::SANDBOX_HOST))) {
            return ;
        }

        $response = $event['response'];

        if ($response->getStatusCode() == 400) {
            throw PagSeguroException::createFromXml($response->xml());
        }

        throw new PagSeguroException(
            '[' . $response->getStatusCode() . '] A HTTP error has occurred: '
            . $response->getBody(true)
        );
    }

    /**
     * @param string $url
     * @param array $fields
     *
     * @return SimpleXMLElement
     */
    public function post($url, array $fields = null)
    {
        $request = $this->client->post(
            $url,
            null,
            $fields ? http_build_query($fields) : null,
            array(
                'verify' => false,
                'headers' => array(
                    'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8'
                )
            )
        );

        return $request->send()->xml();
    }

    /**
     * @param string $url
     *
     * @return SimpleXMLElement
     */
    public function get($url)
    {
        $request = $this->client->get(
            $url,
            null,
            array('verify' => false)
        );

        return $request->send()->xml();
    }
}
