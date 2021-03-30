<?php

namespace App\Controller;

use App\Entity\PostulerEmploi;
use App\Form\PostulerEmploiType;
use App\Repository\OffreEmploiRepository;
use App\Repository\PostulerEmploiRepository;
use App\Repository\UsersRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class PostulerEmploiController extends AbstractController
{
    /**
     * @Route("/postuler/emploi", name="postuler_emploi")
     */
    public function index(): Response
    {
        return $this->render('postuler_emploi/index.html.twig', [
            'controller_name' => 'PostulerEmploiController',
        ]);
    }
    /**
     * @Route ("/PostulerEmploi/{id}/{id1}",name="PostulerEmploi")
     */
    public function PostulerEmploi(OffreEmploiRepository $repository,UsersRepository $repository1 ,MailerInterface $mailer, Request $request ,$id1, $id){
        $offre=$repository->find($id);
        $postuler=new PostulerEmploi();
        $form=$this->createForm(PostulerEmploiType::class,$postuler);

        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $user = $this->getUser();
            $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
            $postuler->setDatePostulation(new \DateTime());
            $postuler->setOffreEmploi($offre);
            $postuler->setUser($userConnecter);
            $file = $form->get('pdfcv')->getData();

            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $postuler->setPdfcv($filename);
            try {
                $file->move(
                    $this->getParameter('pdf_directory'),
                    $filename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $pdfFilepath=$this->getParameter('pdf_directory').'/'.$filename;
            $email = (new Email())
                ->from('zayneb.kadhi@esprit.tn')
                ->to('zayneb.kadhi@esprit.tn')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Postulation Emploi:'.$offre->getDescriptionCatEm())
                ->text('Sending emails is fun again!')
                ->html('<h1>Postulation </h1><br>par:'.$userConnecter->getUsername().'<br> email:'.$userConnecter->getEmail())
                ->attachFromPath($pdfFilepath);

            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e) {
            }

            $em=$this->getDoctrine()->getManager();
            $em->persist($postuler);
            $em->flush();
            return $this->redirect('/frontCategorieDetailEmploi/'.$id1);
        }
        return $this->render('admin/postulerOffreEmploi.html.twig', [

            'form' => $form->createView(),
        ]);
    }
}
