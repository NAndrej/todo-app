<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\TodoController;
use App\Entity\User;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/users/insert", methods={"POST"}, name="insert_user")
     */
    public function insertUser(UserService $userService)
    {
        $user = new User($_POST["user_name"], $_POST["user_email"]);
        $userService->insertUser($user);
        $userService->flush();

        return $this->forward(
            "App\Controller\TodoController::index"
        );
    }
    /**
     * @Route("/users/delete/id?={id}", methods={"GET"}, name="delete_user")
     */
    public function deleteUser(int $id, UserService $userService)
    {
        $userService->removeUser($id);
        $userService->flush();
        return $this->forward(
            "App\Controller\TodoController::index"
        );
    }

}