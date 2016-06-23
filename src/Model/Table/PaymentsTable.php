<?php
namespace App\Model\Table;

use App\Model\Entity\Payment;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payments Model
 */
class PaymentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('payments');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Paymenttypes', [
            'foreignKey' => 'payment_type'
        ]);
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
            ->add('payment_amount', 'valid', ['rule' => 'decimal'])
            ->requirePresence('payment_amount', 'create')
            ->notEmpty('payment_amount')
            ->add('order_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('order_id', 'create')
            ->notEmpty('order_id');

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
        //$rules->add($rules->existsIn(['paymenttype_id'], 'Paymenttypes'));
        $rules->add($rules->existsIn(['order_id'], 'Orders'));
        return $rules;
    }
}
