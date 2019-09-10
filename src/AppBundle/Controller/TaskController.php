<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\TaskType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class TaskController extends Controller
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')
            ->findBy(['isDone' => false])]);
    }

    /**
     * @Route("/tasks/complete", name="task_list_done")
     */
    public function listActionDone()
    {
        return $this->render('task/list.html.twig', ['tasks' => $this->getDoctrine()->getRepository('AppBundle:Task')
            ->findBy(['isDone' => true])]);
    }

    /**
     * @Route("/tasks/create", name="task_create")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            if ($this->getUser()) {
                $task->setUser($this->getUser());
            }
            else{
                $task->setUser(null);
            }
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function editAction(Task $task, Request $request)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if ($task->getUser() === $this->getUser()) {

        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }
        }
        else
        {
            $this->addFlash('error', 'Vous ne pouvez pas modifier une tâche qui n\'est pas a vous.');
            return $this->redirectToRoute('homepage');

        }


        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);

    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task)
    {
        if ($task->isDone() === true) {
            $task->toggle(!$task->isDone());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('successDone', sprintf('La tâche %s a bien été marquée comme non terminé.', $task->getTitle
            ()));
            return $this->redirectToRoute('task_list');
        }else{
            $task->toggle(!$task->isDone());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
            return $this->redirectToRoute('task_list');
        }
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     */
    public function deleteTaskAction(Task $task)
    {
        if ($task->getUser() === $this->getUser()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');

            return $this->redirectToRoute('homepage');
        }
        else{

            $this->addFlash('error', 'Vous ne pouvez pas supprimer une tâche qui n\'est pas a vous');
            return $this->redirectToRoute('homepage');
        }
    }
}
