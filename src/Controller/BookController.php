<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/', name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BookRepository $bookRepository): Response
    {
        // Method 1 - L'utilisateur doit etre identifié pour ajouter une entité
        // if (!$this->getUser()) 
        // {
        //     return $this->redirectToRoute('app_login');
        // }

        // Methode 2 - L'utilisateur doit avoir un role spécifique pour afficher la page
        if (!$this->isGranted('ROLE_ADMIN'))
        {
            $this->addFlash('warning', "Vous n'avez pas les droits pour créer un livre");
            return $this->redirectToRoute('app_book_index');
        }

        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            // Retrieve the input[name=cover]
            $coverFile = $form->get('cover')->getData();

            // Check if data ios uploaded
            if ($coverFile)
            {
                // Get the temporary uploaded file
                $file = $coverFile->getPathname();

                // Get the content of the uploaded file
                $file = file_get_contents($file);

                // Generate The HASH (MD5) of the content of the file
                $md5 = md5($file);

                // Define the new file name
                $fileNewName = $md5.'.'.$coverFile->guessExtension();

                // Define destination vars
                $destination_path = __DIR__."/../../public/upload/";

                // Move the uploaded file
                $coverFile->move(
                    $destination_path,
                    $fileNewName
                );

                // Add the public path of the file to the Book Entity
                $book->setCover($fileNewName);
            }

            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_show', methods: ['GET'])]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_book_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
