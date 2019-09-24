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
        public $task;
        public function __construct(Task $task)
        {
            $this->task = $task;
        }
        /**
         * Our custom method
         *
         * @return Task[]
         */
        public function findPostsByAuthor($done): array
        {
            return $this->findBy([
                'isDone' => $done
            ]);
        }


    }