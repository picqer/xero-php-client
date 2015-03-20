<?php

namespace Picqer\Xero\Entities;

class ContactAddress extends BaseEntity {

    protected $endpoint = '/contacts';
    protected $primaryKey = 'ContactId';

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
}