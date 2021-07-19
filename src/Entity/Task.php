<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity
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
     * @ORM\Column(type="string", length=100)
     */
    private $text;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;
    
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
}