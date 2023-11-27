<?php

namespace App\Form;

use App\Entity\Film;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imdbTitleId')
            ->add('title', TextType::class, array('label' => 'Título Película: '))
            ->add('datePublished', DateType::class, [
					'widget' => 'choice',
			'format' => 'dd-MM-yyyy',
])
            ->add('genre')
            ->add('duration')
            ->add('productionCompany')
			
           // ->add('actors')
           // ->add('director')
        ;
		$builder->add('director', CollectionType::class, [
            'entry_type' => DirectorType::class,
            'entry_options' => ['label' => 'director'],
        ]);
		$builder->add('actors', CollectionType::class, [
            'entry_type' => ActorType::class,
            'entry_options' => ['label' => 'actor'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
