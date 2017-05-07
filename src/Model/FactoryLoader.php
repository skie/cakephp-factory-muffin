<?php

namespace CakephpFactoryMuffin;

use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use CakephpFactoryMuffin\Stores\CakephpStore;
use League\FactoryMuffin\FactoryMuffin;

/**
 * FactoryLoader
 */
class FactoryLoader
{

    protected $_FactoryMuffin;

    protected $_registry;

    public function __construct()
    {
        $this->_FactoryMuffin = new FactoryMuffin(new CakephpStore());
        $this->_registry = new FactoryRegistry($this->_FactoryMuffin);
    }

    public function getFactoryMuffin()
    {
        return $this->_FactoryMuffin;
    }

    public function getFactoryRegistry()
    {
        return $this->_registry;
    }

    /**
     * @return \CakephpFactoryMuffin\Model\FactoryLoader
     */
    public static function getInstance()
    {
        static $instance = [];
        if (!empty($class)) {
            if (!$instance || strtolower($class) !== strtolower(get_class($instance[0]))) {
                $instance[0] = new $class();
            }
        }
        if (!$instance) {
            $instance[0] = new FactoryLoader();
        }

        return $instance[0];
    }

    public static function load($factoryNames)
    {
        collection((array)$factoryNames)->each(function ($name) {
            $factory = self::getInstance()
                           ->getFactoryRegistry()
                           ->load($name);
            $factory->define();
        });
    }

    public static function loadAll($scope = null)
    {
        if ($scope === null || $scope === 'App') {
            $path = APP_DIR;
            $prefix = '';
        } else {
            $path = Plugin::classPath($scope);
            $prefix = $scope . '.';
        }
        $Folder = new Folder($path . 'Model/Factory');

        foreach ($Folder->find('.*Factory\.php') as $fileName) {
            $name = str_replace('Factory.php', '', $fileName);
            self::load($prefix . $name);
        }
    }

    public static function seed($times, $name, array $attr = [])
    {
        $factory = self::getInstance()
                       ->getFactoryRegistry()
                       ->get($name);
        return self::getInstance()
            ->getFactoryMuffin()
            ->seed($times, get_class($factory), $attr);
    }

    public static function create($name, array $attr = [])
    {
        $factory = self::getInstance()
                       ->getFactoryRegistry()
                       ->get($name);
        return self::getInstance()
            ->getFactoryMuffin()
            ->create(get_class($factory), $attr);
    }

    public static function instance($name, array $attr = [])
    {
        $factory = self::getInstance()
                       ->getFactoryRegistry()
                       ->get($name);
        return self::getInstance()
            ->getFactoryMuffin()
            ->instance(get_class($factory), $attr);
    }
}
