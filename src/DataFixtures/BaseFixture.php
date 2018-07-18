<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 18/07/2018
 * Time: 23:47
 */

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

abstract class BaseFixture extends Fixture
{
    /**
     * @var ObjectManager
     */
    protected  $manager;

    abstract protected function loadData(ObjectManager $manager);

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $this->loadData($manager);
    }

    protected function createMany(string $className, int $count, callable $factory)
    {
        for ($i = 0; $i < $count; $i++) {
            $entity = new $className();
            $factory($entity, $i);
            $this->manager->persist($entity);
            // store for usage later as App\Entity\ClassName_#COUNT#
            $this->addReference($className . '_' . $i, $entity);
        }
    }
}