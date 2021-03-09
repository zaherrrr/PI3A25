<?php

namespace App\Controller;

use App\Entity\CategorieFormation;
use App\Form\CategorieFormationType;
use App\Repository\CategorieFormationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/formation")
 */
class CategorieFormationController extends AbstractController
{
    /**
     * @Route("/", name="categorie_formation_index", methods={"GET"})
     */
    public function index(CategorieFormationRepository $categorieFormationRepository): Response
    {
        return $this->render('categorie_formation/index.html.twig', [
            'categorie_formations' => $categorieFormationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_formation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieFormation = new CategorieFormation();
        $form = $this->createForm(CategorieFormationType::class, $categorieFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieFormation);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_formation_index');
        }

        return $this->render('categorie_formation/new.html.twig', [
            'categorie_formation' => $categorieFormation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_formation_show", methods={"GET"})
     */
    public function show(CategorieFormation $categorieFormation): Response
    {
        return $this->render('categorie_formation/show.html.twig', [
            'categorie_formation' => $categorieFormation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieFormation $categorieFormation): Response
    {
        $form = $this->createForm(CategorieFormationType::class, $categorieFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_formation_index');
        }

        return $this->render('categorie_formation/edit.html.twig', [
            'categorie_formation' => $categorieFormation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_formation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieFormation $categorieFormation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieFormation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_formation_index');
    }
}
