<?php

namespace App\Controller;

use App\Entity\CategorieEmploi;
use App\Form\CategorieEmploiType;
use App\Repository\CategorieEmploiRepository;
use App\Repository\OffreEmploiRepository;
use App\Repository\PostulerEmploiRepository;
use App\Repository\UsersRepository;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

class CategorieEmploiController extends AbstractController
{
    /**
     * @Route("/categorie/emploi", name="categorie_emploi")
     */
    public function index(): Response
    {
        return $this->render('categorie_emploi/index.html.twig', [
            'controller_name' => 'CategorieEmploiController',
        ]);
    }
    /**
     * @Route("/affichercEB", name="categorie_emploi_index2", methods={"GET"})
     */
    public function index2(CategorieEmploiRepository $categorieEmploiRepository): Response
    {
        return $this->render('categorie_emploi/afficherCategorieEmploiFront.html.twig', [
            'categorie_emplois' => $categorieEmploiRepository->findAll(),
        ]);
    }
    /**
     * @Route("/afficherCFRONT", name="FrontEmploi", methods={"GET"})
     */
    public function indexFRONT(CategorieEmploiRepository $categorieEmploiRepository): Response
    {
        return $this->render('admin/afficherCategorieEmploiFront.html.twig', [
            'categorie_emplois' => $categorieEmploiRepository->findAll(),
        ]);
    }
    /**
     * @Route("/frontCategorieDetailEmploi/{id}", name="frontCEF")
     */
    public function categorieDetails(CategorieEmploiRepository $repository,PostulerEmploiRepository $repository1,UsersRepository$repository2,$id)
    {$blog = $repository->find($id);
    $testOffre=array();
        array_push($testOffre,0);

    $pp=null;
      $user=$this->getUser();
        $userConnecter=$repository2->findOneBy(array('username'=>$user->getUsername()));
     foreach ($blog->getOffre() as $e)
     {

             $pp=$repository1->findOneBySomeField($e->getId(),$userConnecter->getId());
             if($pp)
             {
                 array_push($testOffre,$e->getId());

             }




     }
    return $this->render('admin/FrontCategorieEmploiDetail.html.twig', [
            'categorie' => $blog,
            'testoffre'=>$testOffre,

             'pp'=>$pp
        ]);
    }

    /**
     * @Route("/newCEB", name="categorie_emploi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieEmploi = new CategorieEmploi();
        $form = $this->createForm(CategorieEmploiType::class, $categorieEmploi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $categorieEmploi->setNbrOffres(0);
            $entityManager->persist($categorieEmploi);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_emploi_index2');
        }

        return $this->render('categorie_emploi/index.html.twig', [
            'categorie_emploi' => $categorieEmploi,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route ("/SupprimerCEB/{id}",name="categorieEmploi_supprimer")
     */
    public function SupprimerBlog(CategorieEmploiRepository $repository , $id)
    {
        $blog = $repository->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute("categorie_emploi_index2");
    }
    /**
     * @Route ("/SupprimerPostulationEmploi/{id}/{id1}",name="PostulerEmploisupp")
     */
    public function SupprimerPostulationEmploi(OffreEmploiRepository$repository ,$id1, $id,UsersRepository $repository1,PostulerEmploiRepository $repository2)
    {
        $blog = $repository->find($id);
        $user=$this->getUser();
        $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
        $postul=$repository2->findOneBySomeField($id,$userConnecter->getId());
        $em = $this->getDoctrine()->getManager();
        $em->remove($postul);
        $em->flush();
        return $this->redirect('/frontCategorieDetailEmploi/'.$id1);
    }
    /**
     * @Route ("/ModifierCEB/{id}",name="categorieEmploi_modification")
     */
    public function ModifierBlog(CategorieEmploiRepository $repository , Request $request , $id){
        $blog=$repository->find($id);
        $form=$this->createForm(CategorieEmploiType::class,$blog);

        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute("categorie_emploi_index2");
        }
        return $this->render('categorie_emploi/modifierCategorieEmploi.html.twig', [

            'form' => $form->createView(),
        ]);
    }
}
