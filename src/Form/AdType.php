<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, ['label' => 'label.title'])
            ->add('description', TextareaType::class, ['label' => 'label.description'])
            ->add('price', IntegerType::class, ['label' => 'label.price'])
            ->add('year', IntegerType::class, ['label' => 'label.year'])
            ->add('size', IntegerType::class, ['label' => 'label.size'])
            ->add('brand', TextType::class, ['label' => 'label.brand'])
            ->add('dueDate', DateType::class, ['label' => 'label.due_date'])
            ->add('guarantee', TextType::class, ['label' => 'label.guarantee'])
            ->add('save', SubmitType::class, ['label' => 'label.save'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
            $resolver->setDefaults(['translation_domain' => 'forms', 'required' => false]),
        ]);
    }
}
