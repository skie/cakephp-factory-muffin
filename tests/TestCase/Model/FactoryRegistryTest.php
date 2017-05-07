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

namespace CakephpFactoryMuffin\Test\TestCase\Model;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use CakephpFactoryMuffin\Model\FactoryRegistry;
use CakephpFactoryMuffin\Test\App\Model\Factory\ArticlesFactory;
use CakephpFactoryMuffin\Test\App\Model\Factory\TagsFactory;
use League\FactoryMuffin\FactoryMuffin;

/**
 * CakephpFactoryMuffin\Model\FactoryRegistry Test Case
 */
class FactoryRegistryTest extends TestCase
{
    /**
     * Test fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cakephp_factory_muffin.articles',
        'plugin.cakephp_factory_muffin.tags',
    ];

    protected $FactoryMuffin;

    protected $FactoryRegistry;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->FactoryMuffin = new FactoryMuffin();
        $this->FactoryRegistry = new FactoryRegistry($this->FactoryMuffin);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FactoryMuffin, $this->FactoryRegistry);
        parent::tearDown();
    }

    /**
     * Test load value method
     *
     * @return void
     */
    public function testLoad()
    {
        $type = $this->FactoryRegistry->load('Articles');
        $this->assertTrue($type instanceof ArticlesFactory);
        $type = $this->FactoryRegistry->load('Tags');
        $this->assertTrue($type instanceof TagsFactory);
    }

    /**
     * Test load unexists class  method
     *
     * @expectedException \CakephpFactoryMuffin\Exception\MissingFactoryException
     * @return void
     */
    public function testLoadWrongClass()
    {
        $this->FactoryRegistry->load('name1');
    }
}
