<?php

namespace Picqer\Xero\Entities;

class Contact extends BaseEntity {

    protected $endpoint = '/contacts';
    protected $primaryKey = 'ContactId';

    protected $ContactID;
    protected $ContactStatus;
    protected $Name;
    protected $FirstName;
    protected $LastName;
    protected $EmailAddress;
    protected $IsSupplier;
    protected $IsCustomer;
    protected $DefaultCurrency;

    protected $Addresses = [];
    protected $Phones = [];

    protected $childEntities = [
        'Addresses' => 'ContactAddress',
        'Phones' => 'ContactPhone'
    ];
}