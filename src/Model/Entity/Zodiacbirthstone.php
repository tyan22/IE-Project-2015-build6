<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Zodiacbirthstone Entity.
 */
class Zodiacbirthstone extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'startdate' => true,
        'enddate' => true,
        'image' => true,
        'sign' => true,
        'customers' => true,
    ];
}
