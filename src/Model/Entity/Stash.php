<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Stash Entity.
 */
class Stash extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'order_id' => true,
        'filename' => true,
        'filepath' => true,
        'filetype' => true,
        'visible' => true,
        'order' => true,
    ];
}
