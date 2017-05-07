<?php

namespace CakephpFactoryMuffin\Model;

use Cake\Core\App;
use Cake\Core\ObjectRegistry;
use CakephpFactoryMuffin\Exception\MissingFactoryException;
use League\FactoryMuffin\FactoryMuffin;

/**
 * FactoryRegistry is a registry for loaded factories.
 *
 * Handles loading, constructing  for param class objects.
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
     * Form name
     *
     * @var string
     */
    public $formName;

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
     * Resolve a param class name.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param  string       $class Partial class name to resolve.
     * @return string|false Either the correct class name or false.
     */
    protected function _resolveClassName($class)
    {
        return App::className($class, 'Model/Factory', 'Factory');
    }

    /**
     * Throws an exception when a param is missing.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class  The class name that is missing.
     * @param string $plugin The plugin the param is missing in.
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
     * Create the param instance.
     *
     * Part of the template method for Cake\Core\ObjectRegistry::load()
     *
     * @param string $class The class name to create.
     * @param string $alias The alias of the param.
     * @param array $config An array of config to use for the param.
     * @return \CakephpFactoryMuffin\Model\Factory\FactoryInterface The constructed param class.
     */
    protected function _create($class, $alias, $config)
    {
        return new $class($this->_FactoryMuffin, $alias);
    }

    /**
     * Return collection of loaded parameters
     *
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
