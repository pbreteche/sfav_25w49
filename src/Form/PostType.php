<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\widget\DurationType;
use App\Form\widget\ReferenceTagType;
use App\Form\widget\SirenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
            ->add('publishedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('state')
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'id',
                'multiple' => true,
                'required' => false,
            ])
            ->add('siren', SirenType::class, [
                'mapped' => false,
                'help' => 'Mettre le siret de la société à facturer.',
                'required' => false,
            ])
            ->add('duration', DurationType::class, [
                'mapped' => false,
                'required' => false,
            ])
            ->add('tag', ReferenceTagType::class, [
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
