<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Message Entity.
 */
class Message extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'order_id' => true,
        'from_cust' => true,
        'message' => true,
        'name' => true,
        'msg_date' => true,
        'order' => true,
    ];
}
