<?php

namespace App\Controller;

use App\Entity\OffreEmploi;
use App\Form\OffreEmploiType;
use App\Form\PostulerEmploiType;
use App\Repository\OffreEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreEmploiController extends AbstractController
{
    /**
     * @Route("/offre/emploi", name="offre_emploi")
     */
    public function index(): Response
    {
        return $this->render('offre_emploi/index.html.twig', [
            'controller_name' => 'OffreEmploiController',
        ]);
    }
    /**
     * @Route("/afficherOE", name="offre_emploi_affichage", methods={"GET"})
     */
    public function index2(OffreEmploiRepository $OffreEmploiRepository): Response
    {
        return $this->render('offre_emploi/afficheroffreEmploiFront.html.twig', [
            'offre_emplois' => $OffreEmploiRepository->findAll()
        ]);
    }
    /**
     * @Route("/newOEB", name="offre_emploi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offreEmploi = new OffreEmploi();
        $form = $this->createForm(OffreEmploiType::class, $offreEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $offreEmploi->setNbrOffres(0);
            $entityManager->persist($offreEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('offre_emploi_affichage');
        }

        return $this->render('offre_emploi/index.html.twig', [
            'offre_emploi' => $offreEmploi,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/newOEBFF", name="ajouterEMPF", methods={"GET","POST"})
     */
    public function newFF(Request $request): Response
    {
        $offreEmploi = new OffreEmploi();
        $form = $this->createForm(OffreEmploiType::class, $offreEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $offreEmploi->setNbrOffres(0);
            $entityManager->persist($offreEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('FrontEmploi');
        }

        return $this->render('admin/ajoutemploiFront.html.twig', [
            'offre_emploi' => $offreEmploi,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/SupprimerOEB/{id}",name="OffreEmploi_supprimer")
     */
    public function SupprimerBlog(OffreEmploiRepository $repository , $id)
    {
        $blog = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute("offre_emploi_affichage");
    }
    /**
     * @Route ("/ModifierOEB/{id}",name="OffreEmploi_modification")
     */
    public function ModifierBlog(OffreEmploiRepository $repository , Request $request , $id){
        $blog=$repository->find($id);
        $form=$this->createForm(OffreEmploiType::class,$blog);

        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute("offre_emploi_affichage");
        }
        return $this->render('offre_emploi/modifierOffreEmploi.html.twig', [

            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/listePostulation/{id}",name="listePostulation")
     */
    public function listePostulation(OffreEmploiRepository $repository , Request $request , $id){
        $offre=$repository->find($id);

        return $this->render('admin/listePostulation.html.twig', [

            'offre' => $offre,
        ]);
    }

}
