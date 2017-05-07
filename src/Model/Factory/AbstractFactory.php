<?php

namespace CakephpFactoryMuffin\Model\Factory;

use Cake\ORM\TableRegistry;
use League\FactoryMuffin\FactoryMuffin;

abstract class AbstractFactory implements FactoryInterface
{
    protected $_factoryMuffin;

    protected $_name;

    public function __construct(FactoryMuffin $factoryMuffin, $name)
    {
        $this->_factoryMuffin = $factoryMuffin;
        $this->_name = $name;
    }

    /**
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


    public function define()
    {
        return $this->getFactoryMuffin()
                    ->define(get_class($this))
                    ->setDefinitions($this->definition())
                    ->setMaker($this->maker());
    }

    public function maker()
    {
        $name = $this->_name;
        return function ($class) use ($name) {
            $table = TableRegistry::get($name);
            return $table->newEntity();
        };
    }

    abstract public function definition();

}
