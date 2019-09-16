<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use($options) {
            $form = $event->getForm();
            $action = $form->getConfig()->getOption('attr');
            $form->add('title')
                ->add('content', TextareaType::class)
                ->add('title')
                ->add('content', TextareaType::class);
            if ($action[0] != 'creat' & $action[1] != null || $action[0] != 'edit') {
                $form ->add('author', TextareaType::class, [
                    'label' => 'autheur']);
            }
        });
    }

}
