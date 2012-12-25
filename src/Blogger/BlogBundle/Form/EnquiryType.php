<?php
namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface; // used FormBuilderInterface in v2.1.x

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('email', 'email');
        $builder->add('subject');
        $builder->add('body', 'textarea');
    }
    
    /**
     * it will used in form field name => contact[email]
     * required, it must be set
     * @see \Symfony\Component\Form\FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'contact';
    }
}