<?php

namespace Demo\PostBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $classes = array(
            "Demo\PostBundle\DataFixtures\ORM\LoadPostData",
            "Demo\UserBundle\DataFixtures\ORM\LoadUserData"
        );
        $this->loadFixtures($classes);
    }
    
    public function testIndex()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/user/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /post/");
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Create a new entry")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Test User")')->count()
        );
    }
    
    public function testNew()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/user/');
        
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        
        $form = $crawler->selectButton('Create')->form(array(
            'demo_userbundle_user[name]'       => 'Another Test User',
            'demo_userbundle_user[username]'   => 'another_test_user',
            'demo_userbundle_user[email]'      => 'test@anotheruser.com'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Another Test User")')->count()
        );
    }
    
    public function testEdit()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/user/');
        
        $crawler = $client->click($crawler->selectLink('edit')->link());
        
        $form = $crawler->selectButton('Update')->form(array(
            'demo_userbundle_user[name]'       => 'An edited user'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        $crawler = $client->request('GET', '/user/');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("An edited user")')->count()
        );
    }
    
    public function testShow()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/user/');
        
        $crawler = $client->click($crawler->selectLink('show')->link());
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Test User")')->count()
        );
    }
    
    public function testDelete()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/user/');
        
        $crawler = $client->click($crawler->selectLink('show')->link());
        
        $form = $crawler->selectButton('Delete')->form();

        $client->submit($form);
        
        $crawler = $client->followRedirect();
        
        $this->assertEquals(
            0,
            $crawler->filter('html:contains("Test User")')->count()
        );
    }
}
