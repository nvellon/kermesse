<?php

namespace Kermesse\KermesseBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Kermesse\KermesseBundle\Form\SalesProductsType;

class SalesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('event', 'entity', array('class' => 'KermesseBundle:Events', 'property' => 'name'))
            ->add('salesLines', 'collection', array('type' => new SalesProductsType(), 'options' => array('attr' => array('class' => 'saleLine'))))
            ->add('priceTotal', 'money', array('currency' => '', 'disabled' => true))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Kermesse\KermesseBundle\Entity\Sales'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'kermesse_kermessebundle_sales';
    }
}
