<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Entity\Users;
use App\Form\Questionnaire1Type;
use App\Form\ReponseType;
use App\Repository\QuestionnaireRepository;
use App\Repository\UsersRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\Histogram;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/questionnaire")
 */
class QuestionnaireController extends AbstractController
{   /**
 * @Route("/stat", name="questionnaire_stat")
 */
    public function StatAction()
    {
        $pieChart = new PieChart();

        $em= $this->getDoctrine();
        $classes = $em->getRepository(Questionnaire::class)->findAll();

        $total=10;
        foreach($classes as $ques) {
            $total=$total+$ques->getNbrQst();
        }

        $data= array();
        $stat=['classe', 'nbquest'];
        $nb=0;
        array_push($data,$stat);
        foreach($classes as $ques) {

            $stat=array();
            array_push($stat,$ques->getCategorieQuestionnaire(),(($ques->getNbrQst()) *100)/$total);
            $nb=($ques->getNbrQst() *100)/$total;
            $stat=[$ques->getCategorieQuestionnaire(),$nb];
            array_push($data,$stat);

        }

        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des quantite  par categorie ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);



        return $this->render('questionnaire/stat.html.twig', array('piechart' => $pieChart));
    }
    /**
     * @Route("/", name="questionnaire_index", methods={"GET"})
     */
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->render('backend/questionnaire.html.twig', [
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin", name="questionnaire_index2", methods={"GET"})
     */
    public function index2(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->render('questionnaire/index2.html.twig', [
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="questionnaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $questionnaire = new Questionnaire();
        $form = $this->createForm(Questionnaire1Type::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaire->setNbrQst(0);
            $questionnaire->setNomCatQst('');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($questionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('questionnaire_index');
        }

        return $this->render('backend/ajouterQuestionnaire.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/new/admin", name="questionnaire_new2", methods={"GET","POST"})
     */
    public function new2(Request $request): Response
    {
        $questionnaire = new Questionnaire();
        $form = $this->createForm(Questionnaire1Type::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($questionnaire);
            $entityManager->flush();

            return $this->redirectToRoute('questionnaire_index');
        }

        return $this->render('questionnaire/new2.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="questionnaire_show", methods={"GET"})
     */
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('questionnaire/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="questionnaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Questionnaire $questionnaire): Response
    {
        $form = $this->createForm(Questionnaire1Type::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('questionnaire_index');
        }

        return $this->render('backend/modifierQuestionnaire.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/reponseQuestionnaire/{id}/{id1}", name="reponseQuest")
     */
    public function ForumDetails(QuestionnaireRepository $repository,$id,$id1,Request $request,UsersRepository $repository1,QuestionnaireRepository $repository2)
    {$questionnaire = $repository->find($id);
        $reponse=new Reponse();
        $form=$this->createForm(ReponseType::class,$reponse);
        $user = $this->getUser();
        if($user==null)
        {
            $userConnecter=new Users();

        }
        else{
            $userConnecter=$repository1->findOneBy(array('username'=>$user->getUsername()));
        }

        $data="".PHP_EOL;
        foreach ($questionnaire->getReponses() as $a ) {
            $data = $data . $a->getText() .PHP_EOL;
        }

        $result = Builder::create()
            ->writer(new PngWriter())
            ->writerOptions([])
            ->data('comments: '.$data)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(300)
            ->margin(10)
            ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->labelText('Scanner le ticket')
            ->labelFont(new NotoSans(20))
            ->labelAlignment(new LabelAlignmentCenter())
            ->build();
        header('Content-Type: '.$result->getMimeType());

        $result->saveToFile($this->getParameter('images_directory').'/'.$id.'.png');

            $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

            $reponse->setDate(new \DateTime());
            $reponse->setUser($userConnecter);
            $reponse->setQuestionnaire($questionnaire);
            $em=$this->getDoctrine()->getManager();

            $em->persist($reponse);
            $em->flush();
            return $this->redirect('/questionnaire/reponseQuestionnaire/'.$id.'/'.$id1);
        }


        return $this->render('admin/questionnaireReponse.html.twig', [
            'questionnaire' => $questionnaire,
            'form'=>$form->createView(),

        ]);
    }
    /**
     * @Route("/questionnaire/{id}", name="questionnaire_delete")
     */
    public function delete(Request $request,$id,QuestionnaireRepository $repository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($repository->find($id));
        $entityManager->flush();

        return $this->redirectToRoute('questionnaire_index');
    }
//    /**
//     * @Route("/stat", name="questionnaire_stat")
//     * @return Response
//     */


}
