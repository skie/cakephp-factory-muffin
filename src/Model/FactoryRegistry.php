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

namespace CakephpFactoryMuffin\Model;

use Cake\Core\App;
use Cake\Core\ObjectRegistry;
use CakephpFactoryMuffin\Exception\MissingFactoryException;
use League\FactoryMuffin\FactoryMuffin;

/**
 * Class FactoryRegistry
 *
 * @package CakephpFactoryMuffin\Model
 */
class FactoryRegistry extends ObjectRegistry
{
    /**
     * The table that this collection was initialized with.
     *
     * @var \League\FactoryMuffin\FactoryMuffin
     */
    protected $_FactoryMuffin = null;

    /**
     * Constructor.
     *
     * @param \League\FactoryMuffin\FactoryMuffin $factoryMuffin Controller instance.
     */
    public function __construct(FactoryMuffin $factoryMuffin = null)
    {
        if ($factoryMuffin) {
            $this->_FactoryMuffin = $factoryMuffin;
        }
    }

    /**
     * Resolve a factory class name.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param  string $class Partial class name to resolve.
     * @return string|false Either the correct class name or false.
     */
    protected function _resolveClassName($class)
    {
        return App::className($class, 'Model/Factory', 'Factory');
    }

    /**
     * Throws an exception when a factory is missing.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class  The class name that is missing.
     * @param string $plugin The plugin the factory is missing in.
     * @return void
     * @throws \CakephpFactoryMuffin\Exception\MissingFactoryException
     */
    protected function _throwMissingClassError($class, $plugin)
    {
        throw new MissingFactoryException([
            'class' => $class . 'Factory',
            'plugin' => $plugin,
        ]);
    }

    /**
     * Create the factory instance.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class The class name to create.
     * @param string $alias The alias of the factory.
     * @param array $config An array of config to use for the factory.
     * @return \CakephpFactoryMuffin\Model\Factory\FactoryInterface The constructed factory class.
     */
    protected function _create($class, $alias, $config)
    {
        return new $class($this->_FactoryMuffin, $alias);
    }

    /**
     * Return collection of loaded factories
     *
     * @param mixed $collectionMethod
     * @return \Cake\Collection\Collection
     */
    public function collection($collectionMethod = null)
    {
        $collection = collection($this->_loaded);
        if (is_callable($collectionMethod)) {
            return $collectionMethod($collection);
        }
        return $collection;
    }

    /**
     * Returns controller instance.
     *
     * @return \League\FactoryMuffin\FactoryMuffin
     */
    public function factoryMuffin()
    {
        return $this->_FactoryMuffin;
    }
}
