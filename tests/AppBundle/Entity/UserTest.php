<?php


    namespace App\Tests\src\Entity;

    use AppBundle\Entity\User;
    use PHPUnit\Framework\TestCase;
    use Symfony\Component\Validator\Constraints\Collection;

    class UserTest extends TestCase
    {
        private $user;

        public function setUp(): void
        {
            parent::setUp(); // TODO: Change the autogenerated stub
            $this->user = new User();
            $this->hydrate($this->user);
        }

        public function hydrate($figure)
        {
            $this->user->setUsername('greg');
            $this->user->setRoles(['ROLE_USER']);
            $this->user->setEmail('lol@lol.sd');
        }

        public function testUsername()
        {
            $this->assertEquals('greg',$this->user->getUsername());
        }


        public function testId()
        {
            $this->assertEquals(null,$this->user->getId());
        }

        public function testRoles()
        {
            $this->assertEquals(['ROLE_USER'],$this->user->getRoles());
        }

        public function testEmail()
        {
            $this->assertEquals('lol@lol.sd',$this->user->getEmail());
        }
    }