<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre du cours',
                'attr' => ['class' => 'form-control mb-3', 'placeholder' => 'Ex: Introduction à Symfony']
            ])
            ->add('description', null, [
                'label' => 'Description courte',
                'attr' => ['class' => 'form-control mb-3', 'rows' => 3, 'placeholder' => 'Un bref résumé de ce que l\'on va apprendre...']
            ])
            ->add('content', null, [
                'label' => 'Contenu du cours',
                'attr' => ['class' => 'form-control mb-3', 'rows' => 10]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
