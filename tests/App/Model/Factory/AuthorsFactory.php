<?php
/**
 * CakephpFactoryMuffin plugin for CakePHP Rapid Development Framework
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Evgeny Tomenko
 * @since         CakephpFactoryMuffin 1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace CakephpFactoryMuffin\Test\App\Model\Factory;

use CakephpFactoryMuffin\Model\Factory\AbstractFactory;
use League\FactoryMuffin\Faker\Facade as Faker;

/**
 * Class AuthorsFactory
 *
 * @package CakephpFactoryMuffin\Test\App\Model\Factory
 */
class AuthorsFactory extends AbstractFactory
{

    /**
     * @inheritdoc
     */
    public function definition()
    {
        return [
            'name' => Faker::name(),
        ];
    }
}
