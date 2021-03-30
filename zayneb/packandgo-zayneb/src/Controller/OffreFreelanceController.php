<?php

namespace App\Controller;

use App\Entity\OffreFreelance;
use App\Form\OffreFreelanceType;
use App\Repository\OffreFreelanceRepository;
use Doctrine\ORM\Mapping\Entity;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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
     * @Route("/indesx2/{req}/", name="offre_freelance_index_cat2", methods={"GET"})
     */
    public function index2($req)
    {
        $em = $this->getDoctrine()->getManager();
        $entities  = $em->getRepository( OffreFreelance::class)->findBy(array('entreprisefr' => $req));
//              var_dump($entities);
//        exit();


        $article = $em->getRepository( OffreFreelance::class)->findAll();
        $entreprises = array();
        foreach( $article as $art ){
            array_push($entreprises, $art->getTitreOffreFr());
        }
        return $this->render('Offre_freelance/index.html.twig', array(
            "offre_freelances"=>$entities,
            "entreprises"=>$entreprises,
        ));
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

            return $this->redirectToRoute('offre_freelance_show');
        }

        return $this->render('backend/ajouterFreelance.html.twig', [
            'offre_freelance' => $offreFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/", name="offre_freelance_show", methods={"GET"})
     */
    public function index(OffreFreelanceRepository $questionnaireRepository): Response
    {
        return $this->render('backend/freelance.html.twig', [
            'freelance' => $questionnaireRepository->findAll(),
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

            return $this->redirectToRoute('offre_freelance_show');
        }

        return $this->render('backend/modifierFreelance.html.twig', [
            'offre_freelance' => $offreFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/offre/freelance/{id}", name="offre_freelance_delete")
     */
    public function delete(Request $request,$id,OffreFreelanceRepository $repository)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();


        return $this->redirectToRoute('offre_freelance_show');
    }
}
