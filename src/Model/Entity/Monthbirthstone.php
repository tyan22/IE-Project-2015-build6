<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Monthbirthstone Entity.
 */
class Monthbirthstone extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'month' => true,
        'image' => true,
        'customers' => true,
    ];
}
