<?php

namespace App\Controller;

use App\Form\ChangeNameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;

class LearningController extends AbstractController
{
    /**
     * @Route("/about-becode", name="about-me")
     */
    public function index(SessionInterface $session)
    {
        if($session->get('name')){
            $name=$session->get('name');
            return $this->render('learning/index.html.twig', [
                'controller_name' => 'LearningController',
                'name'=>$name,
                'aboutMe'=>$this->aboutme($name),
            ]);
        }

         return $this->forward('App\Controller\LearningController::showMyName');
    }

    public function aboutme(string $name):string{
        return "Hye I'm $name. Welcome to my page! ";
    }

    /**
     * @Route("/change-my-name", name="change-my-name")
     */
    public function changeMyName(Request $request,SessionInterface $session){
        if (!empty($request->request->get('change_name'))) {
            $changeName= $request->request->get('change_name');
            $name =$changeName['name'];
            $session->set('name', $name);
            return $this->redirectToRoute('home');
        }

        return $this->render('learning/showMyName.html.twig', [
            'controller_name' => 'LearningController',


        ]);
    }


    /**
     * @Route("/", name="home", defaults={"name" = "Unknown"})
     */
    public function showMyName( SessionInterface $session)
    {
$name="unknown";
        if($session->get('name')) {
            $name = $session->get('name');
        }

        $form=$this->createForm(ChangeNameType::class);
        return $this->render('learning/showMyName.html.twig', [
            'controller_name' => 'LearningController',
            'name'=>$name,
            'form'=>$form->createView(),

        ]);

    }



}
