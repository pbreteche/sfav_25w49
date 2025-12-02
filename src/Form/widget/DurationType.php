<?php

declare(strict_types=1);

namespace App\Form\widget;

use App\DataType\Duration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class DurationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hours', IntegerType::class, [
                'label' => false,
                'row_attr' => [
                    'min' => 0,
                    'class' => 'col-auto'
                ],
                'required' => false,
                'constraints' => [
                    new PositiveOrZero()
                ],
            ])
            ->add('minutes', IntegerType::class, [
                'label' => false,
                'row_attr' => [
                    'min' => 0,
                    'class' => 'col-auto'
                ],
                'required' => false,
                'constraints' => [
                    new PositiveOrZero()
                ],
            ])
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $classes = explode(' ', $view->vars['attr']['class'] ?? '');
        $classes[] = 'row';
        $view->vars['attr']['class'] = trim(implode(' ', $classes));
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Duration::class,
            'required' => true,
            'compound' => true,
        ]);
    }
}
