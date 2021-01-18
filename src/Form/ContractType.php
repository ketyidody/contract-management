<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Person;
use App\Entity\RentalObject;
use App\Repository\PersonRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'html5_datepicker']
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['class' => 'html5_datepicker']
            ])
            ->add('noticePeriod')
            ->add('rent')
            ->add('residents', EntityType::class, [
                'class' => 'App:Person',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (PersonRepository $pr) {
                    // We can expand it here if you only want to have free contractors to show up (with no active contract)
                    return $pr->createQueryBuilder('p')
                        ->where('p.pType = :type')
                        ->setParameter('type', Person::TYPES['Contractor'])
                    ;
                }
            ])
            ->add('contractParties', EntityType::class, [
                // No need to filter it here, we want all person to be available
                'class' => 'App:Person',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('rentalObject', EntityType::class, [
                // Also no restriction as we can create a future contract for a currently occupied object
                'class' => 'App:RentalObject',
                'multiple' => false,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
