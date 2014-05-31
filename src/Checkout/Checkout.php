<?php
namespace PHPSC\PagSeguro\Checkout;

use PHPSC\PagSeguro\Customer\Shipping;
use PHPSC\PagSeguro\Customer\Customer;

class Checkout
{
    /**
     * @var string
     */
    private $currency;

    /**
     * @var array
     */
    private $items;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @var Shipping
     */
    private $shipping;

    /**
     * @var float
     */
    private $extraAmount;

    /**
     * @var string
     */
    private $redirectUrl;

    /**
     * @var int
     */
    private $maxUses;

    /**
     * @var int
     */
    private $maxAge;

    /**
     * @param array $items
     * @param string $reference
     * @param Customer $customer
     * @param Shipping $shipping
     * @param float $extraAmount
     * @param string $redirectUrl
     * @param int $maxUses
     * @param int $maxAge
     */
    public function __construct(
        array $items,
        $reference = null,
        Customer $customer = null,
        Shipping $shipping = null,
        $extraAmount = null,
        $redirectUrl = null,
        $maxUses = null,
        $maxAge = null
    ) {
        $this->currency = 'BRL';
        $this->reference = $reference;
        $this->items = $items;
        $this->customer = $customer;
        $this->shipping = $shipping;
        $this->extraAmount = $extraAmount;
        $this->reference = $reference;
        $this->redirectUrl = $redirectUrl;
        $this->maxUses = $maxUses;
        $this->maxAge = $maxAge;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return Shipping
     */
    public function getShipping()
    {
        return $this->shipping;
    }

    /**
     * @return number
     */
    public function getExtraAmount()
    {
        return $this->extraAmount;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    /**
     * @return number
     */
    public function getMaxUses()
    {
        return $this->maxUses;
    }

    /**
     * @return number
     */
    public function getMaxAge()
    {
        return $this->maxAge;
    }
}
