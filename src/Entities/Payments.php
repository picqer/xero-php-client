<?php
namespace Picqer\Xero\Entities;
class Payment extends BaseEntity {
    protected $Payment = [];
    public function getPrimaryKey()
    {
        return 'PaymentID';
    }
    public function getEndpoint()
    {
        return '/payments';
    }
    public function getXmlName()
    {
        return 'Payment';
    }
    protected function getChildEntities()
    {
        return [
            'Payment' => 'Payment'
        ];
    }
    function addPayment($payment){
        $this->Payment[] = $payment;
    }
}
