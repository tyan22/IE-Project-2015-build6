<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Anniversarytype Entity.
 */
class Anniversarytype extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'type' => true,
        'anniversaries' => true,
    ];
}
