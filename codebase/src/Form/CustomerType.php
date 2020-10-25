<?php

namespace App\Form;

use App\Entity\Customer;
use App\Enum\StatusEnumType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('dateOfBirth', DateType::class, [
                'widget' => 'single_text'
            ])
            ->add('status', ChoiceType::class, [
                'choices' => StatusEnumType::getFormAvailabelChoices(),
                'empty_data' => StatusEnumType::NEW_STATUS
            ])
            ->add('products', CollectionType::class, [
                'entry_type' => ProductType::class,
                'allow_add' => true,
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'csrf_protection' => false,
        ]);
    }
}
