<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\TodoController;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;

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

        // return $this->forward(
        //     "App\Controller\TodoController::index"
        // );
        return $this->redirectToRoute("manage_users");
    }
    /**
     * @Route("/users/delete/id?={id}", methods={"GET"}, name="delete_user")
     */
    public function deleteUser(int $id, UserService $userService)
    {
        $userService->removeUser($id);
        $userService->flush();
        // return $this->forward(
        //     "App\Controller\TodoController::index"
        // );
        return $this->redirectToRoute("manage_users");
    }

    /**
     * @Route("/users", methods={"GET"}, name="manage_users")
     */
    public function manageUsers()
    {
        $users = [];
        $userRepository = $this->getDoctrine()
                                ->getManager()
                                ->getRepository("App:User");
        return $this->render(
            "users.html.twig", [
                'users' => $userRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/users", methods={"POST"}, name="search_users")
     */
    public function searchTask(UserRepository $userRepository, Request $request)
    {   
        $searchParam = $request->get('q');

        return $this->render(
            "users.html.twig", [
                'users' => $userRepository->searchAll($searchParam),
            ]
        );
    }

}