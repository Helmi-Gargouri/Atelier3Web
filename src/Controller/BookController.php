<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    //#[Route('/book/getAll', name: 'app_book_all')]
    public function index(BookRepository $repo): Response
    {
        $books = $repo->findAll();
        return $this->render('book/index.html.twig', [
            'books' => $books,
        ]);
    }


    #[Route('/addBook', name: 'app_book_add')]
    public function addBook(ManagerRegistry $manager,Request $req){
        $book = new Book();
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted())
        {
        $book->setPublished(true);
        $manager->getManager()->persist($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_book_all');
        }
        return $this->render('book/add.html.twig',['f'=>$form->createView()]);
    }

    #[Route('book/update/{ref}',name:'app_book_update')]
    public function updateBook(ManagerRegistry $manager,$ref,BookRepository $rep,Request $req){
        $book = $rep->find($ref);
        $form = $this->createForm(BookType::class,$book);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $manager->getManager()->flush();
            return $this->redirectToRoute('app_book_all');
        }
        return $this->render('book/add.html.twig',['f'=>$form->createView()]);
    }

    #[Route('book/delete/{ref}',name:'app_book_delete')]
    public function deleteBook(ManagerRegistry $manager,$ref,BookRepository $rep){
        $book = $rep->find($ref);
        $manager->getManager()->remove($book);
        $manager->getManager()->flush();
        return $this->redirectToRoute('app_book_all');
    }
}