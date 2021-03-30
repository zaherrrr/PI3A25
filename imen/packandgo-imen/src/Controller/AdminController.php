<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\LoginType;
use App\Form\UserModifType;
use App\Form\UtildashType;
use App\Form\UsersType;

use App\Repository\UsersRepository;
use Doctrine\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request ;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class AdminController extends AbstractController
{

    /**
     * @Route("/", name="global")
     */
    public function index(): Response
    {

        return $this->render('admin/home.html.twig') ;

    }

    /**
     * @Route("/user/{id}", name="globaluser")
     */
    public function indexuser(UsersRepository $repository, $id): Response
    {
        $utilisateur = $repository->find($id) ;
        return $this->render('admin/home.html.twig',[
            "utilisateur"=>$id
        ]) ;
    }

    /**
     * @Route("/utilisateur/creation", name="utilisateur_creation")
     * @Route("/utilisateur/{id}", name="utilisateur_modification",methods="GET|POST")
     */
    public function ajouETmodif(Users $utilisateur = null, Request $request , ManagerRegistry $objectManager , UserPasswordEncoderInterface $encoder): Response
    {
        if(!$utilisateur)
        {
            $utilisateur = new Users() ;
        }

        $form = $this->createForm(UsersType::class,$utilisateur) ; //bech twarik les champ l moujoudin
        $form->handleRequest($request) ;  //recuperer les valeur
        if($form->isSubmitted() && $form->isValid()){ //verifier le formulaire
            $passwordCrypte = $encoder->encodePassword($utilisateur,$utilisateur->getPassword()) ;
            $utilisateur->setPassword($passwordCrypte) ;

            $modif =  $utilisateur->getId() !== null ;
            $em = $objectManager->getManager();
            $em->persist($utilisateur); //prepaer (tekhou les valeur)
            $em->flush(); //aaporter les modification f base
            $this->addFlash("success",($modif) ? "La modification a ete effectuee":"l'ajout a ete effectuee") ;
            return $this->redirectToRoute("global") ;
        }



        return $this->render('admin/formulaire.html.twig',[
            "utilisateur" => $utilisateur,
            "form"=>$form->createView(),
            "isModification" => $utilisateur->getId() !== null // si element mouch moujoud trajaa false
        ]);
    }


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $util, UsersRepository $repository)

    { $user=$repository->findBy(array('username'=>$util->getLastUsername()));

        if($this->isGranted('ROLE_ADMIN'))
        return $this->render('backend/utilisateur.html.twig',[
            "lastUserName"=>$util->getLastUsername(),
            "error"=>$util->getLastAuthenticationError()
        ]);
        else
            return $this->render('admin/index.html.twig',[
                "lastUserName"=>$util->getLastUsername(),
                "error"=>$util->getLastAuthenticationError()
            ]);


    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
    }
    /**
     * @Route("/demandeUSER", name="demandeUser")
     */
    public function demandeUser(UsersRepository $repository,Request $request)
    {
        $searchParameter = $request->get('id');
        $user=$repository->findOneBy(array('username'=>$searchParameter));


        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        if(is_null($user))
        $jsonContent = $serializer->serialize(true, 'json',['groups'=>'students']);
        else
            $jsonContent = $serializer->serialize(false, 'json',['groups'=>'students']);
        $response = new Response(json_encode($jsonContent));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;

    }


    /**
     * @Route("/admin", name="util")
     */
    public function affichage(UsersRepository $repository,Request $request, PaginatorInterface $paginator): Response
    {

        $utilisateur= $repository->findAll() ;
        $articles = $paginator->paginate(
            $utilisateur, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2// Nombre de résultats par page
        );
        return $this->render('backend/utilisateur.html.twig', [
            'util' => $articles,

        ]);
    }

    /**
     * @Route("/admin/util/creation", name="admin_creation")

     */
    public function ajoutetmodifdash(Request $request , ManagerRegistry $objectManager , UserPasswordEncoderInterface $encoder): Response
    {

            $utilisateur = new Users() ;
            $form = $this->createForm(UtildashType::class,$utilisateur) ;



         //bech twarik les champ l moujoudin
        $form->handleRequest($request) ;  //recuperer les valeur
        if($form->isSubmitted() && $form->isValid()){ //verifier le formulaire
            $passwordCrypte = $encoder->encodePassword($utilisateur,$utilisateur->getPassword()) ;
            $utilisateur->setPassword($passwordCrypte) ;
            $modif =  $utilisateur->getId() !== null ;
            $em = $objectManager->getManager();
            $em->persist($utilisateur); //prepaer (tekhou les valeur)
            $em->flush(); //aaporter les modification f base

            return $this->redirectToRoute("util") ;
        }



        return $this->render('backend/ajoutUser.html.twig',[
            "utilisateur" => $utilisateur,
            "form"=>$form->createView(),
            "isModification" => $utilisateur->getId() !== null // si element mouch moujoud trajaa false
        ]);
    }
    /**

     * @Route("/admin/util/{id}", name="admin_modification",methods="GET|POST")
     */
    public function modifdash(Users $utilisateur = null, Request $request , ManagerRegistry $objectManager , UserPasswordEncoderInterface $encoder): Response
    {

            $form = $this->createForm(UserModifType::class,$utilisateur) ;
            $form->remove('verifpassword')->remove('password');
           if(in_array("ROLE_ADMIN", $utilisateur->getRoles()))
               $form->remove('Roles');
        //bech twarik les champ l moujoudin
        $form->handleRequest($request) ;  //recuperer les valeur
        if($form->isSubmitted() && $form->isValid()){ //verifier le formulaire

            $modif =  $utilisateur->getId() !== null ;
            $em = $objectManager->getManager();
            $em->persist($utilisateur); //prepaer (tekhou les valeur)
            $em->flush(); //aaporter les modification f base
            $this->addFlash("success",($modif) ? "La modification a ete effectuee":"l'ajout a ete effectuee") ;
            return $this->redirectToRoute("util") ;
        }



        return $this->render('backend/modification.html.twig',[
            "utilisateur" => $utilisateur,
            "form"=>$form->createView(),
            "isModification" => $utilisateur->getId() !== null // si element mouch moujoud trajaa false
        ]);
    }

    /**

     * @Route("/admin/util/pwd/{id}", name="admin_modification_pwd",methods="GET|POST")
     */
    public function modifpwd(Users $utilisateur = null, Request $request , ManagerRegistry $objectManager ,UsersRepository $repository, UserPasswordEncoderInterface $encoder): Response
    {

        $form = $this->createForm(UserModifType::class,$utilisateur) ;
        $form->remove('nom')->remove('prenom')->remove('email')->remove('imageFile')->remove('username')
            ->remove('Roles');


        //bech twarik les champ l moujoudin
        $form->handleRequest($request) ;  //recuperer les valeur
        if($form->isSubmitted() && $form->isValid()){ //verifier le formulaire
            $passwordCrypte = $encoder->encodePassword($utilisateur,$utilisateur->getPassword()) ;
            $utilisateur->setPassword($passwordCrypte) ;

            $modif =  $utilisateur->getId() !== null ;
            $em = $objectManager->getManager();
            $em->persist($utilisateur); //prepaer (tekhou les valeur)
            $em->flush(); //aaporter les modification f base
            $this->addFlash("success",($modif) ? "La modification a ete effectuee":"l'ajout a ete effectuee") ;

            return $this->redirectToRoute("util") ;

        }



        return $this->render('backend/modification_pwd.html.twig',[
            "utilisateur" => $utilisateur,
            "form"=>$form->createView(),
            "isModification" => $utilisateur->getId() !== null // si element mouch moujoud trajaa false
        ]);
    }

    /**
     * @Route("/admin/util/{id}", name="admin_suppression",methods="delete")
     */
    public function suppression(Users $utilisateur, Request $request , ManagerRegistry $objectManager ): Response
    {
        if($this->isCsrfTokenValid("SUP". $utilisateur->getId(),$request->get('_token'))){
            $em = $objectManager->getManager();
            $em->remove($utilisateur);
            $em->flush();
            $this->addFlash("success","La suppression a ete effectuee") ;
            return $this->redirectToRoute("util") ;
        }

    }

    /**
     * @Route("/profil", name="profil")
     */
    public function affichageprofil(): Response
    {

        return $this->render('admin/profil.html.twig');
    }

}
