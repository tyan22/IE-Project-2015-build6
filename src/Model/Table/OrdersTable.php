<?php
namespace App\Model\Table;

use App\Model\Entity\Order;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Orders Model
 */
class OrdersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('orders');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id'
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id'
        ]);

        $this->belongsTo('Orderstatuses', [
            'foreignKey' => 'orderstatus_id'
        ]);
        $this->belongsTo('Paymentstatuses', [
            'foreignKey' => 'paymentstatus_id'
        ]);

        $this->hasMany('Invoices', [
            'foreignKey' => 'order_id'
        ]);

        $this->hasMany('Payments', [
            'foreignKey' => 'order_id'
        ]);

        $this->hasMany('Stashes', [
            'foreignKey' => 'order_id'
        ]);

        $this->hasMany('Messages', [
            'foreignKey' => 'order_id'
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
            ->add('customer_id', 'valid', ['rule' => 'numeric'])
            ->requirePresence('customer_id', 'create')
            ->notEmpty('customer_id')
            ->add('quote', 'valid', ['rule' => 'decimal'])
            ->allowEmpty('quote')
            ->requirePresence('order_type', 'create')
            ->allowEmpty('order_type')
            ->add('vendor_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('vendor_id')
            ->requirePresence('orderstatus_id', 'create')
            ->notEmpty('order_status_id')
            ->requirePresence('paymentstatus_id', 'create')
            ->notEmpty('paymentstatus_id')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

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
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));
        $rules->add($rules->existsIn(['orderstatus_id'], 'Orderstatuses'));
        $rules->add($rules->existsIn(['paymentstatus_id'], 'Paymentstatuses'));

        return $rules;
    }
}
