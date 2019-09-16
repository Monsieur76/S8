<?php


    namespace App\Tests\src\Entity;

    use Faker;
    use AppBundle\Entity\Task;
    use PHPUnit\Framework\TestCase;

    class TaskTest extends TestCase
    {
        private $task;
        private $faker;

        public function setUp(): void
        {
            parent::setUp();
            $this->task = new Task();
            $this->hydrate($this->task);
            $this->faker = Faker\Factory::create();
        }

        public function hydrate($taskInsert)
        {
            $this->task->setTitle('le petit journal');
            $this->task->setCreatedAt(new \DateTime());
            $this->task->setAuthor('moi');
            $this->task->setContent('le premier journal');
        }

        public function testTitle()
        {
            $this->assertEquals('le petit journal',$this->task->getTitle());
        }

        public function testDate()
        {
            $this->assertInstanceOf(\DateTime::class,$this->task->getCreatedAt());
        }

        public function testId()
        {
            $this->assertEquals(null,$this->task->getID());
        }

        public function testIdUser()
        {
            $this->assertEquals(null,$this->task->getUser());
        }

        public function testAuthor()
        {
            $this->assertEquals('moi',$this->task->getAuthor());
        }

        public function testContent()
        {
            $this->assertEquals('le premier journal',$this->task->getContent());
        }


    }