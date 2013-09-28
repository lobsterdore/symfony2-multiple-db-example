<?php
namespace Demo\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Demo\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setName('Test User');
        $user->setUsername('test_user');
        $user->setEmail('test@user.com');

        $manager->persist($user);
        $manager->flush();
        
        $this->addReference('test-user', $user);
    }
    
    public function getOrder()
    {
        return 1;
    }
}
