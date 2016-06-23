<?php
namespace App\Model\Table;

use App\Model\Entity\Stash;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stashes Model
 */
class StashesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('stashes');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Orders', [
            'foreignKey' => 'order_id'
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
            ->add('order_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('order_id', 'create')
            ->notEmpty('order_id')
            ->requirePresence('filename', 'create')
            ->notEmpty('filename')
            ->notEmpty('uploaded')
            ->requirePresence('visible', 'create')
            ->notEmpty('visible');
            //created date not needed here as database will set as default
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
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        return $rules;
    }
}
