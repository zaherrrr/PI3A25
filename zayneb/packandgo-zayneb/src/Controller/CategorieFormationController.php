<?php

namespace App\Controller;

use App\Entity\CategorieFormation;
use App\Entity\ParticerFormation;
use App\Entity\Users;
use App\Form\CategorieFormationType;
use App\Repository\CategorieFormationRepository;
use App\Repository\FormationRepository;
use App\Repository\ParticerFormationRepository;
use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
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
        return $this->render('backend/categorieformation.html.twig', [
            'categorie_formations' => $categorieFormationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/front", name="categorie_formation_indexfront", methods={"GET"})
     */
    public function indexfront(CategorieFormationRepository $categorieFormationRepository,Request $request,PaginatorInterface $paginator): Response
    { $utilisateur= $categorieFormationRepository->findAll() ;
        $articles = $paginator->paginate(
            $utilisateur, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );
        return $this->render('admin/CategorieFormation.html.twig', [
            'categorie_formations' => $articles,
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
            $categorieFormation->setNbrCatFrt(0);
            $entityManager->persist($categorieFormation);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_formation_index');
        }

        return $this->render('backend/ajouterCategorieFormation.html.twig', [
            'categorie_formation' => $categorieFormation,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin", name="categorie_formation_index2", methods={"GET"})
     */
    public function index2(CategorieFormationRepository $categorieFormationRepository): Response
    {
        return $this->render('categorie_formation/index2.html.twig', [
            'categorie_formations' => $categorieFormationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/new", name="categorie_formation_new2", methods={"GET","POST"})
     */
    public function new2(Request $request): Response
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

        return $this->render('categorie_formation/new2.html.twig', [
            'categorie_formation' => $categorieFormation,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="categorie_formation_show", methods={"GET"})
     */
    public function show(CategorieFormation $categorieFormation): Response
    {
        return $this->render('categorie_formation/categorieformation.html.twig', [
            'categorie_formation' => $categorieFormation,
        ]);
    }

    /**
     * @Route("/categorie/formation/{id}/edit", name="categorie_formation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieFormation $categorieFormation): Response
    {
        $form = $this->createForm(CategorieFormationType::class, $categorieFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_formation_index');
        }

        return $this->render('backend/modifierCategorieFormation.html.twig', [
            'categorie_formation' => $categorieFormation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/categorie/formation/{id}", name="categorie_formation_delete")
     */
    public function delete(Request $request,$id,CategorieFormationRepository $repository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();

        return $this->redirectToRoute('categorie_formation_index');
    }
    /**
     * @Route("/frontCategorieDetail/{id}", name="frontCD")
     */
    public function Details(CategorieFormationRepository $repository,UsersRepository $repository1,ParticerFormationRepository $repository2 ,$id,Request $request)
    {$blog = $repository->find($id);
        $testOffre=array();
        array_push($testOffre,0);
        $pp=null;
        $user=$this->getUser();
        if($user==null)
        {
            $userConnecter=new Users();

        }
        else{
            $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
        }

        foreach ($blog->getFormation() as $e)
        {

            $pp=$repository2->findOneBySomeField($e->getId(),$userConnecter->getId());
            if($pp)
            {
                array_push($testOffre,$e->getId());

            }

        }



        return $this->render('admin/CategorieFormationDetail.html.twig', [
            'categorie' => $blog,
            'testoffre'=>$testOffre,



        ]);



    }
    /**
     * @Route ("/ParticiperFormation/{id}/{id1}",name="ParticiperFormation")
     */
    public function ParticiperFormation(FormationRepository $repository,UsersRepository $repository1 , Request $request ,$id1, $id){
        $formation=$repository->find($id);
        $participer=new ParticerFormation();

            $user = $this->getUser();
            $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
            $participer->setDate(new \DateTime());
            $participer->setFormation($formation);
            $participer->setUser($userConnecter);
            $em=$this->getDoctrine()->getManager();
            $em->persist($participer);
            $em->flush();
            return $this->redirect('/categorie/formation/frontCategorieDetail/'.$id1);


    }
    /**
     * @Route ("/Supprimerparticipation/{id}/{id1}",name="Participationsupp")
     */
    public function SupprimerPparticipation( $id1, $id,UsersRepository $repository1,ParticerFormationRepository $repository2)
    {

        $user=$this->getUser();
        $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
        $postul=$repository2->findOneBySomeField($id,$userConnecter->getId());
        $em = $this->getDoctrine()->getManager();
        $em->remove($postul);
        $em->flush();
        return $this->redirect('/categorie/formation/frontCategorieDetail/'.$id1);
    }
}
