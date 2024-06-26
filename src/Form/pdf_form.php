<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class pdf_form extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required'   => true,
                'attr' => [
                    'placeholder' => 'Nom du PDF',
                ],
            ])
            ->add('url', TextType::class, [
                'required'   => true,
                'attr' => [
                    'placeholder' => 'https://example.com',
                ],
            ])
        ;
    }
}