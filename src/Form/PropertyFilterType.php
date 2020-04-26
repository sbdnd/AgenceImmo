<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertyFilter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PropertyFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => 'Budget max',
                'attr' => [
                    'placeholder' => 'entrez votre budget'
                ]
            ])

            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => 'Surface minimale',
                'attr' => [
                    'placeholder' => 'entrez la surface'
                ]
            ])

            ->add('options', EntityType::class, [
                'required' => false,
                'label' => 'Options',
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true
        
            ])
        ;
    }

    /**
     * Méthode GET utilisée pour pouvoir partager le formulaire
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertyFilter::class,
            'method' => 'get',
            'csrf_protection' => false //token inutile à ce niveau
        ]);
    }

    /**
     * Amélioration du rendu des paramètres dans l'url
     * @return void
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
