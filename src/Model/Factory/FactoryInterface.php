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

namespace CakephpFactoryMuffin\Model\Factory;

/**
 * Interface FactoryInterface
 *
 * @package CakephpFactoryMuffin\Model\Factory
 */
interface FactoryInterface
{
    /**
     * Returns factory definition options.
     *
     * @return array
     */
    public function definition();
}
