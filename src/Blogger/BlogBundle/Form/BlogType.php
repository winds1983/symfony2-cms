<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            //->add('slug')
            ->add('author')
            ->add('content')
            ->add('image', 'file', array('required'=>false))
            ->add('tags', 'text', array('required'=>false))
            //->add('created')
            //->add('updated')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Blog'
        ));
    }

    public function getName()
    {
        return 'blogger_blogbundle_blogtype';
    }
}
