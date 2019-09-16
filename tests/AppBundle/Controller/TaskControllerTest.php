<?php

    namespace Tests\AppBundle\Controller;

    use AppBundle\Entity\Task;

    class TaskControllerTest extends TestBase
    {
        public function testListAction()
        {
            $crawler = $this->client->request('GET', '/tasks');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        }

        public function testListActionDone()
        {
            $crawler = $this->client->request('GET', '/tasks/complete');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        }

        public function testListCreat()
        {
            $crawler = $this->client->request('GET', '/tasks/create');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        }

        public function testCreatTask()
        {
            $this->user('urban','az@ez2.fr');
            $this->connection('urban');
            $crawler = $this->creatTask();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $user = $this->find('urban');
            $this->remove($task);
            $this->remove($user);
        }

        public function testEditTask()
        {
            $user = $this->user('isidro','az@ez3.fr');
            $this->connection('isidro');
            $crawler = $this->creatTask();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/edit');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $form = $crawler->selectButton('Modifier')->form();
            $form['task[title]'] = 'le petit magazine';
            $form['task[content]'] = 'Voici le début de la programmation de mon petit journal';
            $form['task[author]'] = 'moi';
            $this->client->submit($form);
            $crawler = $this->client->followRedirect();
            $user = $this->find('isidro');
            $this->remove($task);
            $this->remove($user);
        }

        public function testDeleteTask()
        {
            $user = $this->user('lee','az@ez4.fr');
            $this->connection('lee');
            $crawler = $this->creatTask();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/delete');
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
            $user = $this->find('lee');
            $this->remove($task);
            $this->remove($user);
        }

        public function testToggleTrue()
        {
            $this->user('rolfson','az@ez9.fr');
            $this->connection('rolfson');
            $crawler = $this->creatTask();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/toggle');
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $user = $this->find('rolfson');
            $this->remove($task);
            $this->remove($user);
        }

        public function testToggleFalse()
        {
            $this->user('jesus','az@ez11.fr');
            $this->connection('rolfson');
            $crawler = $this->creatTask();
            $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/toggle');
            $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
            $crawler = $this->client->request('GET', '/tasks/'.$task->getId().'/toggle');
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> 'le petit journal' ]);
            $user = $this->find('jesus');
            $this->remove($task);
            $this->remove($user);
        }
    }