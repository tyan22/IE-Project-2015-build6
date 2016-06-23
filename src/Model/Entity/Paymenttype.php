<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Paymenttype Entity.
 */
class Paymenttype extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'payments' => true,
    ];
}
