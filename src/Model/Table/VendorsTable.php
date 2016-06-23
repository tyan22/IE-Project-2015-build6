<?php
namespace App\Model\Table;

use App\Model\Entity\Vendor;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vendors Model
 */
class VendorsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('vendors');
        $this->displayField('vendor_name');
        $this->primaryKey('id');
        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'vendor_id'
        ]);

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    //remove modified as we will handle it manually
                ]
            ]
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
            ->requirePresence('vendor_name', 'create')
            ->notEmpty('vendor_name')
            ->requirePresence('address', 'create')
            ->notEmpty('address')
            ->requirePresence('phone', 'create')
            ->notEmpty('phone')
            ->add('email', 'valid', ['rule' => 'email'])
            ->add('state_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('state_id', 'create')
            ->notEmpty('state_id')
            ->requirePresence('postcode', 'create')
            ->notEmpty('postcode')
            ->requirePresence('suburb', 'create')
            ->notEmpty('suburb')
            ->allowEmpty('contact_fname')
            ->allowEmpty('notes')
            ->allowEmpty('contact_sname')
            ->allowEmpty('specialty');


        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['state_id'], 'States'));
        return $rules;
    }
}
