<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * Anniversary Entity.
 */
class Anniversary extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'anniversarytype_id' => true,
        'customer_id' => true,
        'anniversarydate' => true,
        'anniversarytype' => true,
        'yearknown' => true,
        'customer' => true,
    ];

    protected function _getAnniversaryType()
    {
        $types = TableRegistry::get('Anniversarytypes');
        $query = $types->find()->where(['Anniversarytypes.id' => $this->_properties['anniversarytype_id']])->first();
        return $query->type;
    }
}
