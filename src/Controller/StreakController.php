<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Streak;
use App\Entity\User;
use App\Entity\Category;

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

                foreach($cats as $cat){
                    echo "<strong>".$cat->getTitle()."</strong></br>";
                    foreach($cat->getStreaks() as $data){
                        echo $data->getTitle()."</br>";

                    }
                }





            








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
}
