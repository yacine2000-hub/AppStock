<?php
namespace App\Form;

use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddProduit extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle', TextType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            
            ->add('categorie', EntityType::class, array('class'=>Categorie::class,'attr'=>array('require'=>'require','class'=>'form-label','class'=>'form-control')))
            ->add('stock', IntegerType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])

        ;
    }
}