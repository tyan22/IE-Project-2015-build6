<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity.
 */
class Payment extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'txnid' => true,
        'payment_amount' => true,
        'payment_type' => true,
        'trans_status' => true,
        'item_name' => true,
        'order_id' => true,
        'createdtime' => true

    ];
}
