<?php

namespace App\Controller;

use App\Form\DiagnosisFormType;
use App\Form\PatientAppointentFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Appointment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class UserController extends AbstractController{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/home", name=" home ")
     */

    public function home(EntityManagerInterface $em){
        $user = $this->security->getUser();
        $repo = $em->getRepository(Vehicle::class);
        $appointments = $repo->findBy(array('patient'=> $user));
        


        

        return $this->render('patient/home.html.twig', ["appointments" => $appointments]);

    }

    /**
     * @Route("/appointments/upcoming", name=" upcomingAppo ")
     */
    public function upcomingAppointments(EntityManagerInterface $doctrine){
        $repo = $doctrine->getRepository(Appointment::class);
        $appointments = $repo->findAll();


        return $this->render('patient/upcomingAppointments.html.twig', ["appointments" => $appointments]);

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
        if ($form->isSubmitted() && $form->isValid()){
            $appointment = $form->getData();

            $user = $this->security->getUser();

            $appointment->setPatient($user);



            $doctrine->persist($appointment);
            $doctrine->flush();

            return $this->redirectToRoute(" upcomingAppo ");
        }

 
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