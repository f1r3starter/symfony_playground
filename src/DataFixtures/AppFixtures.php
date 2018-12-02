<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadMicroPost($manager);
    }

    private function loadMicroPost(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $micropost = new MicroPost();
            $micropost->setText('blah blah blah' . rand(1, 100));
            $micropost->setTime(new \DateTime('2018-11-11'));
            $micropost->setUser($this->getReference('john_doe'));
            $manager->persist($micropost);
        }

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('john_doe');
        $user->setFullName('John Doe');
        $user->setEmail('john@doe.com');
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, 'john123')
        );
        $this->addReference('john_doe', $user);

        $manager->persist($user);
        $manager->flush();
    }
}
