<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/series', name: 'series_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'liste')]
       public function liste(SerieRepository $serieRepository): Response
    {

       // $series = $serieRepository->findAll();
        $series = $serieRepository->findBy([],['popularity'=>'Desc'],30);
        dump($series);

        return $this->render('serie/list.html.twig', [
            'series' => $series ]);
    }

    #[Route('/details/{id}', name: "details")]
    public function details(int $id, SerieRepository $serieRepository):Response{
        //todo: aller chercher la serien en fonction de son id en BDD
    $serie = $serieRepository->find($id);



        return $this->render("serie/details.html.twig",[
            //passer la série à twig
            'serie'=> $serie
        ]);

    }
    #[Route('/create', name: "create")]
public function create(Request $request):Response{


           dump($request);


    return $this->render("/serie/create.html.twig");

}
    #[Route('/demo',name:"demo")]
public function demo(EntityManagerInterface $entityManager){
        $serie = new Serie();
        $serie->setName('adventure time');
        $serie->setBackdrop('test');
        $serie->setPoster('poster');
        $serie->setDateCreated(new \DateTime());
        $serie->setFirstAirDate(new \DateTime('-1 year'));
        $serie->setLastAirDate(new \DateTime('-6 mouths'));
        $serie->setGenre('Fantasy');
        $serie->setOverview('blablabla');
        $serie->setVote(1.5);
        $serie->setPopularity(5.20);
        $serie->setStatus('cancelled');
        $serie->setTmdbId(1234);

        dump($serie);

        //enrengistre dans la bdd
        $entityManager->persist($serie);
        //commit / valide dans la bdd
        $entityManager->flush();
        dump($serie);
  //      $entityManager->remove($serie);
   //     $entityManager->flush();

        $serie->setGenre('rigolerie');
        $entityManager->flush();


        return $this->render('serie/create.html.twig');
}






}
