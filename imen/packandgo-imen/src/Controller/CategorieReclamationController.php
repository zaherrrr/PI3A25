<?php

namespace App\Controller;

use App\Entity\CategorieReclamation;
use App\Entity\Reclamation;
use App\Form\CategorieReclamationType;
use App\Form\ReclamationType;
use App\Repository\CategorieReclamationRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/reclamation")
 */
class CategorieReclamationController extends AbstractController
{
    /**
     * @Route("/afficherCRec", name="categorie_reclamation_index", methods={"GET"})
     */
    public function index(CategorieReclamationRepository $categorieReclamationRepository): Response
    {

        return $this->render('categorie_reclamation/index.html.twig', [
            'categorie_reclamations' => $categorieReclamationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/afficherRecTT", name="categorie_reclamation_index3", methods={"GET"})
     */
    public function index3(ReclamationRepository $categorieReclamationRepository): Response
    {
        return $this->render('backend/AfficherReclamation.html.twig', [
            'reclamations' => $categorieReclamationRepository->findAll(),
        ]);
    }
    /**
     * @Route("/afficherCRec12", name="categorie_reclamation_index2")
     */
    public function index2(CategorieReclamationRepository $categorieReclamationRepository,Request $request,PaginatorInterface $paginator): Response
    {$utilisateur= $categorieReclamationRepository->findAll() ;
        $articles = $paginator->paginate(
            $utilisateur, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );
        return $this->render('admin/CategorieReclamation.html.twig', [
            'categorie_reclamations' =>  $articles,
        ]);
    }

    /**
     * @Route("/new", name="categorie_reclamation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieReclamation = new CategorieReclamation();
        $form = $this->createForm(CategorieReclamationType::class, $categorieReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieReclamation);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_reclamation_index');
        }

        return $this->render('categorie_reclamation/ajouterCatreclamation.html.twig', [
            'categorie_reclamation' => $categorieReclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_reclamation_show", methods={"GET"})
     */
    public function show(CategorieReclamation $categorieReclamation): Response
    {
        return $this->render('categorie_reclamation/show.html.twig', [
            'categorie_reclamation' => $categorieReclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_reclamation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieReclamation $categorieReclamation): Response
    {
        $form = $this->createForm(CategorieReclamationType::class, $categorieReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_reclamation_index');
        }

        return $this->render('categorie_reclamation/edit.html.twig', [
            'categorie_reclamation' => $categorieReclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="categorie_reclamation_delete")
     */
    public function delete(Request $request, CategorieReclamationRepository $categorieReclamation,$id): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieReclamation->find($id));
            $entityManager->flush();


        return $this->redirectToRoute('categorie_reclamation_index');
    }
    /**
     * @Route("/frontCategorieDetailReclamation/{id}", name="frontCDreclamation")
     */
    public function Details(CategorieReclamationRepository $repository,UsersRepository$repository1 ,$id,Request $request)
    {$blog = $repository->find($id);
        $reclamation= new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reclamation->setCategorie($blog);
            $user = $this->getUser();
            $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
            $reclamation->setUser($userConnecter);
            $reclamation->setDate(new \DateTime());
            $reclamation->setTraitement(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_reclamation_index2');
        }


        return $this->render('admin/CategorieReclamationDetail.html.twig', [
            'categorie' => $blog,
            'form'=>$form->createView()



        ]);



    }
    /**
     * @Route("/frontCategorieDetailReclamationList/{id}", name="frontCDreclamationList")
     */
    public function Details1(CategorieReclamationRepository $repository,UsersRepository$repository1 ,$id,Request $request)
    {$blog = $repository->find($id);




        return $this->render('admin/CategorieReclamationDetailList.html.twig', [
            'categorie' => $blog,




        ]);



    }
    /**
     * @Route("/frontCategorieDetailReclamationListsupp/{id}/{id1}", name="reclamation_delete")
     */
    public function supprimerReclamation(ReclamationRepository $repository,UsersRepository$repository1 ,$id,$id1)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();
        return $this->redirect('/categorie/reclamation/frontCategorieDetailReclamationList/'.$id1);
    }

    /**
     * @Route("/frontCategorieDetailReclamationListsupp1/{id}", name="reclamation_delete1")
     */
    public function supprimerReclamation1(ReclamationRepository $repository,UsersRepository$repository1 ,$id)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();
        return $this->redirect('/profil');
    }
    /**
     * @Route("/traiterrREC/{id}", name="reclamation_traiter")
     */
    public function traiter(ReclamationRepository $repository,MailerInterface $mailer,UsersRepository$repository1 ,$id)
    {
        $reclamation=$repository->find($id);
        $reclamation->setTraitement(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($reclamation);
        $entityManager->flush();
        $email = (new Email())
            ->from('zayneb.kadhi@esprit.tn')
            ->to('zayneb.kadhi@esprit.tn')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Reclamation titre:'.$reclamation->getTitre())
            ->text('Sending emails is fun again!')
            ->html('<h1>Reclamation </h1><br>par:'.$reclamation->getUser()->getUsername().'<br> description:'.$reclamation->getText());


        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
        }
        return $this->redirectToRoute('categorie_reclamation_index3');
    }
    /**
     * @Route("/frontCategorieDetailReclamationListedit/{id}/{id1}", name="reclamation_edit")
     */
    public function editReclamation(ReclamationRepository $repository,UsersRepository$repository1 ,$id,$id1,Request $request)
    {

        $reclamation=$repository->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirect('/categorie/reclamation/frontCategorieDetailReclamationList/'.$id1);
        }


        return $this->render('admin/CategorieReclamationDetailModif.html.twig', [

            'form'=>$form->createView()



        ]);


    }
    /**
     * @Route("/frontCategorieDetailReclamationListedit1/{id}", name="reclamation_edit1")
     */
    public function editReclamation1(ReclamationRepository $repository,UsersRepository$repository1 ,$id,Request $request)
    {

        $reclamation=$repository->find($id);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirect('/profil');
        }


        return $this->render('admin/CategorieReclamationDetailModif.html.twig', [

            'form'=>$form->createView()



        ]);


    }

}
