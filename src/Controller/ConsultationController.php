<?php

namespace App\Controller;

use App\Entity\Consultation;
use App\Form\ConsultationForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationController extends AbstractController
{
    #[Route('/consultation', name: 'app_consultation')]
    public function index(): Response
    {
        return $this->render('consultation/index.html.twig', [
            'controller_name' => 'ConsultationController',
        ]);
    }

    #[Route('/consultation/consultation/{id}', name: 'view_consultation')]
    public function viewConsultation(ManagerRegistry $doctrine, $id): Response
    {
        $em= $doctrine->getManager();
        $consultation = $em->getRepository("App\Entity\Consultation")->find($id);
        $ordonance = $em->getRepository("App\Entity\Ordonnance")->findBy(['consultation' => $consultation->getId()]);

        return $this->render('consultation/viewConsultation.html.twig', [
            "consultation"=>$consultation,
            "ordonnance"=>$ordonance
        ]);
    }

    #[Route('/consultation/consultations', name: 'list_consultations')]
    public function listConsultations(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $consultations = $em->getRepository("App\Entity\Consultation")->findAll();

        return $this->render('consultation/listConsultation.html.twig', [
            "consultationList"=>$consultations
        ]);
    }

    #[Route('/consultation/addConsultation', name: 'add-consultations')]
    public function addConsultation(ManagerRegistry $doctrine,Request $request): Response
    {
        $consultation = new Consultation();
        $form = $this->createForm(ConsultationForm::class, $consultation);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $em= $doctrine->getManager();
            $em->persist($consultation);
            $em->flush();

            return $this->redirectToRoute('list_consultations');
        }

        return $this->render('consultation/addConsultation.html.twig', [
            'formConsultation'=>$form->createView()
        ]);
    }


    #[Route('/consultation/deleteConsultation/{id}', name: 'delete-consultation')]
    public function deleteConsultation($id,ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $consultation = $em->getRepository("App\Entity\Consultation")->find($id);

        if($consultation!== null){

            $em->remove($consultation);
            $em->flush();

        }else{
            throw new NotFoundHttpException("La consultation d'id ".$id."n'existe pas");
        }

        return $this->redirectToRoute('list_consultations');
    }

    #[Route('/consultation/updateConsultation/{id}', name: 'update-consultation')]
    public function updateConsultation(ManagerRegistry $doctrine,Request $request, $id): Response
    {

        $em= $doctrine->getManager();
        $consultation = $em->getRepository("App\Entity\Consultation")->find($id);

        $editform = $this->createForm(ConsultationForm::class, $consultation);

        $editform->handleRequest($request);

        if($editform->isSubmitted() and $editform->isValid()){

            $em->persist($consultation);
            $em->flush();

            return $this->redirectToRoute('list_consultations');
        }

        return $this->render('consultation/updateConsultation.html.twig', [
            'editFormConsultation'=>$editform->createView(),
            'consultation'=>$consultation
        ]);
    }
}
