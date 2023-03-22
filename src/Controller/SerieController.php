<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SeasonRepository;
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
     //   $series = $serieRepository->findBy([],['popularity'=>'Desc'],30);
        $series = $serieRepository->findBestSeries();
        dump($series);

        return $this->render('serie/list.html.twig', [
            'series' => $series ]);
    }

    #[Route('/details/{id}', name: "details")]
    public function details(int $id, SerieRepository $serieRepository):Response{
        //todo: aller chercher la serien en fonction de son id en BDD
    $serie = $serieRepository->find($id);

    dump($serie);
    foreach ($serie->getSeasons() as $season){
        dump($season);
    }

    dump($serie);


        return $this->render("serie/details.html.twig",[
            //passer la série à twig
            'serie'=> $serie
        ]);

    }
    #[Route('/create', name: "create")]
public function create(Request $request, EntityManagerInterface $entityManager):Response{
    //étape 1 : créer une instance de série
        $serie = new Serie();

    //etape 2 : instance de formulaire
        $serieForm = $this->createForm(SerieType::class, $serie);
        dump($serie);
        $serieForm->handleRequest($request);
        dump($serie);

        if($serieForm->isSubmitted()){
            $serie->setDateCreated(new \DateTime('now'));
            $entityManager ->persist($serie);
            $entityManager->flush();

            $this->addFlash("success", "Serie added!!");
            return $this->redirectToRoute('series_details',['id'=>$serie->getId()]);
        }

    return $this->render("/serie/create.html.twig", [
        'serieForm' => $serieForm
    ]);

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


    #[Route('/delete/{id}', name: "serie_delete")]
    public function delete(int $id, SerieRepository $serieRepository, EntityManagerInterface $entityManager):Response{

        $serie = $serieRepository->find($id);

        $entityManager->remove($serie);
        $entityManager->flush();



        return $this->render('serie/list.html.twig');


    }

#[Route('season/dissociate',name: 'season_dissociate')]
public function dissociateSeasonWithSerie(SeasonRepository $seasonRepository){
        $season = $seasonRepository->find(10);
        $season->setSerie(null);
        $series=[];

        return $this->render('serie/list.html.twig',[
            'series'=>$series
        ]);


}


}
