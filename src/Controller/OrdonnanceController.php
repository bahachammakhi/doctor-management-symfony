<?php

namespace App\Controller;

use App\Entity\Ordonnance;
use App\Form\OrdonnanceForm;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;


class OrdonnanceController extends AbstractController
{
    #[Route('/ordonnance', name: 'app_ordonnance')]
    public function index(): Response
    {
        return $this->render('ordonnance/index.html.twig', [
            'controller_name' => 'OrdonnanceController',
        ]);
    }


    #[Route('/ordonnance/ordonnances', name: 'list_ordonnance')]
    public function listOrdonnance(ManagerRegistry $doctrine ): Response
    {
         $em= $doctrine->getManager();
        $ordonnance = $em->getRepository("App\Entity\Ordonnance")->findAll();

        //$em= $doctrine->getManager();
        //$consultations = $em->getRepository("App\Entity\Consultation")->findAll();

        return $this->render('ordonnance\listOrdonnance.html.twig', [
            "ordonnanceList"=>$ordonnance
        ]);
    }

    #[Route('/ordonnance/addOrdonnance', name: 'add-ordonnance')]
    public function addOrdonnance(ManagerRegistry $doctrine,Request $request): Response
    {
        $ordonnace = new Ordonnance();
        $form = $this->createForm(OrdonnanceForm::class, $ordonnace);

        $form->handleRequest($request);

        if($form->isSubmitted() and $form->isValid()){
            $em= $doctrine->getManager();
            $em->persist($ordonnace);
            $em->flush();

            return $this->redirectToRoute('list_ordonnance');
        }

        return $this->render('ordonnance/addOrdonnance.html.twig', [
            'formOrdonnance'=>$form->createView()
        ]);
    }

    #[Route('/ordonnance/deleteOrdonnance/{id}', name: 'delete-ordonnance')]
    public function deleteOrdonnance($id,ManagerRegistry $doctrine,): Response
    {
        $em= $doctrine->getManager();
        $ordonnance = $em->getRepository("App\Entity\Ordonnance")->find($id);

        if($ordonnance!== null){

            $em->remove($ordonnance);
            $em->flush();

        }else{
            throw new NotFoundHttpException("L'ordonnance' d'id ".$id."n'existe pas");
        }

        return $this->redirectToRoute('list_ordonnance');
    }

    #[Route('/ordonnance/updateOrdonnance/{id}', name: 'update-ordonnance')]
    public function updateOrdonnance(ManagerRegistry $doctrine,Request $request, $id): Response
    {

        $em= $doctrine->getManager();
        $ordonnance = $em->getRepository("App\Entity\Ordonnance")->find($id);

        $editform = $this->createForm(OrdonnanceForm::class, $ordonnance);

        $editform->handleRequest($request);

        if($editform->isSubmitted() and $editform->isValid()){

            $em->persist($ordonnance);
            $em->flush();

            return $this->redirectToRoute('list_ordonnance');
        }

        return $this->render('ordonnance/updateOrdonnance.html.twig', [
            'editFormOrdonnance'=>$editform->createView(),
            'ordonnance'=>$ordonnance
        ]);
    }
}