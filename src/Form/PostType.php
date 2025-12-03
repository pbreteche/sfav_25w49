<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\widget\DurationType;
use App\Form\widget\ReferenceTagType;
use App\Form\widget\SirenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSetDataEvent;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('body')
        ;
        if ($options['extended']) {
            $builder
                ->add('publishedAt', null, [
                    'widget' => 'single_text',
                ])
                ->add('state')
                ->add('tags', ReferenceTagType::class, [
                    'required' => false,
                ])
            ;
        }
        $builder->add('siren', SirenType::class, [
                'mapped' => false,
                'help' => 'Mettre le siret de la société à facturer.',
                'required' => false,
            ])
            ->add('duration')
            ->addEventListener(FormEvents::POST_SET_DATA, [$this, 'onPostSetData'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
            'extended' => true,
        ]);
    }

    public function onPostSetData(PostSetDataEvent $event): void
    {
        $data = $event->getData();
        if (!$data instanceof Post) {
            throw new UnexpectedTypeException($data, Post::class);
        }

        if ($data->getPublishedAt()) {
            $form = $event->getForm();
            $form->add('publishedAt', null, [
                'disabled' => true,
                'widget' => 'single_text',
            ]);
        }
    }
}
