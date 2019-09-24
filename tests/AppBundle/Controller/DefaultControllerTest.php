<?php

namespace Tests\AppBundle\Controller;

class DefaultControllerTest extends TestBase
{
    public function testIndexHome()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains(
            'Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !',
            $crawler->filter('body > div:nth-child(2) > div:nth-child(2) > div > h1')->text()
        );
        $link = $crawler->selectLink('To Do List app')->link();
        $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexConnect()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $link = $crawler->selectLink('Se connecter')->link();
        $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexTaskNoValidate()
    {
        $crawler = $this->client->request('GET', '/');
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }

    public function testIndexTaskValidate()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $link = $crawler->selectLink('Consulter la liste des tâches terminées')->link();
        $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
}
