<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexHome()
    {
        $client = self::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !',
            $crawler->filter('body > div:nth-child(2) > div:nth-child(2) > div > h1')->text());
        $link = $crawler->selectLink('To Do List app')->link();
        $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testIndexUser()
    {
        $client = self::createClient();
        $crawler = $client->request('GET','/');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexConnect()
    {
        $client = self::createClient();
        $crawler = $client->request('GET','/');
        $link = $crawler->selectLink('Se connecter')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexTaskNoValidate()
    {
        $client = self::createClient();
        $crawler = $client->request('GET','/');
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexTaskValidate()
    {
        $client = self::createClient();
        $crawler = $client->request('GET','/');
        $link = $crawler->selectLink('Consulter la liste des tâches terminées')->link();
        $crawler = $client->click($link);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
