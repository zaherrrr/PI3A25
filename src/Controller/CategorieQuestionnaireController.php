<?php

namespace App\Controller;

use App\Entity\CategorieQuestionnaire;
use App\Form\CategorieQuestionnaire1Type;
use App\Repository\CategorieQuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/questionnaire")
 */
class CategorieQuestionnaireController extends AbstractController
{
    /**
     * @Route("/", name="categorie_questionnaire_index", methods={"GET"})
     */
    public function index(CategorieQuestionnaireRepository $categorieQuestionnaireRepository): Response
    {
        return $this->render('categorie_questionnaire/index.html.twig', [
            'categorie_questionnaires' => $categorieQuestionnaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_questionnaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieQuestionnaire = new CategorieQuestionnaire();
        $form = $this->createForm(CategorieQuestionnaire1Type::class, $categorieQuestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieQuestionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_questionnaire_index');
        }

        return $this->render('categorie_questionnaire/new.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_questionnaire_show", methods={"GET"})
     */
    public function show(CategorieQuestionnaire $categorieQuestionnaire): Response
    {
        return $this->render('categorie_questionnaire/show.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_questionnaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieQuestionnaire $categorieQuestionnaire): Response
    {
        $form = $this->createForm(CategorieQuestionnaire1Type::class, $categorieQuestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_questionnaire_index');
        }

        return $this->render('categorie_questionnaire/edit.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_questionnaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieQuestionnaire $categorieQuestionnaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieQuestionnaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieQuestionnaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_questionnaire_index');
    }
}
