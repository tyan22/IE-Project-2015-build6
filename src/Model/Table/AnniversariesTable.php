<?php
namespace App\Model\Table;

use App\Model\Entity\Anniversary;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Anniversaries Model
 */
class AnniversariesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('anniversaries');
        $this->displayField('anniversarytype_id');
        $this->primaryKey('id');
        $this->belongsTo('Anniversarytypes', [
            'foreignKey' => 'anniversarytype_id'
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id'
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
            ->add('anniversarytype_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('anniversarytype_id', 'create')
            ->notEmpty('anniversarytype_id')
            ->add('customer_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('customer_id', 'create')
            ->notEmpty('yearknown')
            ->requirePresence('yearknown', 'create')
            ->notEmpty('customer_id')
            ->add('anniversarydate', 'valid', ['rule' => 'date'])
            ->allowEmpty('anniversarydate');

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
        $rules->add($rules->existsIn(['anniversarytype_id'], 'Anniversarytypes'));
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        return $rules;
    }
}
