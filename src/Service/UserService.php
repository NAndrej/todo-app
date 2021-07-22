<?php
namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function fetchAll(): array
    {
        return $this->entityManager
                    ->getRepository(User::class)
                    ->findAll();
    }

    public function fetchUserByEmail(string $email)
    {
        return $this->entityManager
                    ->getRepository(User::class)
                    ->findOneBy([
                        "email" => $email
                    ]);
    }

    public function fetchUserById(int $id)
    {
        return $this->entityManager
                    ->getRepository(User::class)
                    ->findOneBy([
                        "id" => $id
                    ]);
    }

    public function insertUser(User $u)
    {
        $this->entityManager->persist($u);
    }
    
    public function flush()
    {
        $this->entityManager->flush();
    }

    public function removeUser(int $id)
    {
        $currentUser = $this->fetchUserById($id);
        $this->entityManager->remove($currentUser);
    }
}