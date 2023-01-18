<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{
    #[Route('/patient', name: 'app_patient')]
    public function index(): Response
    {
        return $this->render('patient/index.html.twig', [
            'controller_name' => 'PatientController',
        ]);
    }

    #[Route('/patient/patients', name: 'list_patients')]
    public function listPatients(ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $patients = $em->getRepository("App\Entity\Patient")->findAll();

        return $this->render('patient/listPatient.html.twig', [
            "patientList"=>$patients
        ]);
    }

    #[Route('symfony', name: 'add-patients')]
    public function addPatient(ManagerRegistry $doctrine,Request $request): Response
    {
        $patient = new Patient();
        $form = $this->createForm(PatientForm::class, $patient);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $em= $doctrine->getManager();
            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('list_patients');
        }

        return $this->render('patient/addPatient.html.twig', [
        'formPatient'=>$form->createView()
        ]);
    }


    #[Route('/patient/deletePatient/{id}', name: 'delete-patient')]
    public function deletePatient($id,ManagerRegistry $doctrine,): Response
    {
        $em= $doctrine->getManager();
        $patient = $em->getRepository("App\Entity\Patient")->find($id);

        if($patient!== null){

            $em->remove($patient);
            $em->flush();

        }else{
            throw new NotFoundHttpException("La patient d'id ".$id."n'existe pas");
        }

        return $this->redirectToRoute('list_patients');
    }

    #[Route('/patient/updatePatient/{id}', name: 'update-patient')]
    public function updatePatient(ManagerRegistry $doctrine,Request $request, $id): Response
    {

        $em= $doctrine->getManager();
        $patient = $em->getRepository("App\Entity\Patient")->find($id);

        $editform = $this->createForm(PatientForm::class, $patient);

        $editform->handleRequest($request);

        if($editform->isSubmitted() and $editform->isValid()){

            $em->persist($patient);
            $em->flush();

            return $this->redirectToRoute('list_patients');
        }

        return $this->render('patient/updatePatient.html.twig', [
            'editFormPatient'=>$editform->createView(),
            'patient'=>$patient
        ]);
    }
}
