<?php
namespace App\Model\Table;

use App\Model\Entity\Setting;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Settings Model
 *
 */
class SettingsTable extends Table
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

        $this->table('settings');
        $this->displayField('id');
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
            ->requirePresence('business_name', 'create')
            ->notEmpty('business_name');

        $validator
            ->requirePresence('phone', 'create')
            ->notEmpty('phone');

        $validator
            ->requirePresence('admin_email', 'create')
            ->notEmpty('admin_email');

        $validator
            ->requirePresence('enquiry_email', 'create')
            ->notEmpty('enquiry_email');

        $validator
            ->add('gst_rate', 'valid', ['rule' => 'numeric'])
            ->requirePresence('gst_rate', 'create')
            ->notEmpty('gst_rate');

        $validator
            ->requirePresence('abn', 'create')
            ->notEmpty('abn');

        $validator
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->requirePresence('website', 'create')
            ->notEmpty('website');

        return $validator;
    }
}
