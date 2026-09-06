<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Etat;
use App\Entity\Ticket;
use App\Entity\Users;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add('auteur', EmailType::class, [
                'label' => 'Email du client',
            ])

            ->add('dateOuverture', DateTimeType::class, [
                'label' => 'Date d’ouverture',
                'widget' => 'single_text',
            ])

            ->add('dateCloture', DateTimeType::class, [
                'label' => 'Date de clôture',
                'widget' => 'single_text',
                'required' => false,
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'rows' => 5,
                ],
            ])

            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'placeholder' => 'Choisir une catégorie',
            ])

            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'nom',
                'label' => 'État',
                'placeholder' => 'Choisir un état',
            ])

            ->add('responsable', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'email',
                'label' => 'Responsable',
                'placeholder' => 'Choisir un responsable',
                'required' => false,
            ]);
    }

    public function configureOptions(
        OptionsResolver $resolver
    ): void {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}