<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 */
class User extends Entity
{

    protected function _getFullName()
    {
        return $this->_properties['firstname'] . '  ' .
        $this->_properties['surname'];
    }
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'username' => true,
        'firstname' => true,
        'surname' => true,
        'password' => true,
        'group_id' => true,
        'email' => true,
        'group' => true,
    ];

    //take the password in and hash it, returning the hashed pwd
    protected function _setPassword($password)
    {
        return (new DefaultPasswordHasher)->hash($password);
    }
}
