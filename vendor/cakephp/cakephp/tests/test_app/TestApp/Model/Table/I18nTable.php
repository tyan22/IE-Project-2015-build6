<?php
/**
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright 2005-2013, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace TestApp\Model\Table;

use Cake\ORM\Table;

/**
 * I18n table class
 *
 */
class I18nTable extends Table
{

    public function initialize(array $config)
    {
        $this->table('custom_i18n_table');
    }

    public static function defaultConnectionName()
    {
        return 'custom_i18n_datasource';
    }
}
