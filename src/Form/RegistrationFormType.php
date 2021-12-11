<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // EL LABEL ES PARA EL INPUT
            ->add('email', EmailType::class, array('attr' => array('label' => 'Email', 'class' => 'form-control txt')))
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'Debe de aceptar nuestro términos.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, 
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                [
                'attr' => array('label' => 'Contraseña', 'class' => 'form-control txt'),
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, introduzca una contraseña.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Tú contraseña debe de tener al menos {{ limit }} carácteres.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ], 
            ])
            ->add('nick', TextType::class, array('attr' => array('label' => 'Nick', 'class' => 'form-control txt')))
            ->add('name', TextType::class, array('attr' => array('label' => 'Nombre', 'class' => 'form-control txt')))
            ->add('surname', TextType::class, array('attr' => array('label' => 'Apellidos', 'class' => 'form-control txt')))
            ->add('country', ChoiceType::class,
                array(
                    'attr' => array(
                        'label' => 'País',
                        'class' => 'form-control txt'
                    ),
                    'choices' => array(
                                    'Alemania' => 'de',
                                    'Bélgica' => 'be',
                                    'Dinamarca' => 'dk',
                                    'España' => 'es',
                                    'Finlandia' => 'fi',
                                    'Francia' => 'fr',
                                    'Holanda' => 'nl',
                                    'Italia' => 'it',
                                    'Polonia' => 'pl',
                                    'Portugal' => 'pt',
                                    'Suiza' => 'ch',
                                    'Suecia' => 'se',
                                    'Reino Unido' => 'uk',
                                )
                    ),
            )
            ->add('city', TextType::class, array('attr' => array('label' => 'Ciudad', 'class' => 'form-control txt')))
            ->add('birth', BirthdayType::class, [
                'widget' => 'single_text',
                'attr' => array(
                                'label' => 'F. Nacimiento', 
                                'class' => 'form-control txt'
                            )   
            ])  
            ->add('imgUser', FileType::class, array('attr' => array('label' => 'imgUser', 'required' => true)))

            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
