<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\User;
use App\Entity\Group;

/**
 * bin/console doctrine:fixture:load to purge DB and fill it with dummy data
 */
class DummyDataFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 3; $i++) {
            
            $group = new Group();
            $group->setName('group'.$i);

            $manager->persist($group);

            for ($j=0; $j < 3; $j++) {

                $user = new User();
                $user->setName('user'.$i.$j);
                $user->addGroup($group);

                $manager->persist($user);
            }
        }

        $manager->flush();
    }
}
