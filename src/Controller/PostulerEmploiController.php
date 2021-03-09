<?php

namespace App\Controller;

use App\Entity\PostulerEmploi;
use App\Form\PostulerEmploiType;
use App\Repository\PostulerEmploiRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/postuler/emploi")
 */
class PostulerEmploiController extends AbstractController
{
    /**
     * @Route("/", name="postuler_emploi_index", methods={"GET"})
     */
    public function index(PostulerEmploiRepository $postulerEmploiRepository): Response
    {
        return $this->render('postuler_emploi/index.html.twig', [
            'postuler_emplois' => $postulerEmploiRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="postuler_emploi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $postulerEmploi = new PostulerEmploi();
        $form = $this->createForm(PostulerEmploiType::class, $postulerEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($postulerEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('postuler_emploi_index');
        }

        return $this->render('postuler_emploi/new.html.twig', [
            'postuler_emploi' => $postulerEmploi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="postuler_emploi_show", methods={"GET"})
     */
    public function show(PostulerEmploi $postulerEmploi): Response
    {
        return $this->render('postuler_emploi/show.html.twig', [
            'postuler_emploi' => $postulerEmploi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="postuler_emploi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PostulerEmploi $postulerEmploi): Response
    {
        $form = $this->createForm(PostulerEmploiType::class, $postulerEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('postuler_emploi_index');
        }

        return $this->render('postuler_emploi/edit.html.twig', [
            'postuler_emploi' => $postulerEmploi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="postuler_emploi_delete", methods={"DELETE"})
     */
    public function delete(Request $request, PostulerEmploi $postulerEmploi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$postulerEmploi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($postulerEmploi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('postuler_emploi_index');
    }
}
