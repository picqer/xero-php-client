<?php

namespace Picqer\Xero\Entities;

class ContactPhone extends BaseEntity {

    protected $PhoneType;
    protected $PhoneNumber;
    protected $PhoneAreaCode;
    protected $PhoneCountryCode;

    public function getXmlCollectionName()
    {
        return 'Phones';
    }

    public function getXmlName()
    {
        return 'Phone';
    }
}