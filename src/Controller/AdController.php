<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AnnoncesType;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo)
    {
        // $repo = $this->getDoctrine()->getRepository(Ad::class);
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet de créer une annonce
     *@Route("/ads/new", name="ads_create")
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager){
        $ad = new Ad();

        $form =  $this->createForm(AnnoncesType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Avant d'enregistrer l'annonce, on demande à symfony d'enregistrer toutes les images
            // avec l'utilisation de la boucle foreach()
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            //Enregistre les modifications apportées dans la BD avec ces deux lignes ci-dessous
            $manager->persist($ad);
            $manager->flush();

            // Ajoute un message flash

            $this->addFlash(
                "success",
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );

            // Rediriger vers une route après soummission
            return $this->redirectToRoute('ads_show', [
                'slug'=> $ad->getSlug()
            ]);
        }


        return $this->render('ad/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'afficher un formulaire d'édition
     * @Route("/ads/{slug}/edit", name="ads_edit")
     *
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager){
        
        // Création d'un formulaire
        $form =  $this->createForm(AnnoncesType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Avant d'enregistrer l'annonce, on demande à symfony d'enregistrer toutes les images
            // avec l'utilisation de la boucle foreach()
            foreach ($ad->getImages() as $image) {
                $image->setAd($ad);
                $manager->persist($image);
            }

            //Enregistre les modifications apportées dans la BD avec ces deux lignes ci-dessous
            $manager->persist($ad);
            $manager->flush();

            // Ajoute un message flash

            $this->addFlash(
                "success",
                "Les modifications de l'annonce <strong>{$ad->getTitle()}</strong> ont bien été enregistrées !"
            );

            // Rediriger vers une route après soummission
            return $this->redirectToRoute('ads_show', [
                'slug'=> $ad->getSlug()
            ]);
        }

        return $this->render('ad/edit.html.twig',[
            'form'=> $form->createView(),
            'ad' => $ad
        ]);

    }

    /**
     * Permet d'afficher une seule annonce avec la fonction findOneBy{nom_propriété}()
     *
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */
    public function show(Ad $ad){
        // $ad= $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig',[
            'ad' => $ad
        ]);
    }
}
