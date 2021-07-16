<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Task;

class TodoController extends AbstractController
{

    /**
     * @Route("/", name="index", methods={"GET"}, name="home")
     */
    public function index()
    {
        return $this->render("index.html.twig", [
                                'items' => $this->fetchTasks(),
                            ]);
    }    

    /**
     * @Route("/insert", methods={"POST"}, name="insert_task")
     */
    public function insertTask()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $task = new Task($_POST["task"]);
        
        if (strlen($task->getText()) > 0) {
            $entityManager->persist($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/delete/id?={id}", methods={"GET"}, name="delete_task")
     */
    public function deleteTask(int $id){
        $entityManager = $this->getDoctrine()->getManager();
        $currentTask = $entityManager->getRepository(Task::class)
                                    ->findOneBy(array(
                                        "id" => $id
                                    ));

        $entityManager->remove($currentTask);
        $entityManager->flush();

        return $this->redirectToRoute('home');
    }

    public function fetchTasks()
    {
        return $this->getDoctrine()
                    ->getRepository(Task::class)
                    ->findAll();
    }
}