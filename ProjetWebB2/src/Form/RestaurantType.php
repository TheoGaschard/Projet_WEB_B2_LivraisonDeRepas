<?php

namespace App\Form;

use App\Entity\Restaurant;
use PhpParser\Node\Stmt\Label;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RestaurantType extends AbstractType
{

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ['label' => 'Nom du restaurant'])
            ->add('type', TextType::class, ['label' => 'Type du restaurant'])
            ->add('adresse', TextType::class, ['label' => 'Adresse du restaurant'])
            ->add('description', TextType::class , ['label' => 'Description du restaurant'])
            ->add('image', FileType::class, ['label' => 'Image du restaurant'])
            ->add('email', EmailType::class, ['label' => 'Email du restaurant'])
            ->add('idRestaurateur', HiddenType::class)
            ->add('save', SubmitType::class, ['label' => 'Enregistrer'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Restaurant::class,
        ]);
    }
}
