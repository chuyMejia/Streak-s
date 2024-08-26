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

use Doctrine\ORM\EntityManagerInterface; 

use Symfony\Component\Security\Core\User\UserInterface;


class StreakController extends AbstractController
{

    private $entityManager;

    // Constructor para inyectar EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


   
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


    // public function myStreaks(UserInterface $user){

    //     $hoy = date("d/m/Y H:m");
    //     $currentDate = date('Y-m-d');
    //     // Obtiene el número del día del año para la fecha actual
    //     $dayOfYear = date('z', strtotime($currentDate)) + 1;


    //     $streaks =  $user->getStreaks();
    //     //var_dump($streaks);
    //   //die();
    //     return $this->render('streak/my-streaks.html.twig',[
    //      'streaks' =>  $streaks,
    //      'today' => $hoy,
    //      'day_year' => $dayOfYear
    //     ]);
 
    //  }


    public function myStreaks(): Response
    {
        $user = $this->getUser(); // Obtiene el usuario actualmente autenticado

        if (!$user instanceof UserInterface) {
            throw $this->createAccessDeniedException('Necesitas estar logueado para acceder a esta página.');
        }

        // Obtiene la fecha de hoy
        $today = new \DateTime('now');
        $todayString = $today->format('Y-m-d'); // Formato para comparación

        // Ejecuta la actualización masiva en la base de datos
        $connection = $this->entityManager->getConnection();
        $sql = '
            UPDATE streaks
            SET `do` = :do
            WHERE DATE(last_modified) != :today
        ';
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            'do' => false,
            'today' => $todayString
        ]);

        // Obtener los streaks actualizados para el usuario
        $streaks = $user->getStreaks();

        // Renderizar la vista con los streaks
        return $this->render('streak/my-streaks.html.twig', [
            'streaks' => $streaks,
            'today' => $today->format('d/m/Y H:i'),
            'day_year' => $today->format('z') + 1
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
        $streak->setLast_modified(new \DateTime('now'));


        
        

        
        $em = $this->getDoctrine()->getManager();
        $em->persist($streak);
        $em->flush();

        return $this->redirect(
            //crea url para ir al detalle   index
            //$this->generateUrl('streak_detail',['id'=> $streak->getId()]) 
            $this->generateUrl('index')
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

    //cpmprapbar result aqui chuy 

    $today = new \DateTime('now');

    if (!$streak) {
        throw $this->createNotFoundException('Streak not found');
    }


    return $this->render('streak/detail.html.twig', [
        'streak' => $streak,
        'day_year' => $today->format('z') + 1
    ]);

}

public function do(int $id, ?int $redirect = null, EntityManagerInterface $entityManager): Response
{
   

    // Encuentra el streak por ID
    $streak = $entityManager->getRepository(Streak::class)->find($id);

    if (!$streak) {
        throw $this->createNotFoundException('No streak found for id ' . $id);
    }

    // Aumenta el campo repeat_streak
    $currentStreak = $streak->getRepeatStreak();
    $streak->setLast_modified(new \DateTime('now'));
    $streak->setRepeatStreak($currentStreak + 1);
    $streak->setDo(true);

    // Guarda los cambios
    $entityManager->persist($streak);
    $entityManager->flush();

    if($redirect == 1 ){

        return $this->redirect(
            //crea url para ir al detalle   index

            
            $this->generateUrl('streak_detail', ['id' => $id])
        );

    }else{
        
    return $this->redirect(
        //crea url para ir al detalle   index
        $this->generateUrl('index')
    );
        
    }
}





}
