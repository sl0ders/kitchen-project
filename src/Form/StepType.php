<?php

namespace App\Form;

use App\Entity\Step;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                "label" => "step.label.content",
            ])
            ->add('time', TextType::class, [
                "label" => "step.label.time",
            ])
            ->add('isCooking', CheckboxType::class, [
                "label" => "step.label.IsCooking",
            ])
            ->add('ingredientName', TextType::class, [
                "label" => "step.label.ingredient.name",
                'attr' => ["class" => "stepInput"],
                "mapped" => false,
                "required" => false,
            ])
            ->add('ingredientQuantity', NumberType::class, [
                "label" => "step.label.ingredient.quantity",
                "mapped" => false,
                "required" => false,
            ])
            ->add('ingredientUnity', TextType::class, [
                "label" => "step.label.ingredient.quantity",
                'attr' => ["class" => "stepInput"],
                "mapped" => false,
                "required" => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => "kitchen-project",
            'data_class' => Step::class,
        ]);
    }
}
