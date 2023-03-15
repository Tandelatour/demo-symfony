<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/series', name: 'series_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'liste')]
       public function liste(): Response
    {

        //todo aller chercher les series dans la bdd

        return $this->render('serie/list.html.twig', [

        ]);
    }

    #[Route('/details/{id}', name: "details")]
    public function details(int $id):Response{
        //todo: aller chercher la serien en fonction de son id en BDD

        return $this->render("serie/details/list.html.twig",[
            //passer la série à twig
        ]);

    }
    #[Route('/create', name: "create")]
public function create(Request $request):Response{


           dump($request);


    return $this->render("/serie/create.html.twig");

}



}
