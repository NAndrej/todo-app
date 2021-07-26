<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(name="tasks")
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique="True")
     */
    private $text;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="tasks")
     * @JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;
    
    public function __construct(string $text)
    {
        $this->text = $text;
        $this->isDone = false;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(String $text)
    {
        $this->text = $text;
    }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function finish()
    {
        $this->isDone = true;
    }

    public function isTaskDone(): bool
    {
        return $this->isDone;
    }

    public function assignToUser(User $u)
    {
        $u->addTask($this);
        $this->user = $u;
    }
    
    public function getUser()
    {
        return $this->user;
    }

    public function unassignTask()
    {
        $this->user = null;
    }

    public function isAssigned(): bool
    {
        return $this->getUser() != null;
    }
    
}