<?php

namespace App\Controller;

use App\Entity\OffreFreelance;
use App\Form\OffreFreelanceType;
use App\Repository\OffreFreelanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/offre/freelance")
 */
class OffreFreelanceController extends AbstractController
{
    /**
     * @Route("/", name="offre_freelance_index", methods={"GET"})
     */
    public function index(OffreFreelanceRepository $offreFreelanceRepository): Response
    {
        return $this->render('offre_freelance/index.html.twig', [
            'offre_freelances' => $offreFreelanceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="offre_freelance_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $offreFreelance = new OffreFreelance();
        $form = $this->createForm(OffreFreelanceType::class, $offreFreelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offreFreelance);
            $entityManager->flush();

            return $this->redirectToRoute('offre_freelance_index');
        }

        return $this->render('offre_freelance/new.html.twig', [
            'offre_freelance' => $offreFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offre_freelance_show", methods={"GET"})
     */
    public function show(OffreFreelance $offreFreelance): Response
    {
        return $this->render('offre_freelance/show.html.twig', [
            'offre_freelance' => $offreFreelance,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="offre_freelance_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OffreFreelance $offreFreelance): Response
    {
        $form = $this->createForm(OffreFreelanceType::class, $offreFreelance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('offre_freelance_index');
        }

        return $this->render('offre_freelance/edit.html.twig', [
            'offre_freelance' => $offreFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="offre_freelance_delete", methods={"DELETE"})
     */
    public function delete(Request $request, OffreFreelance $offreFreelance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offreFreelance->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($offreFreelance);
            $entityManager->flush();
        }

        return $this->redirectToRoute('offre_freelance_index');
    }
}
