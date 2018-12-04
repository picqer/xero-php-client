<?php
namespace Picqer\Xero\Entities;
class PaymentAccount extends BaseEntity
{
    protected $AccountID;
    public function getXmlName()
    {
        return 'Account';
    }
}