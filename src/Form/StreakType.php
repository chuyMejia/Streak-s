<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use Doctrine\ORM\EntityRepository;

class StreakType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, [
            'label' => 'Title'
        ])
        ->add('content', TextareaType::class, [
            'label' => 'Content'
        ])
        ->add('priority', ChoiceType::class, [
            'label' => 'priority',
            'choices'=> array(
                'Alta' => 'high',
                'Medio' => 'medium',
                'Baja' => 'Low'
            )
        ])
        ->add('hours', ChoiceType::class, [
            'label' => 'Horas',  
            'choices'=> array(
               '1' => 1,
               '2' => 2,
               '3' => 3,
               '4' => 4,
               '5' => 5,
               '6' => 6,
                )
        ])
        // ->add('imagen', TextType::class, [
        //     'label' => 'Image'
        // ])


        ->add('category', EntityType::class, [
            'class' => Category::class,
            'choice_label' => 'title',
            'label' => 'Category',
            'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('c')
                          ->orderBy('c.title', 'ASC');
            }
        ])
        
        ->add('submit', SubmitType::class, [
            'label' => 'Guardar'
        ]);
    }
}
