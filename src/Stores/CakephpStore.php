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

namespace CakephpFactoryMuffin\Stores;

use Cake\ORM\TableRegistry;
use League\FactoryMuffin\Stores\ModelStore;
use League\FactoryMuffin\Stores\StoreInterface;

/**
 * Class CakephpStore
 *
 * @package CakephpFactoryMuffin\Stores
 */
class CakephpStore extends ModelStore implements StoreInterface
{
    /**
     * Save our object to the db, and keep track of it.
     *
     * @param \Cake\Datasource\EntityInterface $entity The model instance.
     * @return mixed
     */
    protected function save($entity)
    {
        $alias = $entity->getSource();
        $table = TableRegistry::get($alias);
        return $table->save($entity);
    }

    /**
     * Delete our object from the db.
     *
     * @param \Cake\Datasource\EntityInterface $entity The model instance.
     * @return mixed
     */
    protected function delete($entity)
    {
        $alias = $entity->getSource();
        $table = TableRegistry::get($alias);
        return $table->delete($entity);
    }
}
