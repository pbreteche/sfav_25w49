<?php

declare(strict_types=1);

namespace App\Form\widget;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferenceTagType extends AbstractType implements DataTransformerInterface
{
    public function __construct(
        private TagRepository $tagRepository,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addModelTransformer($this);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tag::class,
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function transform(mixed $value): ?string
    {
        if ($value instanceof Tag) {
            return $value->getName();
        }

        return null;
    }

    public function reverseTransform(mixed $value): mixed
    {
        $existingTag =  $this->tagRepository->findOneBy(['name' => $value]);

        return $existingTag ?? (new Tag())->setName($value);
    }
}
