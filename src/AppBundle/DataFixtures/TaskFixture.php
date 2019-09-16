<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class TaskFixture extends BaseFixture implements OrderedFixtureInterface
{
    public function getOrder(){
        return 2;
    }
    public function load(ObjectManager $manager)
    {
        $this->createMany('task',Task::class,$this->count,function (Task $task) use ($manager){
            $user = $this->getReference('user'.rand(1,$this->maxRandom));
            $task->setTitle($this->faker->title);
            $task->setUser($user);
            $task->toggle($this->faker->boolean);
            $task->setAuthor($this->faker->name);
            $task->setContent($this->faker->text);
        });

    }
}
