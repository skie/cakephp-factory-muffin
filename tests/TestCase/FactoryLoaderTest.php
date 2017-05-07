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

namespace CakephpFactoryMuffin\Test\TestCase;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use CakephpFactoryMuffin\FactoryLoader;
use CakephpFactoryMuffin\Test\App\Model\Factory\ArticlesFactory;
use CakephpFactoryMuffin\Test\App\Model\Factory\AuthorsFactory;
use CakephpFactoryMuffin\Test\App\Model\Factory\TagsFactory;

/**
 * CakephpFactoryMuffin\FactoryLoader Test Case
 */
class FactoryLoaderTest extends TestCase
{
    /**
     * Test fixtures
     *
     * @var array
     */
    public $fixtures = [
        'plugin.cakephp_factory_muffin.articles',
        'plugin.cakephp_factory_muffin.authors',
        'plugin.cakephp_factory_muffin.tags',
    ];

    protected $FactoryMuffin;

    protected $FactoryLoader;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        FactoryLoader::flush();
        parent::tearDown();
    }

    /**
     * Test load value method
     *
     * @return void
     */
    public function testLoad()
    {
        $registry = $TagsFactory = FactoryLoader::getInstance()->getFactoryRegistry();
        FactoryLoader::load('Articles');

        $this->assertTrue($registry->get('Articles') instanceof ArticlesFactory);

        FactoryLoader::load('Tags');
        $this->assertTrue($registry->get('Tags') instanceof TagsFactory);
    }

    /**
     * Test load value method
     *
     * @return void
     */
    public function testLoadAll()
    {
        $registry = $TagsFactory = FactoryLoader::getInstance()->getFactoryRegistry();
        FactoryLoader::loadAll();

        $this->assertTrue($registry->get('Articles') instanceof ArticlesFactory);
        $this->assertTrue($registry->get('Authors') instanceof AuthorsFactory);
        $this->assertTrue($registry->get('Tags') instanceof TagsFactory);
    }

    /**
     * Test load value method
     *
     * @return void
     */
    public function testSeedMultipleTables()
    {
        FactoryLoader::loadAll();
        $authors = FactoryLoader::seed(5, 'Authors');
        $articlesCount = 0;
        foreach ($authors as $author) {
            $count = rand(0, 5);
            FactoryLoader::seed($count, 'Articles', ['author_id' => $author->id]);
            $articlesCount += $count;
        }
        $this->assertEquals($articlesCount, TableRegistry::get('Articles')->find()->count());
        $this->assertEquals(5, TableRegistry::get('Authors')->find()->count());
    }
}
