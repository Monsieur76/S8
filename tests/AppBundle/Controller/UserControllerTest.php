<?php

    namespace Tests\AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

    class UserControllerTest extends WebTestCase
    {
        public function testListAction()
        {
            $client = self::createClient();
            $crawler = $client->request('GET', '/users');
            $this->assertEquals(302, $client->getResponse()->getStatusCode());
        }

        public function testListCreat()
        {
            $client = self::createClient();
            $crawler = $client->request('GET', '/users/create');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

    }