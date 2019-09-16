<?php

    namespace Tests\AppBundle\Controller;

    class UserControllerTest extends TestBase
    {
        public $username;

        public function testListCreat()
        {
            $crawler = $this->client->request('GET', '/users/create');
            $form = $crawler->selectButton('Ajouter')->form();
            $form['user[username]'] = $this->getUserName();
            $form['user[password][first]'] = $this->getPassword();
            $form['user[password][second]'] = $this->getPassword();
            $form['user[email]'] = $this->getMail();
            $form['user[roles]'] = $this->getRoles();
            $this->client->submit($form);
            $crawler = $this->client->followRedirect();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $user = $this->find($this->getUserName());
            $this->assertEquals($this->getUserName(),$user->getUsername());
            $this->remove($user);
        }

        public function testListActionAndEdit()
        {
            $user = $this->user('diana','az@ez6.fr');
            $crawler = $this->connection('diana');
            $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !',
                $crawler->filter('body > div:nth-child(2) > div:nth-child(2) > div > h1')->text());
            $link = $crawler->selectLink('Liste des Utilisateurs')->link();
            $this->client->click($link);
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $user = $this->find('diana');
            $crawler = $this->client->request('GET', '/users/'.$user->getId().'/edit');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $form = $crawler->selectButton('Modifier')->form();
            $form['user[password][first]'] = $this->getPassword();
            $form['user[password][second]'] = $this->getPassword();
            $this->client->submit($form);
            $crawler = $this->client->followRedirect();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $this->remove($user);
        }
    }