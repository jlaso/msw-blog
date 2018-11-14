<?php


namespace JLaso\Blog\models\Entity;

use \app\models\core\FixturableInterface;
use JLaso\Blog\models\Entity\Post;
use \app\models\core\Registry;

class PostFixture implements FixturableInterface
{
    /**
     * Creates a new item from $assocArray and inserts into DB
     *
     * @param array $assocArray
     */
    public function addNewItem($assocArray)
    {
        $item = \JLaso\Blog\models\Entity\Post::factory()->create();
        foreach ($assocArray as $field=>$value) {
            $item->set($field,is_bool($value) ? (int) $value : $value);
        }
        $item->save();
        return $this;
    }

    /**
     * Generate fixtures
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry)
    {
        // declares the entities that are available for backend
        $entities = array(
            array(
                'title'      => 'Publiqué mi primer libro',
                'slug'       => 'publique-mi-primer-libro',
                'content'    => file_get_contents(__DIR__ . '/Fixtures/Posts/1.html'),
                'created_at' => date("Y-m-d h:i:s"),
                'updated_at' => date("Y-m-d h:i:s"),
            ),
        );
        // put info into fixtures registry, so are available for other fixture process
        $fixturesRegistry->set('entities',$entities);
        // put info into DB
        foreach ($entities as $entity) {
            $this->addNewItem($entity);
        }

    }

    /**
     * Get the order of fixture generation
     *
     * @return int
     */
    public static function getOrder()
    {
        return 100;
    }

}