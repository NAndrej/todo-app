<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Task;
use App\Service\TaskService;
use Symfony\Component\Mailer\Mailer;

class TodoController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"}, name="home")
     */
    public function index(TaskService $taskService)
    {
        return $this->render("index.html.twig", [
                                'items' => $taskService->fetchAll(),
                            ]);
    }    
    /**
     * @Route("/insert", methods={"POST"}, name="insert_task")
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
     * @Route("/delete/id?={id}", methods={"GET"}, name="delete_task")
     */
    public function deleteTask(int $id, TaskService $taskService)
    {
        $taskService->removeTask($id);
        $taskService->flush();
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/finish/id?={id}", methods={"GET"}, name="finish_task")
     */
    public function finishTask(int $id, TaskService $taskService)
    {
        $taskService->finishTask($id);
        return $this->redirectToRoute('home');
    }
}