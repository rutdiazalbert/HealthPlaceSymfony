<?php

namespace App\Controller;

use App\Form\PatientAppointentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class PatientController extends AbstractController{

    /**
     * @Route("/patient/appointment/create")
     */
    public function createAppointment(Request $request, EntityManagerInterface $doctrine){
        $form = $this->createForm(PatientAppointentFormType::class);

        $form->handleRequest($request);


        return $this->render('patient/createAppointment.html.twig',  ['patientAppointmentForm' => $form->createView()]);
    }
}