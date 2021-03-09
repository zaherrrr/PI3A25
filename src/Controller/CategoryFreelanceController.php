<?php

namespace App\Controller;

use App\Entity\CategoryFreelance;
use App\Form\CategoryFreelanceType;
use App\Repository\CategoryFreelanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/freelance")
 */
class CategoryFreelanceController extends AbstractController
{
    /**
     * @Route("/", name="category_freelance_index", methods={"GET"})
     */
    public function index(CategoryFreelanceRepository $categoryFreelanceRepository): Response
    {
        return $this->render('category_freelance/index.html.twig', [
            'category_freelances' => $categoryFreelanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="category_freelance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categoryFreelance = new CategoryFreelance();
        $form = $this->createForm(CategoryFreelanceType::class, $categoryFreelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryFreelance);
            $entityManager->flush();

            return $this->redirectToRoute('category_freelance_index');
        }

        return $this->render('category_freelance/new.html.twig', [
            'category_freelance' => $categoryFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_freelance_show", methods={"GET"})
     */
    public function show(CategoryFreelance $categoryFreelance): Response
    {
        return $this->render('category_freelance/show.html.twig', [
            'category_freelance' => $categoryFreelance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="category_freelance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategoryFreelance $categoryFreelance): Response
    {
        $form = $this->createForm(CategoryFreelanceType::class, $categoryFreelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('category_freelance_index');
        }

        return $this->render('category_freelance/edit.html.twig', [
            'category_freelance' => $categoryFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_freelance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategoryFreelance $categoryFreelance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryFreelance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categoryFreelance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('category_freelance_index');
    }
}
