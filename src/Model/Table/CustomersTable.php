<?php
namespace App\Model\Table;

use App\Model\Entity\Customer;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
/**
 * Customers Model
 */
class CustomersTable extends Table
{


    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('customers');
        $this->displayField('fullName');
        $this->primaryKey('id');

        $this->belongsTo('States', [
            'foreignKey' => 'state_id'
        ]);

        $this->belongsTo('Titles', [
            'foreignKey' => 'title_id'
        ]);

        $this->hasMany('Anniversaries', [
            'foreignKey' => 'customer_id'
        ]);

        $this->hasMany('Orders', [
            'foreignKey' => 'customer_id'
        ]);

        $this->belongsTo('Monthbirthstones', [
            'foreignKey' => 'monthbirthstone_id'
        ]);

        $this->belongsTo('Zodiacbirthstones', [
            'foreignKey' => 'zodiac_id'
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
            ->add('phone', 'valid', ['rule' => 'numeric','message'=>'Please enter numbers only; no spaces, dashes or brackets'])
            ->notEmpty('firstname', 'A first name is required')
            ->notEmpty('surname', 'A surname is required')
            ->notEmpty('phone', 'A phone number is required')
            ->allowEmpty('id', 'create')
            ->add('dob', 'valid', ['rule' => 'date'])
            ->allowEmpty('dob')
            ->add('email', 'valid', ['rule' => 'email','message'=>'Please enter a valid email address'])
            ->add('phone', 'length', ['rule'=>['maxLength',10],'message'=>'Phone number cannot have more than 10 digits'])
            ->allowEmpty('email')
            ->allowEmpty('address')
            ->allowEmpty('suburb')
            ->allowEmpty('state_id')
            ->add('state_id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('zodiac_id')
            ->allowEmpty('postcode')
            ->allowEmpty('title_id')
            ->allowEmpty('comments')
            ->add('postcode', 'valid', ['rule' => 'numeric', 'message' => 'Postcode must be numeric']);

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
        $rules->add($rules->existsIn(['state_id'], 'States'));
        $rules->add($rules->existsIn(['title_id'], 'Titles'));
        return $rules;
    }
}
