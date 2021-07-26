<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\TaskRepository;
use App\Repository\UserRepository;
use App\Service\TaskService;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"}, name="home")
     */
    public function index(TaskService $taskService, UserService $userService)
    {
        return $this->render("index.html.twig", [
                                'tasks' => $taskService->fetchAll(),
                                'users'=> $userService->fetchAll()
                            ]);
    }    

    /**
     * @Route("/tasks/insert", methods={"POST"}, name="insert_task")
     */
    public function insertTask(TaskService $taskService)
    {
        $task = new Task($_POST["task"]);

        if (strlen($task->getText()) > 0)
        {
            $taskService->addTask($task);
            $taskService->flush();
        }
        return $this->redirectToRoute('manage_tasks');
    }
    
    /**
     * @Route("/tasks/delete/id?={id}", methods={"GET"}, name="delete_task")
     */
    public function deleteTask(int $id, TaskService $taskService)
    {
        $taskService->removeTask($id);
        $taskService->flush();
        return $this->redirectToRoute('manage_tasks');
    }

    /**
     * @Route("/tasks/finish/id?={id}", methods={"GET"}, name="finish_task")
     */
    public function finishTask(int $id, TaskService $taskService)
    {
        $taskService->finishTask($id);
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/tasks", methods={"POST"}, name="search_tasks")
     */
    public function searchTask(TaskRepository $taskRepository, Request $request)
    {   
        $searchParam = $request->get('q');

        return $this->render(
            "tasks.html.twig", [
                'tasks' => $taskRepository->searchAll($searchParam),
            ]
        );
    }

    /**
     * @Route("/tasks", methods={"GET"}, name="manage_tasks")
     */
    public function manageTasks()
    {
        $taskRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository("App:Task");

        return $this->render(
            "tasks.html.twig", [
                'tasks' => $taskRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/tasks/assign/id?={id}", methods={"GET"}, name="assign_task")
     */
    public function assignTask(TaskRepository $taskRepository, 
                                Request $request, 
                                UserRepository $userRepository,
                                EntityManagerInterface $entityManager)
    {
        $taskId = $request->get("id");
        $userEmail = $request->get("user_email");

        $task = $taskRepository->findOneBy([
            "id"=>$taskId
        ]);

        $user = $userRepository->findOneBy([
            "email"=>$userEmail
        ]);

        $task->assignToUser($user);
        $entityManager->flush();
        return $this->render(
            "tasks.html.twig", [
                'tasks' => $taskRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/tasks/unassign/id?={id}", methods={"GET"}, name="unassign_task")
     */
    public function unassignTask(TaskRepository $taskRepository, 
                                Request $request,
                                EntityManagerInterface $entityManager)                                
    {
        $taskId = $request->get("id");

        $task = $taskRepository->findOneBy([
            "id"=>$taskId
        ]);

        $task->unassignTask();
        $entityManager->flush();

        return $this->render(
            "tasks.html.twig", [
                'tasks' => $taskRepository->findAll(),
            ]
        );
    }
    
}