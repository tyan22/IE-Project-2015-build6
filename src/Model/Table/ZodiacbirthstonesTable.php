<?php
namespace App\Model\Table;

use App\Model\Entity\Zodiacbirthstone;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Zodiacbirthstones Model
 */
class ZodiacbirthstonesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('zodiacbirthstones');
        $this->displayField('sign');
        $this->primaryKey('id');
        $this->hasMany('Customers', [
            'foreignKey' => 'zodiac_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create')
            ->requirePresence('name', 'create')
            ->notEmpty('name')
            ->add('startdate', 'valid', ['rule' => 'date'])
            ->requirePresence('startdate', 'create')
            ->notEmpty('startdate')
            ->add('enddate', 'valid', ['rule' => 'date'])
            ->requirePresence('enddate', 'create')
            ->notEmpty('enddate')
            ->requirePresence('image', 'create')
            ->notEmpty('image')
            ->requirePresence('sign', 'create')
            ->notEmpty('sign');

        return $validator;
    }
}
