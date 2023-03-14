<?php

namespace App\Controller;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
//crochet = bone facon de declarer une route

    #[Route("/",name: "main_home")]
    public function home(){
        //retourne une réponse au navigateur
     return $this->render('main/home.html.twig');
    }
    /*  ranger ca dans une annotation
     * @Route("/test", name="main_test")
     *
     */
    #[Route("/test",name: "main_test")]
    public function test(){

        $film=[
            'titre'=>'avatar',
            'tempsFilm'=>180
        ];



return $this->render('main/test.html.twig',[
    "monFilm" => $film,
    "autreVariable" => 123
]);
    }

}