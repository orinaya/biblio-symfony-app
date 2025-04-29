<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/book')]
final class BookController extends AbstractController
{
    #[Route(name: 'app_book_index', methods: ['GET'])]
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('book/index.html.twig', [
            'books' => $bookRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_book_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                // Générer un nom unique pour le fichier
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    // Déplacer le fichier dans le répertoire configuré
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Défini dans services.yaml
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Gérer les erreurs d'upload si nécessaire
                    throw new \Exception('Une erreur est survenue lors de l\'upload de l\'image.');
                }
                // Enregistrer le nom du fichier dans l'entité
                $book->setImage($newFilename);
            }

            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/new.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
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
    public function edit(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        $originalImage = $book->getImage();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $imageFile */
            $imageFile = $form->get('image')->getData();

            // Supprimer les appels à dd() qui interrompent l'exécution
            // dd($originalImage);
            // dd($imageFile);

            if ($imageFile) {
                // Générer un nom unique pour le fichier
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();
                try {
                    // Déplacer le fichier dans le répertoire configuré
                    $imageFile->move(
                        $this->getParameter('images_directory'), // Défini dans services.yaml
                        $newFilename
                    );
                    if ($originalImage) {
                        $oldImagePath = $this->getParameter('images_directory') . '/' . $originalImage;
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $book->setImage($newFilename);
                } catch (FileException $e) {
                    // Gérer les erreurs d'upload si nécessaire
                    throw new \Exception('Une erreur est survenue lors de l\'upload de l\'image.');
                }
            } else {
                // Conserver l'image originale si aucune nouvelle image n'est fournie
                $book->setImage($originalImage);
            }

            // Mettre à jour les associations
            foreach ($book->getCategories() as $category) {
                $category->addBook($book);
            }

            foreach ($book->getTags() as $tag) {
                $tag->addBook($book);
            }

            foreach ($book->getLanguages() as $language) {
                $language->addBook($book);
            }

            foreach ($book->getAuthors() as $author) {
                $author->addBook($book);
            }

            $entityManager->flush();
            return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_book_delete', methods: ['POST'])]
    public function delete(Request $request, Book $book, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $book->getId(), $request->request->get('_token'))) {
            $entityManager->remove($book);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
