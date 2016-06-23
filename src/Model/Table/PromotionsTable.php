<?php
namespace App\Model\Table;

use App\Model\Entity\Promotion;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Promotions Model
 *
 */
class PromotionsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('promotions');
        $this->displayField('title');
        $this->primaryKey('id');

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
            ->allowEmpty('id', 'create');



        $validator
            ->requirePresence('cust_group', 'create')
            ->notEmpty('cust_group');

        $validator
            ->requirePresence('headline', 'create')
            ->notEmpty('headline');

        $validator
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        $validator
            ->allowEmpty('promo_image');

        $validator
            ->add('test_mail_sent', 'valid', ['rule' => 'boolean'])
            ->requirePresence('test_mail_sent', 'create')
            ->notEmpty('test_mail_sent');

        $validator
            ->add('mail_out_completed', 'valid', ['rule' => 'boolean'])
            ->requirePresence('mail_out_completed', 'create')
            ->notEmpty('mail_out_completed');

        return $validator;
    }
}
