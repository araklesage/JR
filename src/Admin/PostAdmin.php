<?php
/**
 * Created by PhpStorm.
 * User: Arak
 * Date: 07/12/2018
 * Time: 13:20
 */

namespace App\Admin;


use App\Entity\Category;
use App\Entity\Post;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class PostAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->tab('Article')
            ->with('Post', ['class' => 'col-md-9'])
            ->add('title', TextType::class)
            ->add('content', TextareaType::class)
            ->end()
            ->end()
            ->tab('Publish Options')
            ->with('Meta data', ['class' => 'col-md-3'])
            ->add('category', ModelType::class, [
                'class' => Category::class,
                'property' => 'name',
            ])
            ->end()
            ->end();
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('title')
            ->addIdentifier('content')
            ->addIdentifier('date')
            ->add('category.name')
            ->add('draft');

    }

    public function toString($object)
    {
        return $object instanceof Post
            ? $object->getTitle()
            : 'Post';
    }

    public function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('title')
            ->add('category', null, [], EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
        ;
    }


}