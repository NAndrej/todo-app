<?php
namespace App\Command;

use App\Service\TaskService;
use App\Entity\Task;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class AddTaskCommand extends Command
{
    protected static $defaultName = "app:create-task";
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription("Creates a new task")
            ->setHelp("This command will add a new task")
            ->addArgument('task', InputArgument::REQUIRED, 'task name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Task Creator',
            '===============================',
        ]);

        $task = $input->getArgument('task');
        $this->taskService->addTask(new Task($task));

        $output->writeln("Task " . $task . " successfuly created");
        return 0; 
    } 
}