<?php

namespace App\Controller;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twilio\Rest\Client;

use App\Entity\PostulerFreelance;
use App\Form\PostulerFreelanceType;
use App\Repository\OffreFreelanceRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostulerFreelanceController extends AbstractController
{
    /**
     * @Route("/postuler/freelance", name="postuler_freelance")
     */
    public function index(): Response
    {
        return $this->render('postuler_freelance/index.html.twig', [
            'controller_name' => 'PostulerFreelanceController',
        ]);
    }

    /**
     * @Route ("/PostulerFreelance/{id}/{id1}",name="PostulerFreelance")
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public function PostulerEmploi(OffreFreelanceRepository $repository,MailerInterface $mailer,UsersRepository $repository1 , Request $request ,$id1, $id){
        $offre=$repository->find($id);
        $postuler=new PostulerFreelance();
        $form=$this->createForm(PostulerFreelanceType::class,$postuler);

        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){
            $user = $this->getUser();
            $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
            $postuler->setDatePostulation(new \DateTime());
            $postuler->setOffreFreelance($offre);
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
            $account_sid = getenv('AC00e3a7d8c7b0f5dee209a9b66c89e97a');
            $auth_token = getenv('59bc9bba35bcb69d26fdee657a72b700');
// In production, these should be environment variables. E.g.:
// $auth_token = $_ENV["TWILIO_AUTH_TOKEN"]

// A Twilio number you own with SMS capabilities
            $twilio_number = "+18727041707";

            $client = new Client($account_sid, $auth_token);
            $client->messages->create(
            // Where to send a text message (your cell phone?)
                '+21652149585',
                array(
                    'from' => $twilio_number,
                    'body' => 'Freelance Postulation par:'.$userConnecter->getUsername()
                )
            );
            $pdfFilepath=$this->getParameter('pdf_directory').'/'.$filename;
            $email = (new Email())
                ->from('zayneb.kadhi@esprit.tn')
                ->to('zayneb.kadhi@esprit.tn')
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Postulation Freelance:'.$offre->getTitreOffreFr())
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
            return $this->redirect('/category/freelance/frontCategorieDetail/'.$id1);
        }
        return $this->render('admin/postulerOffreFreelance.html.twig', [

            'form' => $form->createView(),
        ]);
    }
}
