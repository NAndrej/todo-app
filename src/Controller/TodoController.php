<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Task;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\TaskService;
use App\Service\UserService;

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
        
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/tasks/delete/id?={id}", methods={"GET"}, name="delete_task")
     */
    public function deleteTask(int $id, TaskService $taskService)
    {
        $taskService->removeTask($id);
        $taskService->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/tasks/finish/id?={id}", methods={"GET"}, name="finish_task")
     */
    public function finishTask(int $id, TaskService $taskService)
    {
        $taskService->finishTask($id);
        return $this->redirectToRoute('home');
    }
}