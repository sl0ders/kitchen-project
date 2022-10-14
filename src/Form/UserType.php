<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserType extends AbstractType
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "label" => "user.label.email"
            ])
            ->add('firstname', TextType::class, [
                "label" => "user.label.firstname"
            ])
            ->add('lastname', TextType::class, [
                "label" => "user.label.lastname"
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                'invalid_message' => $this->translator->trans("constraint.user.password.invalidDuo", [], "validators"),
                'required' => true,
                'first_options'  => ['label' => 'user.label.password'],
                'second_options' => ['label' => 'user.label.repeatPassword'],
            ])
            ->add('submit', SubmitType::class, [
                "label" => "form.button.save"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => "kitchen-project"
        ]);
    }
}
