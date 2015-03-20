<?php

namespace Picqer\Xero\Entities;

class ContactPhone extends BaseEntity {

    protected $endpoint = '/contacts';
    protected $primaryKey = 'ContactId';

    protected $PhoneType;
    protected $PhoneNumber;
    protected $PhoneAreaCode;
    protected $PhoneCountryCode;
}