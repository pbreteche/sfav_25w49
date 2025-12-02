<?php

declare(strict_types=1);

namespace App\Form\widget;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferenceTagType extends AbstractType implements DataTransformerInterface
{
    public function __construct(
        private readonly TagRepository $tagRepository,
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
            'multiple' => true,
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }

    public function transform(mixed $value): ?string
    {
        if (empty($value)) {
            return null;
        }

        $viewArrayData = [];
        foreach ($value as $tag) {
            if (!$value instanceof Tag) {
                throw new TransformationFailedException();
            }
            $viewArrayData[] = $tag->getName();
        }

        return implode(' ', $viewArrayData);
    }

    public function reverseTransform(mixed $value): array
    {
        $arrayNames = array_unique(explode(' ', $value));

        $tags = [];
        foreach ($arrayNames as $name) {
            $existingTag = $this->tagRepository->findOneBy(['name' => $name]);
            $tags[] = $existingTag ?? (new Tag())->setName($name);
        }

        return $tags;
    }
}
