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

use Cake\ORM\TableRegistry;
use League\FactoryMuffin\FactoryMuffin;

abstract class AbstractFactory implements FactoryInterface
{
    /**
     * A FactoryMuffin object instance.
     *
     * @var \League\FactoryMuffin\FactoryMuffin
     */
    protected $_factoryMuffin;

    /**
     * Table alias.
     *
     * @var string
     */
    protected $_name;

    /**
     * AbstractFactory constructor.
     *
     * @param \League\FactoryMuffin\FactoryMuffin $factoryMuffin A FactoryMuffin object instance.
     * @param string $name Table alias.
     */
    public function __construct(FactoryMuffin $factoryMuffin, $name)
    {
        $this->_factoryMuffin = $factoryMuffin;
        $this->_name = $name;
    }

    /**
     * Returns table alias.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return FactoryMuffin
     */
    public function getFactoryMuffin()
    {
        return $this->_factoryMuffin;
    }


    /**
     * Builds Definition object and configures it to work with cakephp ORM.
     *
     * @return \League\FactoryMuffin\Definition
     */
    public function define()
    {
        return $this->getFactoryMuffin()
                    ->define(get_class($this))
                    ->setDefinitions($this->definition())
                    ->setMaker($this->maker());
    }

    /**
     * Generates entity associated with factory.
     *
     * @return \Closure
     */
    public function maker()
    {
        $name = $this->_name;
        return function ($class) use ($name) {
            $table = TableRegistry::get($name);
            return $table->newEntity();
        };
    }

    /**
     * @inheritdoc
     */
    abstract public function definition();
}
