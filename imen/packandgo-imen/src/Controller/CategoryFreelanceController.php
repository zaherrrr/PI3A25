<?php

namespace App\Controller;

use App\Entity\CategoryFreelance;
use App\Entity\OffreFreelance;
use App\Form\CategoryFreelanceType;
use App\Repository\CategoryFreelanceRepository;
use App\Repository\OffreFreelanceRepository;
use App\Repository\PostulerFreelanceRepository;
use App\Repository\UsersRepository;
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
        return $this->render('backend/categoriefreelance.html.twig', [
            'category_freelance' => $categoryFreelanceRepository->findAll(),
        ]);
    }
    /**
     * @Route("/FrontFreelance", name="category_freelance_indexFront", methods={"GET"})
     */
    public function index2(CategoryFreelanceRepository $categoryFreelanceRepository): Response
    {
        return $this->render('admin/CategorieFreelance.html.twig', [
            'category_freelance' => $categoryFreelanceRepository->findAll(),
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
            $categoryFreelance->setNbrOffreFr(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoryFreelance);
            $entityManager->flush();

            return $this->redirectToRoute('category_freelance_index');
        }

        return $this->render('backend/ajouterCategorieFreelance.html.twig', [
            'category_freelance' => $categoryFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="category_freelance_show", methods={"GET"})
     */
    public function show(CategoryFreelance $categoryFreelance): Response
    {
        return $this->render('backend/categoriefreelance.html.twig', [
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

        return $this->render('backend/modifierCategorieFreelance.html.twig', [
            'category_freelance' => $categoryFreelance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deletFFF/{id}", name="category_freelance_delete")
     */
    public function delete(Request $request, $id,CategoryFreelanceRepository $repository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();
        return $this->redirectToRoute('category_freelance_index');
    }
    /**
     * @Route("/frontCategorieDetail/{id}", name="frontCDfreelance")
     */
    public function Details(CategoryFreelanceRepository $repository ,PostulerFreelanceRepository$repository1,UsersRepository$repository2,$id,Request $request)
    {$blog = $repository->find($id);


        $testOffre=array();
        array_push($testOffre,0);
        $pp=null;
        $user=$this->getUser();
        $userConnecter=$repository2->findOneBy(array('username'=>$user->getUsername()));
        foreach ($blog->getOffreFreelances() as $e)
        {

            $pp=$repository1->findOneBySomeField($e->getId(),$userConnecter->getId());
            if($pp)
            {
                array_push($testOffre,$e->getId());

            }




        }


        return $this->render('admin/CategorieFreelanceDetail.html.twig', [
            'categorie' => $blog,
            'testoffre'=>$testOffre,


        ]);



    }
    /**
     * @Route ("/SupprimerPostulationFreelance/{id}/{id1}",name="PostulerFreelancesupp")
     */
    public function SupprimerPostulationEmploi(OffreFreelanceRepository$repository ,$id1, $id,UsersRepository $repository1,PostulerFreelanceRepository $repository2)
    {
        $blog = $repository->find($id);
        $user=$this->getUser();
        $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
        $postul=$repository2->findOneBySomeField($id,$userConnecter->getId());
        $em = $this->getDoctrine()->getManager();
        $em->remove($postul);
        $em->flush();
        return $this->redirect('/category/freelance/frontCategorieDetail/'.$id1);
    }
}
