<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\OffreFreelance;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use App\Repository\PostulerFreelanceRepository;
use App\Repository\UsersRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{
    /**
     * @Route("/", name="formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('backend/formation.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin", name="formation_index2", methods={"GET"})
     */
    public function index2(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index2.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/imp", name="equipment_imp", methods={"GET"})
     */
    public function imp(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/imp.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="formation_new", methods={"GET","POST"})
     */
    public function new(Request $request,UsersRepository $repository): Response
    {$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $userConnecter=$repository->findOneBy(array('username'=>$user->getUsername()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('backend/ajouterFormation.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin", name="formation_new2", methods={"GET","POST"})
     */
    public function new2(Request $request): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('formation/new2.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Formation $formation): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formation_index');
        }

        return $this->render('backend/modifierFormation.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/formation/deleteFormation/{id}", name="formation_delete")
     */
    public function delete(Request $request, $id,FormationRepository $repository)
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($repository->find($id));
            $entityManager->flush();


        return $this->redirectToRoute('formation_index');
    }

}
