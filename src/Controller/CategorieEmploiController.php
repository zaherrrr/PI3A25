<?php

namespace App\Controller;

use App\Entity\CategorieEmploi;
use App\Form\CategorieEmploiType;
use App\Repository\CategorieEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/emploi")
 */
class CategorieEmploiController extends AbstractController
{
    /**
     * @Route("/", name="categorie_emploi_index", methods={"GET"})
     */
    public function index(CategorieEmploiRepository $categorieEmploiRepository): Response
    {
        return $this->render('categorie_emploi/index.html.twig', [
            'categorie_emplois' => $categorieEmploiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_emploi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieEmploi = new CategorieEmploi();
        $form = $this->createForm(CategorieEmploiType::class, $categorieEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_emploi_index');
        }

        return $this->render('categorie_emploi/new.html.twig', [
            'categorie_emploi' => $categorieEmploi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_emploi_show", methods={"GET"})
     */
    public function show(CategorieEmploi $categorieEmploi): Response
    {
        return $this->render('categorie_emploi/show.html.twig', [
            'categorie_emploi' => $categorieEmploi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_emploi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieEmploi $categorieEmploi): Response
    {
        $form = $this->createForm(CategorieEmploiType::class, $categorieEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_emploi_index');
        }

        return $this->render('categorie_emploi/edit.html.twig', [
            'categorie_emploi' => $categorieEmploi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_emploi_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieEmploi $categorieEmploi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieEmploi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieEmploi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_emploi_index');
    }
}
