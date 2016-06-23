<?php
/**
 * CakePHP(tm) Tests <http://book.cakephp.org/2.0/en/development/testing.html>
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://book.cakephp.org/2.0/en/development/testing.html CakePHP(tm) Tests
 * @since         1.2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Class WelcomeShell
 *
 */
namespace TestPluginTwo\Shell;

use Cake\Console\Shell;

class WelcomeShell extends Shell
{

    /**
     * say_hello method
     *
     * @return void
     */
    public function say_hello()
    {
        $this->out('This is the say_hello method called from TestPluginTwo.WelcomeShell');
    }
}
