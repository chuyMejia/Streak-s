<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\StreakType;
use App\Entity\Streak;
use App\Entity\User;
use App\Entity\Category;

use Symfony\Component\Security\Core\User\UserInterface;


class StreakController extends AbstractController
{

   


   
    public function index(): Response
    {

         //prueba de entidades DATOS
         $em = $this->getDoctrine()->getManager();   
         
         
         /*$streak_repo =$this->getDoctrine()->getRepository(Streak::class);
         $results = $streak_repo->findAll();

         foreach($results as $streak){

            echo $streak->getTitle()."</br>";
         }*/
            $user_repo = $this->getDoctrine()->getRepository(User::class);
            $users = $user_repo->findAll();

            foreach($users as $user){
//saca las rachas que tiene cada usuario 
            //echo $user->getName()."</br>";
                    foreach($user->getStreaks() as $streak){
                    //    echo $streak->getTitle()."</br>";
                    }
             }


             $categories_repo = $this->getDoctrine()->getRepository(Category::class);
             $cats  = $categories_repo->findAll();

             foreach($user->getStreaks() as $streak){
                 //   echo $streak->getTitle()."</br>";
                                foreach($cats as $cat){
                              //      echo "{$cat->getTitle()}</br>";                    
                                }
                }


                $rachas_repo = $this->getDoctrine()->getRepository(Streak::class);
                $rachas = $rachas_repo->findAll();

              /*  foreach($rachas as $racha){
                    echo $racha->getTitle().'</br>';
                    echo $racha->getCategory()->getTitle().'</br>';
                }*/

                ///SACA LAS RACHAS POR CATEGORIA
                $categories_repo = $this->getDoctrine()->getRepository(Category::class);
                $cats  = $categories_repo->findAll();

               /* foreach($cats as $cat){
                    echo "<strong>".$cat->getTitle()."</strong></br>";
                    foreach($cat->getStreaks() as $data){
                        echo $data->getTitle()."</br>";

                    }
                }*/





            


                    // echo 'login correct';

                    // die();





        return $this->render('streak/index.html.twig', [
            'controller_name' => 'StreakController',
            'categorias' => $cats
        ]);
    }



    public function AllStreaks(){


        $em = $this->getDoctrine()->getManager();
        $streak_repo = $this->getDoctrine()->getRepository(Streak::class);
        $streaks = $streak_repo->findAll();





        return $this->render('streak/index.html.twig', [
            'controller_name' => 'StreakController',
            'streaks' => $streaks
        ]);

    }


    public function myStreaks(UserInterface $user){



        $streaks =  $user->getStreaks();
        //var_dump($streaks);
      //die();
        return $this->render('streak/my-streaks.html.twig',[
         'streaks' =>  $streaks
        ]);
 
     }



//action to create a new register





public function creation(Request $request, \Symfony\Component\Security\Core\User\UserInterface $user){

    $streak = new Streak();

    $form = $this->createForm(StreakType::class, $streak);

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        //si existe la action submit

        $streak->setCreateAt(new \DateTime('now'));
        $streak->setUser($user);
        $streak->setRepeatStreak(0);
        $streak->setImagen('Default_app');

        
        $em = $this->getDoctrine()->getManager();
        $em->persist($streak);
        $em->flush();

        return $this->redirect(
            //crea url para ir al detalle 
            $this->generateUrl('streak_detail',['id'=> $streak->getId()])
        );

    }
//te re-dirigue a al creacion 
    return $this->render('streak/creation.html.twig',[
        'form'=>$form->createView()
       
    ]);

}





public function detail($id){

    //load repository

    $streak_repo = $this->getDoctrine()->getRepository(Streak::class);
    //cosulta
    $streak = $streak_repo->find($id);

    //cpmprapbar result

    if (!$streak) {
        throw $this->createNotFoundException('Streak not found');
    }


    return $this->render('streak/detail.html.twig', [
        'streak' => $streak
    ]);

}








}
