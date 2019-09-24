<?php


    namespace Tests\AppBundle\Controller;

    use AppBundle\Entity\Task;
    use AppBundle\Entity\User;
    use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

    class TestBase extends WebTestCase
    {
        private $userName = 'greg';
        private $password = 'lol';
        private $mail = 'moi@mopo.com';
        private $roles;
        public $container;
        public $doctrine;
        public $client;

        public function setUp()
        {
            self::bootKernel();
            $this->container = self::$kernel->getContainer();
            $this->doctrine = $this->container->get('doctrine');
            $this->client = self::createClient();
            $this->randoomRole();
        }

        public function randoomRole()
        {
            $random = rand(0, 1);
            if ($random === 0) {
                $this->roles = ['ROLE_ADMIN'];
            } else {
                $this->roles = ['ROLE_USER'];
            }
        }

        /**
         * @return string
         */
        public function getPassword()
        {
            return $this->password;
        }

        /**
         * @param string $password
         */
        public function setPassword($password)
        {
            $this->password = $password;
        }
        /**
         * @return string
         */
        public function getUserName()
        {
            return $this->userName;
        }

        /**
         * @param string $userName
         */
        public function setUserName($userName)
        {
            $this->userName = $userName;
        }

        /**
         * @return string
         */
        public function getMail()
        {
            return $this->mail;
        }

        /**
         * @param string $mail
         */
        public function setMail($mail)
        {
            $this->mail = $mail;
        }

        /**
         * @return array
         */
        public function getRoles()
        {
            return $this->roles;
        }

        /**
         * @param array $roles
         */
        public function setRoles($roles)
        {
            $this->roles = $roles;
        }

        public function remove($user)
        {
            $this->doctrine->getManager()->remove($user);
            $this->doctrine->getManager()->flush();
        }

        public function find($name)
        {
            $user = $this->doctrine->getRepository(User::class)->findOneBy(['username'=>$name]);
            return $user;
        }

        public function findAllUser()
        {
            $user = $this->doctrine->getRepository(User::class)->findAll();
            return $user;
        }

        public function findAllTask()
        {
            $task = $this->doctrine->getRepository(Task::class)->findAll();
            return $task;
        }

        public function findOneBy($title)
        {
            $task = $this->doctrine->getRepository(Task::class)->findOneBy(['title'=> $title ]);
            return $task;
        }

        public function persistFlush($user)
        {
            $this->doctrine->getManager()->persist($user);
            $this->doctrine->getManager()->flush();
        }

        public function user($name, $mail)
        {
            $user = new User();
            $password =  $this->container->get('security.password_encoder');
            $user->setUsername($name);
            $user->setPassword($password->encodePassword($user, $this->getPassword()));
            $user->setEmail($mail);
            $user->setRoles(['ROLE_ADMIN']);
            $this->persistFlush($user);
            return $user;
        }

        public function connection($name)
        {
            $crawler = $this->client->request('GET', '/login');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $form = $crawler->selectButton('Se connecter')->form();
            $form['_username'] = $name;
            $form['_password'] = $this->getPassword();
            $this->client->submit($form);
            $crawler = $this->client->followRedirect();
            return $crawler;
        }

        public function creatTask()
        {
            $crawler = $this->client->request('GET', '/tasks/create');
            $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
            $form = $crawler->selectButton('Ajouter')->form();
            $form['task[title]'] = 'le petit journal';
            $form['task[content]'] = 'Voici le début de la programmation de mon petit journal';
            $form['task[author]'] = 'moi';
            $this->client->submit($form);
            $crawler = $this->client->followRedirect();
            return $crawler;
        }
    }
