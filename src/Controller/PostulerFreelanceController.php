<?php

namespace App\Controller;

use App\Entity\PostulerFreelance;
use App\Form\PostulerFreelanceType;
use App\Repository\PostulerFreelanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/postuler/freelance")
 */
class PostulerFreelanceController extends AbstractController
{
    /**
     * @Route("/", name="postuler_freelance_index", methods={"GET"})
     */
    public function index(PostulerFreelanceRepository $postulerFreelanceRepository): Response
    {
        return $this->render('postuler_freelance/index.html.twig', [
            'postuler_freelances' => $postulerFreelanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="postuler_freelance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $postulerFreelance = new PostulerFreelance();
        $form = $this->createForm(PostulerFreelanceType::class, $postulerFreelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postulerFreelance);
            $entityManager->flush();

            return $this->redirectToRoute('postuler_freelance_index');
        }

        return $this->render('postuler_freelance/new.html.twig', [
            'postuler_freelance' => $postulerFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="postuler_freelance_show", methods={"GET"})
     */
    public function show(PostulerFreelance $postulerFreelance): Response
    {
        return $this->render('postuler_freelance/show.html.twig', [
            'postuler_freelance' => $postulerFreelance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="postuler_freelance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PostulerFreelance $postulerFreelance): Response
    {
        $form = $this->createForm(PostulerFreelanceType::class, $postulerFreelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('postuler_freelance_index');
        }

        return $this->render('postuler_freelance/edit.html.twig', [
            'postuler_freelance' => $postulerFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="postuler_freelance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PostulerFreelance $postulerFreelance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postulerFreelance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postulerFreelance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('postuler_freelance_index');
    }
}
