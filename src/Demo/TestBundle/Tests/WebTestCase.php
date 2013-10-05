<?php

namespace Demo\TestBundle\Tests;

use Liip\FunctionalTestBundle\Test\WebTestCase as BaseTestCase;

class WebTestCase extends BaseTestCase
{
    protected function setUp()
    {
        $classes = array(
            "Demo\PostBundle\DataFixtures\ORM\LoadPostData",
            "Demo\UserBundle\DataFixtures\ORM\LoadUserData"
        );
        $this->loadFixtures($classes);
    }
}
