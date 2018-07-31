<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture implements DependentFixtureInterface
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(User::class, 5, function(User $user){
            $user->setUserName($this->faker->userName);
            $user->setEmail($this->faker->email);
            $user->setPassword($this->faker->password);
            /** @var Role[] $roles */
            $roles = $this->getRandomReferences(Role::class,
                $this->faker->numberBetween(0, 2));
            foreach ($roles as $role){
                $user->addRole($role);
            }

        });
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
          RoleFixture::class
        ];
    }
}
