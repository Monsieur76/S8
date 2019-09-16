<?php

    namespace Tests\AppBundle\Controller;

    class SecurityControllerTest extends TestBase
    {
        public function testConnectLogout()
        {
            $user = $this->user('jose','az@ez.fr');
            $crawler = $this->client->request('GET', '/login');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $form = $crawler->selectButton('Se connecter')->form();
            $form['_username'] = 'jose';
            $form['_password'] = $this->getPassword();
            $this->client->submit($form);
            $crawler = $this->client->followRedirect();
            $this->assertContains('Bienvenue sur Todo List, l\'application vous permettant de gérer l\'ensemble de vos tâches sans effort !',
                $crawler->filter('body > div:nth-child(2) > div:nth-child(2) > div > h1')->text());
            $link = $crawler->selectLink('Se déconnecter')->link();
            $this->client->click($link);
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
            $user = $this->find('jose');
            $this->remove($user);
        }
    }