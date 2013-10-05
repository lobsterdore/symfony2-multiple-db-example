<?php

namespace Demo\PostBundle\Tests\Controller;

use Demo\TestBundle\Tests\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/post/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code for GET /post/");
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Create a new entry")')->count()
        );
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Test Post")')->count()
        );
    }
    
    public function testNew()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/post/');
        
        $crawler = $client->click($crawler->selectLink('Create a new entry')->link());
        
        $form = $crawler->selectButton('Create')->form(array(
            'demo_postbundle_post[title]'       => 'Another Test Post',
            'demo_postbundle_post[content]'     => 'Some bloody test content',
            'demo_postbundle_post[user]'        => 1
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Another Test Post")')->count()
        );
    }
    
    public function testEdit()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/post/');
        
        $crawler = $client->click($crawler->selectLink('edit')->link());
        
        $form = $crawler->selectButton('Update')->form(array(
            'demo_postbundle_post[title]'       => 'An edited post'
        ));

        $client->submit($form);
        $crawler = $client->followRedirect();
        
        $crawler = $client->request('GET', '/post/');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("An edited post")')->count()
        );
    }
    
    public function testShow()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/post/');
        
        $crawler = $client->click($crawler->selectLink('show')->link());
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Test Post")')->count()
        );
        
        $crawler = $client->request('GET', '/post/9999');
        
        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Unable to find Post entity.")')->count()
        );
    }
    
    public function testDelete()
    {
        $client = static::createClient();
        
        $crawler = $client->request('GET', '/post/');
        
        $crawler = $client->click($crawler->selectLink('show')->link());
        
        $form = $crawler->selectButton('Delete')->form();

        $client->submit($form);
        
        $crawler = $client->followRedirect();
        
        $this->assertEquals(
            0,
            $crawler->filter('html:contains("Test Post")')->count()
        );
    }
}
