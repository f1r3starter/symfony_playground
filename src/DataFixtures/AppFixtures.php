<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $micropost = new MicroPost();
            $micropost->setText('blah blah blah' . rand(1, 100));
            $micropost->setTime(new \DateTime('2018-11-11'));
            $manager->persist($micropost);
        }

        $manager->flush();
    }
}
