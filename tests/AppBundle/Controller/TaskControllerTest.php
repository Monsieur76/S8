<?php

    namespace Tests\AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

    class TaskControllerTest extends WebTestCase
    {
        public function testListAction()
        {
            $client = self::createClient();
            $crawler = $client->request('GET', '/tasks');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

        public function testListActionDone()
        {
            $client = self::createClient();
            $crawler = $client->request('GET', '/tasks/complete');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        }

        public function testListCreat()
        {
            $client = self::createClient();
            $crawler = $client->request('GET', '/tasks/create');
            $this->assertEquals(302, $client->getResponse()->getStatusCode());
        }

    }