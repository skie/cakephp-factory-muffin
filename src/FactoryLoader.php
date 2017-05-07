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

namespace CakephpFactoryMuffin;

use Cake\Core\Plugin;
use Cake\Filesystem\Folder;
use CakephpFactoryMuffin\Model\FactoryRegistry;
use CakephpFactoryMuffin\Stores\CakephpStore;
use League\FactoryMuffin\FactoryMuffin;

/**
 * FactoryLoader
 */
class FactoryLoader
{

    /**
     * A FactoryMuffin object instance.
     *
     * @var \League\FactoryMuffin\FactoryMuffin
     */
    protected $_FactoryMuffin;

    /**
     * A FactoryRegistry object instance.
     *
     * @var \CakephpFactoryMuffin\Model\FactoryRegistry
     */
    protected $_registry;

    /**
     * FactoryLoader constructor.
     */
    public function __construct()
    {
        $this->_FactoryMuffin = new FactoryMuffin(new CakephpStore());
        $this->_registry = new FactoryRegistry($this->_FactoryMuffin);
    }

    /**
     * Getter for FactoryMuffin object instance.
     *
     * @return \League\FactoryMuffin\FactoryMuffin
     */
    public function getFactoryMuffin()
    {
        return $this->_FactoryMuffin;
    }

    /**
     * Getter for FactoryRegistry object instance.
     *
     * @return \CakephpFactoryMuffin\Model\FactoryRegistry
     */
    public function getFactoryRegistry()
    {
        return $this->_registry;
    }

    /**
     * Returns FactoryLoader instance.
     *
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

    /**
     * Loads factory objects using cakephp table alias naming convention.
     *
     * Uses: FactoryLoader::load(['Posts', 'Comments']);
     *
     * @param $factoryNames
     */
    public static function load($factoryNames)
    {
        collection((array)$factoryNames)->each(function ($name) {
            $factory = self::getInstance()
                           ->getFactoryRegistry()
                           ->load($name);
            $factory->define();
        });
    }

    /**
     * Loads all factory objects by application or plugin scope.
     * If scope is not defined then used application one.
     *
     * @param $factoryNames
     */
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

    /**
     * Creates and saves multiple versions of a model.
     * This method accept name using table alias naming conventions.
     *
     * @param int    $times The number of models to create.
     * @param string $name  The model definition name.
     * @param array  $attr  The model attributes.
     * @return \Cake\Datasource\EntityInterface[]
     */
    public static function seed($times, $name, array $attr = [])
    {
        $factory = self::getInstance()
                       ->getFactoryRegistry()
                       ->get($name);
        return self::getInstance()
            ->getFactoryMuffin()
            ->seed($times, get_class($factory), $attr);
    }

    /**
     * Creates and saves a model.
     * This method accept name using table alias naming conventions.
     *
     * @param string $name The model definition name.
     * @param array  $attr The model attributes.
     * @return \Cake\Datasource\EntityInterface
     */
    public static function create($name, array $attr = [])
    {
        $factory = self::getInstance()
                       ->getFactoryRegistry()
                       ->get($name);
        return self::getInstance()
            ->getFactoryMuffin()
            ->create(get_class($factory), $attr);
    }

    /**
     * Return an instance of the model.
     *
     * This does not save it in the database. Use create for that.
     *
     * This method accept name using table alias naming conventions.
     *
     * @param string $name The model definition name.
     * @param array  $attr The model attributes.
     * @return \Cake\Datasource\EntityInterface
     */
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
