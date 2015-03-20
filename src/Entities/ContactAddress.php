<?php

namespace Picqer\Xero\Entities;

class ContactAddress extends BaseEntity {

    protected $AddressType;
    protected $City;
    protected $Region;
    protected $PostalCode;
    protected $Country;
    protected $AttentionTo;
    protected $AddressLine1;
    protected $AddressLine2;
    protected $AddressLine3;
    protected $AddressLine4;

    public function getXmlCollectionName()
    {
        return 'Addresses';
    }

    public function getXmlName()
    {
        return 'Address';
    }
}