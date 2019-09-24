<?php
    namespace AppBundle\Repository;

    use AppBundle\Entity\User;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;
    use Doctrine\Common\Persistence\ObjectManager;

    /**
     * @method User|null find($id, $lockMode = null, $lockVersion = null)
     * @method User|null findOneBy(array $criteria, array $orderBy = null)
     * @method User[]    findAll()
     * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */

    class UserRepository extends ServiceEntityRepository
    {
        private $em;

        public function __construct(
            RegistryInterface $registry,
            ObjectManager $em
        ) {
            parent::__construct($registry, User::class);
            $this->em = $em;
        }
    }
