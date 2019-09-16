<?php

namespace AppBundle\Security;

    use AppBundle\Entity\Task;
    use Symfony\Component\Security\Core\Authorization\Voter\Voter;
    use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
    use Symfony\Component\Security\Core\User\UserInterface;

    class UserVoter extends Voter
    {
        protected function supports($attribute, $subject)
        {
            return in_array($attribute,['EDIT','DELETE']) && $subject instanceof Task;
        }
        protected function voteOnAttribute($attribute, $task,TokenInterface  $token)
        {
            $user = $token->getUser();
            if (!$user instanceof UserInterface) {
               return false;
            }
            if ($task->getUser()->getId() == null)
            {
                return $user->getRoles() == ['ROLE_ADMIN'];
            }
            switch ($attribute){
                case 'EDIT' || 'DELETE':
                    return $task->getUser()->getId() == $user->getId();
                    break;
            }
            return false;
        }
    }