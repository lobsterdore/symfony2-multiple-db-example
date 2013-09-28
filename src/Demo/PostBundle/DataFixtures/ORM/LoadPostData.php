<?php
namespace Demo\PostBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Demo\PostBundle\Entity\Post;

class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $post = new Post();
        $post->setUser($this->getReference('test-user'));
        $post->setTitle('Test Post');
        $post->setContent('Some test content');

        $manager->persist($post);
        $manager->flush();
    }
    
    public function getOrder()
    {
        return 2;
    }
}
