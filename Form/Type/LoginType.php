<?php
/*
 * This file is part of the Swoopaholic Framework Bundle.
 *
 * (c) Danny Dörfel <danny@swoopaholic.nl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Swoopaholic\Bundle\FrameworkBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginType extends AbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            // a unique key to help generate the secret token
            'intention'       => 'authenticate',
            'translation_domain'=> 'FOSUserBundle'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('_username', 'text', array('label' => 'security.login.username', 'mapped' => false))
            ->add('_password', 'password', array('label' => 'security.login.password', 'mapped' => false))
            ->add('_remember_me', 'checkbox', array('label' => 'security.login.remember_me', 'mapped' => false))
            ->add('_submit', 'submit', array('label' => 'security.login.submit'))
            ;
    }

    public function getName()
    {
        return '';
    }
}
