<?php

namespace Picqer\Xero\Entities;

class Contact extends BaseEntity {

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

    protected function getChildEntities()
    {
        return [
            'Addresses' => 'ContactAddress',
            'Phones' => 'ContactPhone'
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