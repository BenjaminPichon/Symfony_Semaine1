<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index(EntityManagerInterface $entityManager, Request $request)
    {
        $tasks = new task();
        $form = $this->createForm(TaskType::class, $tasks);

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()){
            $task = $form->getData();
            $task->setInscriptionDate(new \DateTime());

            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('users');
        }

        $taskRepository = $this->getDoctrine()
        ->getRepository(task::class)
        ->findAll();

        return $this->render('task/index.html.twig', [
            'Tasks' => $taskRepository ,
            'TaskForm' => $form->createView()
        ]);
    }
}
