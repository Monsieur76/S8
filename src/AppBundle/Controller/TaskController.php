<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use AppBundle\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TaskController
 * @package AppBundle\Controller
 * @Route("/tasks")
 */
class TaskController extends AbstractController
{

    /**
     * @Route("/", name="task_list")
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' =>
            false])]);
    }

    /**
     * @Route("/complete", name="task_list_done")
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function listActionDone(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findBy(['isDone' =>
            true])]);
    }

    /**
     * @Route("/create", name="task_create")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request, EntityManagerInterface $em)
    {
        $task = new Task();
        $user = null;
        if ($this->getUser()) {
            $user = $this->getUser()->getRoles();
        }
        $form = $this->createForm(TaskType::class, $task, ['attr'=>['creat',$user[0]]]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $task->setUser($this->getUser());
            if ($this->getUser() === null) {
                $task->setAuthor('Anonyme');
            }
            $em->persist($task);
            $em->flush();
            $this->addFlash('success', 'La tâche a été bien été ajoutée.');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     * @param Task $task
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(Task $task, Request $request)
    {
        $this->denyAccessUnlessGranted('EDIT', $task);
        $user = $this->getUser()->getRoles();
        $form = $this->createForm(TaskType::class, $task, ['attr'=>['edit',$user[0]]]);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'La tâche a bien été modifiée.');
            return $this->redirectToRoute('task_list');
        }
        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/{id}/toggle", name="task_toggle")
     * @param Task $task
     * @return RedirectResponse
     */
    public function toggleTaskAction(Task $task)
    {
        if ($task->isDone() === true) {
            $task->toggle(!$task->isDone());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('successDone', sprintf('La tâche %s a bien été marquée comme non terminé.', $task->getTitle()));
            return $this->redirectToRoute('task_list');
        } else {
            $task->toggle(!$task->isDone());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));
            return $this->redirectToRoute('task_list');
        }
    }

    /**
     * @Route("/{id}/delete", name="task_delete")
     * @IsGranted({"ROLE_ADMIN","ROLE_USER"})
     * @param Task $task
     * @return RedirectResponse
     */
    public function deleteTaskAction(Task $task)
    {
        $this->denyAccessUnlessGranted('DELETE', $task);
        $user = $this->getUser()->getRoles();
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();
        $this->addFlash('success', 'La tâche a bien été supprimée.');
        return $this->redirectToRoute('homepage');
    }
}
