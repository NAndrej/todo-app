<?php

namespace App\Command;

use App\Service\TaskService;
use App\Service\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class AssignTaskCommand extends Command
{
    protected static $defaultName = "app:assign-task";
    private $taskService;
    private $userService;
    
    public function __construct(TaskService $taskService, UserService $userService)
    {
        $this->taskService = $taskService;
        $this->userService = $userService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument("taskName", InputArgument::REQUIRED)
            ->addArgument("userEmail", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $taskName = $input->getArgument("taskName");
        $userEmail = $input->getArgument("userEmail");

        $task = $this
                    ->taskService
                    ->fetchTaskByName($taskName);
        $user = $this
                    ->userService
                    ->fetchUserByEmail($userEmail);

        $task->assignToUser($user);
        $this->taskService->flush();
        
        return 0;
    } 
}