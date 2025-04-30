<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(ReservationRepository $reservationRepository): Response
    {

        $user = $this->getUser();

        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            $reservations = $reservationRepository->findAll();
        } else {
            $reservations = $reservationRepository->findBy(['reservationUser' => $user]);
        }

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/reservation/new/{id}', name: 'app_reservation_new', methods: ['GET'])]
    public function new(Book $book, ReservationRepository $reservationRepository, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        $existing = $reservationRepository->findOneBy(['book' => $book]);
        if ($existing) {
            $this->addFlash('error', 'Ce livre est déjà réservé.');
            return $this->render('book/show.html.twig', [
                'book' => $book,
            ]);
        }

        $count = $reservationRepository->count(['reservationUser' => $user]);
        if ($count >= 5) {
            $this->addFlash('error', 'Vous avez atteint le nombre maximum de réservations.');
            return $this->render('book/show.html.twig', [
                'book' => $book,
            ]);
        }

        $reservation = new Reservation();
        $reservation->setReservationUser($user);
        $reservation->setBook($book);

        $em->persist($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation effectuée.');

        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/reservation/delete/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    public function delete(Reservation $reservation, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if ($reservation->getReservationUser() !== $user) {
            throw $this->createAccessDeniedException('Vous ne pouvez pas supprimer cette réservation.');
        }

        $em->remove($reservation);
        $em->flush();

        $this->addFlash('success', 'Réservation annulée.');
        return $this->redirectToRoute('app_book_index', [], Response::HTTP_SEE_OTHER);
    }
}
