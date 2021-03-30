<?php

namespace App\Controller;

use App\Entity\CategorieQuestionnaire;
use App\Form\CategorieQuestionnaire1Type;
use App\Repository\CategorieQuestionnaireRepository;
use App\Repository\QuestionnaireRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/questionnaire")
 */
class CategorieQuestionnaireController extends AbstractController
{
    /**
     * @Route("/", name="categorie_questionnaire_index", methods={"GET"})
     */
    public function index(CategorieQuestionnaireRepository $categorieQuestionnaireRepository): Response
    {
        return $this->render('backend/categoriequestionnaire.html.twig', [
            'categorie_questionnaires' => $categorieQuestionnaireRepository->findAll(),
        ]);
    }
    /**
     * @Route("/front", name="categorie_questionnaire_indexfront", methods={"GET"})
     */
    public function indexx(CategorieQuestionnaireRepository $categorieQuestionnaireRepository,Request $request,PaginatorInterface $paginator): Response
    {

        $utilisateur= $categorieQuestionnaireRepository->findAll() ;
        $articles = $paginator->paginate(
            $utilisateur, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );
        return $this->render('admin/CategorieQuestionnaire.html.twig', [
            'categorie_questionnaires' => $articles,
        ]);
    }
    /**
     * @Route("/admin", name="categorie_questionnaire_index2", methods={"GET"})
     */
    public function index2(CategorieQuestionnaireRepository $categorieQuestionnaireRepository): Response
    {
        return $this->render('categorie_questionnaire/index2.html.twig', [
            'categorie_questionnaires' => $categorieQuestionnaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_questionnaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieQuestionnaire = new CategorieQuestionnaire();
        $form = $this->createForm(CategorieQuestionnaire1Type::class, $categorieQuestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorieQuestionnaire->setNbrQst(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieQuestionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_questionnaire_index');
        }

        return $this->render('backend/ajouterCategorieQuestionnaaire.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/new", name="categorie_questionnaire_new2", methods={"GET","POST"})
     */
    public function new2(Request $request): Response
    {
        $categorieQuestionnaire = new CategorieQuestionnaire();
        $form = $this->createForm(CategorieQuestionnaire1Type::class, $categorieQuestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieQuestionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_questionnaire_index2');
        }

        return $this->render('categorie_questionnaire/new2.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_questionnaire_show", methods={"GET"})
     */
    public function show(CategorieQuestionnaire $categorieQuestionnaire): Response
    {
        return $this->render('categorie_questionnaire/show.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_questionnaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieQuestionnaire $categorieQuestionnaire): Response
    {
        $form = $this->createForm(CategorieQuestionnaire1Type::class, $categorieQuestionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_questionnaire_index');
        }

        return $this->render('backend/modifierCategorieQuestionnaire.html.twig', [
            'categorie_questionnaire' => $categorieQuestionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteques/{id}", name="categorie_questionnaire_delete")
     */
    public function delete(Request $request, $id,CategorieQuestionnaireRepository $repository)
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();


        return $this->redirectToRoute('categorie_questionnaire_index');
    }
    /**
     * @Route("/frontCategorieDetail/{id}", name="frontCDquestionnaire")
     */
    public function Details(CategorieQuestionnaireRepository $repository ,$id,Request $request)
    {$blog = $repository->find($id);


        return $this->render('admin/CategorieQuestionnaireDetail.html.twig', [
            'categorie' => $blog,



        ]);



    }
}
