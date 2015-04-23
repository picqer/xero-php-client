<?php

namespace Picqer\Xero\Entities;

class Contact extends BaseEntity {

    protected $ContactID;
    protected $ContactNumber;
    protected $AccountNumber;
    protected $ContactStatus;
    protected $Name;
    protected $FirstName;
    protected $LastName;
    protected $EmailAddress;
    protected $IsSupplier;
    protected $IsCustomer;
    protected $BankAccountDetails;
    protected $Website;
    protected $DefaultCurrency;
    protected $TaxNumber;

    protected $Addresses = [];
    protected $Phones = [];

    protected function getChildEntities()
    {
        return [
            'Addresses' => 'ContactAddress',
            'Phones'    => 'ContactPhone'
        ];
    }

    protected function getForeignEntities()
    {
        return [
        ];
    }

    public function getPrimaryKey()
    {
        return 'ContactID';
    }

    public function getEndpoint()
    {
        return '/contacts';
    }

    public function getXmlName()
    {
        return 'Contact';
    }


}