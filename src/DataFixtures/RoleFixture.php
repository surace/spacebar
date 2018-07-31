<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixture extends BaseFixture
{
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Role::class, 5, function(Role $role){
            $role->setRole($this->faker->word);
        });
        $manager->flush();
    }
}
