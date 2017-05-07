<?php
/**
 * PlumSearch plugin for CakePHP Rapid Development Framework
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author        Evgeny Tomenko
 * @since         PlumSearch 0.1
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakephpFactoryMuffin\Exception;

use Cake\Core\Exception\Exception;

/**
 * Missing Factory exception - used when a form parameter
 * cannot be found.
 *
 */
class MissingFactoryException extends Exception
{
    /**
     * {@inheritDoc}
     */
    protected $_messageTemplate = 'Factory %s::%s() could not be found.';

    /**
     * {@inheritDoc}
     */
    public function __construct($message, $code = 404)
    {
        parent::__construct($message, $code);
    }
}
