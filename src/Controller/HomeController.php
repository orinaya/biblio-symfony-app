<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    private $bookRepository;

    public function __construct(\App\Repository\BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $books = $this->bookRepository->findBy([], ['id' => 'DESC'], 5);

        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route("/private", name: "app_private")]
    public function private(): Response
    {
        return $this->render("home/private.html.twig", []);
    }
}
