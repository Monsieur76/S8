<?php
    namespace AppBundle\Repository;

    use AppBundle\Entity\Task;
    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Symfony\Bridge\Doctrine\RegistryInterface;
    use Doctrine\Common\Persistence\ObjectManager;

    /**
     * @method Task|null find($id, $lockMode = null, $lockVersion = null)
     * @method Task|null findOneBy(array $criteria, array $orderBy = null)
     * @method Task[]    findAll()
     * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */

    class TaskRepository extends ServiceEntityRepository
    {
        private $em;

        public function __construct(RegistryInterface $registry, ObjectManager $em)
        {
            parent::__construct($registry, Task::class);
            $this->em = $em;
        }
    }
