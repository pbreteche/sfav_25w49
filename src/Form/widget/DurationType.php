<?php

declare(strict_types=1);

namespace App\Form\widget;

use App\DataType\Duration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\PositiveOrZero;

class DurationType extends AbstractType implements DataMapperInterface
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
                    new PositiveOrZero(),
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
                    new PositiveOrZero(),
                    new LessThan(60),
                ],
            ])->setDataMapper($this)
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
            'empty_data' => null,
        ]);
    }

    public function mapDataToForms(mixed $viewData, \Traversable $forms): void
    {
        if (null === $viewData) {
            return;
        }

        if (!$viewData instanceof Duration) {
            throw new UnexpectedTypeException($viewData, Duration::class);
        }

        $arrayForms = iterator_to_array($forms);
        $arrayForms['hours']->setData($viewData->getHours());
        $arrayForms['minutes']->setData($viewData->getMinutes());
    }

    public function mapFormsToData(\Traversable $forms, mixed &$viewData): void
    {
        $arrayForms = iterator_to_array($forms);
        if (!$arrayForms['hours']->getData() && !$arrayForms['minutes']->getData()) {
            $viewData = null;
        } else {
            $viewData = new Duration(
                $arrayForms['hours']->getData() * 60
                + $arrayForms['minutes']->getData()
            );
        }
    }
}
