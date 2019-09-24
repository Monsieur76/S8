<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends BaseFixture implements OrderedFixtureInterface
{
    public function getOrder()
    {
        return 1;
    }

    public function load(ObjectManager $manager)
    {
        $this->createMany('user', User::class, $this->count, function (User $user) use ($manager) {
            $password = $this->encoder->encodePassword($user, 'lol');
            $user->setEmail($this->faker->email);
            $user->setPassword($password);
            $user->setUsername($this->faker->name);
            $user->setRoles($this->randoomRole());
        });
    }
}
