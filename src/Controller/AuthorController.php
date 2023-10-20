<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
  
    public function showAuthor($name)
    {
        return $this->render('author/show.html.twig',[
            'n'=>$name
        ]);    
    }
    //******************* */ exercice 2*********************************
    public function list()
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => ' Victor
            Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => '
            William Shakespeare', 'email' => ' william.shakespeare@gmail.com', 'nb_books' =>
            200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => ' Taha
            Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),);

            return $this->render('author/list.html.twig',['authors'=>$authors]);
        
    }

    public function authorDetails ($id){
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => ' Victor
            Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => '
            William Shakespeare', 'email' => ' william.shakespeare@gmail.com', 'nb_books' =>
            200 ),
            array('id' => 3, 'picture' => '/images/Taha-Hussein.jpg','username' => ' Taha
            Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),);

        $author=NULL;
        foreach($authors as $a)
        {
            if($a['id'] == $id)
            {
                $author =$a;
                
                break;
            }
        }

        return $this->render('author/showAuthor.html.twig',['author' => $author]);
    }

    #[Route('/author/get/all',name:'app_get_all')]
    public function getAll(AuthorRepository $repo){
        $authors = $repo ->findAll();
        return $this->render('author/list.html.twig',['authors'=>$authors]);
    }

    #[Route('/author/add',name:'app_add_author')]
    public function add(MangerRegistry $manager){
        $author = new Author();
        $author->setUsername("helmi1");
        $author->setEmail("helmi.gargouri1@esprit.tn");
        $manager->getManager()->presist($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');
    }

    #[Route('/author/delete/id',name:'app_delete_author')]
    public function detete($id,MangerRegistry $manager, AuthorRepository $repo){
        $author = $repo->find($id);
        $manager->getManager()->remove($author);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_get_all_author');
    }

}   
