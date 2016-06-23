<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity.
 */
class Vendor extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'vendor_name' => true,
        'address' => true,
        'phone' => true,
        'email' => true,
        'speciality' => true,
        'state_id' => true,
        'postcode' => true,
        'suburb' => true,
        'notes' => true,
        'contact_fname' => true,
        'contact_sname' => true,
        'states' => true,
        'orders' => true,
    ];
}
