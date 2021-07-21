<?php

namespace App\Service;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Task;

class TaskService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function fetchAll(): array
    {
        return $this->entityManager
                    ->getRepository(Task::class)
                    ->findAll();
    }

    public function addTask(Task $task)
    {
        $this->entityManager->persist($task);
    }

    public function fetchTask(int $id): Task
    {
        return $this->entityManager
                    ->getRepository(Task::class)
                    ->findOneBy(array(
                        "id" => $id
                    ));
    }

    public function removeTask(int $id)
    {
        $currentTask = $this->fetchTask($id);
        $this->entityManager->remove($currentTask);
    }

    public function finishTask(int $id)
    {
        $currentTask = $this->fetchTask($id);
        $currentTask->finish();
        $this->flush();
    }

    public function flush()
    {
        $this->entityManager->flush();
    }

}