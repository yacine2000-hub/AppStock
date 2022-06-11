<?php
namespace App\Form;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;

class AddEntree extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('qte', IntegerType::class, [
                'label_attr' => ['class' => 'form-label'],
                'required' => true,
                'attr' =>  [ 'class' => 'form-control']
            ])
            
           

        
        ->add('prix', IntegerType::class, [
            'label_attr' => ['class' => 'form-label'],
            'required' => true,
            'attr' =>  [ 'class' => 'form-control']
        ])
        ->add('produit', EntityType::class, array('class'=>Produit::class,'attr'=>array('require'=>'require','class'=>'form-label','class'=>'form-control')))

    
        ->add('date', DateType::class, [
            'label_attr' => ['class' => 'form-label'],
            'required' => true,
            'attr' =>  [ 'class' => 'form-control']
        ]) ;
    }
}