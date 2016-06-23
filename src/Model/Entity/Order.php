<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Order Entity.
 */
class Order extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'customer_id' => true,
        'quote' => true,
        'order_type' => true,
        'vendor_id' => true,
        'description' => true,
        'orderstatus_id' => true,
        'paymentstatus_id' => true,
        'accessed' => true,
        'modified' => true,
        'deposit_paid' => true,
        'balance' => true

    ];


    protected function _getPaymentStatusName()
    {
        $names = TableRegistry::get('Paymentstatuses');
        $query = $names->find()->where(['Paymentstatuses.id' => $this->_properties['paymentstatus_id']])->first();
        return $query->name;
    }

    protected function _getOrderStatusName()
    {
        $names = TableRegistry::get('Orderstatuses');
        $query = $names->find()->where(['Orderstatuses.id' => $this->_properties['orderstatus_id']])->first();
        return $query->name;
    }

    protected function _getVendorName()
    {
        $names = TableRegistry::get('Vendors');
        $query = $names->find()->where(['Vendors.id' => $this->_properties['vendor_id']])->first();
        return $query->name;
    }
}
