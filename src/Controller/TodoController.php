<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController{

    private $itemList = array(
        "Daily meeting", 
        "Videos"
    );

    /**
     * @Route("/hello")
     */
    public function hello(){
        return $this->render("index.html.twig", [
            'items' => $this->itemList,
        ]);
    }
}