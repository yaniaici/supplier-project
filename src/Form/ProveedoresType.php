<?php

namespace App\Form;

use App\Entity\Proveedores;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;   // Tipo de campo email
use Symfony\Component\Form\Extension\Core\Type\TelType;     // Tipo de campo teléfono
use Symfony\Component\Validator\Constraints\Email;      
use Symfony\Component\Validator\Constraints\Length;     // Restricción de longitud
use Symfony\Component\Validator\Constraints\NotBlank;   // Restricción de campo vacío
use Symfony\Component\Validator\Constraints\Regex;      // Restricción de expresión regular (formato)
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;  // Restricción para las opciones
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProveedoresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombre', null, [
            'constraints' => [
                new NotBlank(),
                new Length([
                    'min' => 3,
                    'max' => 100,
                ]),
            ],
        ])
        ->add('correoElectronico', EmailType::class, [
            'constraints' => [
                new NotBlank(),
                new Email(),
            ],
        ])
        ->add('telefonoContacto', TelType::class, [
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^[0-9]{9}$/',
                    'message' => 'El teléfono debe tener 9 dígitos.',
                ]),
            ],
        ])
        ->add('tipoProveedor', ChoiceType::class, [
            'choices' => [
                'Hotel' => 'hotel',
                'Pista' => 'pista',
                'Complemento' => 'complemento',
            ],
        ])
        ->add('guardar', SubmitType::class)
            ->add('activo');
          //  ->add('fechaCreacion') ESTAS YA LAS CREA EL CONTROLLER
          //  ->add('fechaActualizacion')

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proveedores::class,
        ]);
    }
}