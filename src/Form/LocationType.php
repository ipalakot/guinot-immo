<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denomination')
            ->add('photo')
            ->add('createdAt')
            ->add('description')
            ->add('surface')
            ->add('type')
            ->add('chambre')
            ->add('etage')
            ->add('prix')
            ->add('adresse')
            ->add('cp')
            ->add('ville')
            ->add('pays')
            ->add('accessibility')
            ->add('categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
