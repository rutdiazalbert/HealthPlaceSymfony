<?php

namespace App\Controller;

use App\Form\DiagnosisFormType;
use App\Form\PatientAppointentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController{

    /**
     * @Route("/home", name=" home ")
     */

    public function home(){

        return $this->render('patient/home.html.twig');

    }

    /**
     * @Route("/appointments/upcoming", name=" upcomingAppo ")
     */
    public function upcomingAppointments(){

        return $this->render('patient/upcomingAppointments.html.twig');

    }

    /**
     * @Route("/appointments/previous", name=" previousAppo ")
     */
    public function previousAppointments(){

        return $this->render('patient/previousAppointments.html.twig');

    }

    
    /**
     * @Route("/diagnostics", name=" diagnostics ")
     */
    public function diagnoses(){

        return $this->render('patient/diagnosis.html.twig');

    }


    /**
     * @Route("/patient/appointment/create", name=" createAppoPatient ")
     */
    public function createAppointment(Request $request, EntityManagerInterface $doctrine){
        $form = $this->createForm(PatientAppointentFormType::class);

        $form->handleRequest($request);


        return $this->render('patient/createAppointment.html.twig',  ['patientAppointmentForm' => $form->createView()]);
    }

    /**
     * @Route("/doctor/diagnosis/create", name=" createDiagnosis ")
     */
    public function createDiagnosis(Request $request, EntityManagerInterface $doctrine){
        $form = $this->createForm(DiagnosisFormType::class);

        $form->handleRequest($request);


        return $this->render('patient/createDiagnosis.html.twig',  ['diagnosisForm' => $form->createView()]);
    }
}