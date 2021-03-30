<?php

namespace App\Controller;

use App\Entity\CategorieEmploi;
use App\Entity\CategorieFormation;
use App\Entity\CategorieQuestionnaire;
use App\Entity\CategorieReclamation;
use App\Entity\CategoryFreelance;
use App\Repository\CategorieEmploiRepository;
use App\Repository\CategorieFormationRepository;
use App\Repository\CategorieQuestionnaireRepository;
use App\Repository\CategorieReclamationRepository;
use App\Repository\CategoryFreelanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SearshController extends AbstractController
{
    /**
     * @Route("/searsh", name="searsh")
     */
    public function index(): Response
    {
        return $this->render('searsh/index.html.twig', [
            'controller_name' => 'SearshController',
        ]);
    }
    /**
 * Lists searched entities.
 *
 * @Route("/rechercheCategorie", name="demandeEmploi")

 */
    public function searchuCategorieAction(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();


        $searchParameter = $request->get('id');
        if(strlen($searchParameter)==0)
            $entities = $em->getRepository(CategorieEmploi::class)->findAll();
        else

            //call repository function

            $entities = $repository->findByExampleField($searchParameter);



        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);

        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorierecl", name="demandeRec")

     */
    public function searchuCategorieActionRecl(Request $request,CategorieReclamationRepository $repository){
        $em = $this->getDoctrine()->getManager();


        $searchParameter = $request->get('id');
        if(strlen($searchParameter)==0)
            $entities = $em->getRepository(CategorieReclamation::class)->findAll();
        else

            //call repository function

            $entities = $repository->findByExampleField($searchParameter);



        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);

        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieDES", name="demandeEmploiDES")

     */
    public function orderCategorieAction(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
         $entities = $em->getRepository(CategorieEmploi::class)->findBy(array(), array('descriptionEmploi' => 'DESC'));
         $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

            ]);
        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieDESreclam", name="demandeRecDES")

     */
    public function orderCategorieActionrec(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieReclamation::class)->findBy(array(), array('description' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);
        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheQuestDES", name="demandeQuestDES")

     */
    public function orderQuestAction(Request $request,CategorieQuestionnaireRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieQuestionnaire::class)->findBy(array(), array('description_cat_qst' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieFormationDES", name="demandeFormationDES")

     */
    public function orderCategorieFAction(Request $request,CategorieFormationRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieFormation::class)->findBy(array(), array('description_cat_frt' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieFreelanceDES", name="demandeFreelanceDES")

     */
    public function orderCategorieFreelanceAction(Request $request,CategorieFormationRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategoryFreelance::class)->findBy(array(), array('description_cat_fr' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASC", name="demandeEmploiASC")

     */
    public function orderCategorieASCAction(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieEmploi::class)->findBy(array(), array('descriptionEmploi' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCrecl", name="demandeRecASC")

     */
    public function orderCategorieASCActionrecl(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieReclamation::class)->findBy(array(), array('description' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheQuestASC", name="demandeQuestASC")

     */
    public function orderQuestASCAction(Request $request,CategorieQuestionnaireRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieQuestionnaire::class)->findBy(array(), array('description_cat_qst' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCFormation", name="demandeFormationASC")

     */
    public function orderCategorieASCActionFormation(Request $request,CategorieFormationRepository$repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieFormation::class)->findBy(array(), array('description_cat_frt' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCFreelance", name="demandeFreelanceASC")

     */
    public function orderCategorieASCActionFreelance(Request $request,CategorieFormationRepository$repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategoryFreelance::class)->findBy(array(), array('description_cat_fr' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieDESNom", name="demandeEmploiDESNom")

     */
    public function orderCategorieActionNom(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieEmploi::class)->findBy(array(), array('nomEmploi' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieDESNomRec", name="demandeRecDESNom")

     */
    public function orderCategorieActionNomrec(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieReclamation::class)->findBy(array(), array('nom' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheQuestDESNom", name="demandeQuestDESNom")

     */
    public function orderQuestActionNom(Request $request,CategorieQuestionnaireRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieQuestionnaire::class)->findBy(array(), array('nom_cat_qst' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieDESNomFormation", name="demandeFormationDESNom")

     */
    public function orderCategorieActionNomF(Request $request,CategorieFormationRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieFormation::class)->findBy(array(), array('nom_cat_frt' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieDESNomFreelance", name="demandeFreelanceDESNom")

     */
    public function orderCategorieActionNomFreelance(Request $request,CategoryFreelanceRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategoryFreelance::class)->findBy(array(), array('nom_cat_fr' => 'DESC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCNom", name="demandeEmploiASCNom")

     */
    public function orderCategorieASCActionNom(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieEmploi::class)->findBy(array(), array('nomEmploi' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCNomRec", name="demandeRecASCNom")

     */
    public function orderCategorieASCActionNomRecl(Request $request,CategorieEmploiRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieReclamation::class)->findBy(array(), array('nom' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheQuestASCNom", name="demandeQuestASCNom")

     */
    public function orderQuestASCActionNom(Request $request,CategorieQuestionnaireRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieQuestionnaire::class)->findBy(array(), array('nom_cat_qst' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCNomFormation", name="demandeFormationASCNom")

     */
    public function orderCategorieASCActionNomFormation(Request $request,CategorieFormationRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategorieFormation::class)->findBy(array(), array('nom_cat_frt' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheCategorieASCNomFreelance", name="demandeFreelanceASCNom")

     */
    public function orderCategorieASCActionNomFreelance(Request $request,CategoryFreelanceRepository $repository){
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository(CategoryFreelance::class)->findBy(array(), array('nom_cat_fr' => 'ASC'));
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheFormation", name="demandeFormation")

     */
    public function searchFormationAction(Request $request,CategorieFormationRepository $repository){
        $em = $this->getDoctrine()->getManager();


        $searchParameter = $request->get('id');
        if(strlen($searchParameter)==0)
            $entities = $em->getRepository(CategorieFormation::class)->findAll();
        else

            //call repository function

            $entities = $repository->findByExampleField($searchParameter);



        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);

        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheQuest", name="demandeQuest")

     */
    public function searchQuestAction(Request $request,CategorieQuestionnaireRepository $repository){
        $em = $this->getDoctrine()->getManager();


        $searchParameter = $request->get('id');
        if(strlen($searchParameter)==0)
            $entities = $em->getRepository(CategorieQuestionnaire::class)->findAll();
        else

            //call repository function

            $entities = $repository->findByExampleField($searchParameter);



        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);

        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
    /**
     * Lists searched entities.
     *
     * @Route("/rechercheFreelance", name="demandeFreelance")
     */
    public function searchFreelnaceAction(Request $request,CategoryFreelanceRepository $repository){
        $em = $this->getDoctrine()->getManager();


        $searchParameter = $request->get('id');
        if(strlen($searchParameter)==0)
            $entities = $em->getRepository(CategoryFreelance::class)->findAll();
        else

            //call repository function

            $entities = $repository->findByExampleField($searchParameter);



        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($entities, 'json',['groups'=>'students',
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }

        ]);

        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;
    }
}
