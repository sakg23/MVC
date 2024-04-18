<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DeckController extends AbstractController
{
    /**
     * @Route("/api", name="api_overview")
     */
    public function apiOverview(): Response
    {
        $routes = [
            ['route' => '/api/deck', 'method' => 'GET', 'description' => 'Returnerar en sorterad kortlek'],
            ['route' => '/api/deck/shuffle', 'method' => 'POST', 'description' => 'Blandar kortleken och sparar i sessionen'],
            ['route' => '/api/deck/draw/{number}', 'method' => 'POST', 'description' => 'Drar ett eller flera kort från kortleken'],
            ['route' => '/api/deck/deal/{players}/{cards}', 'method' => 'POST', 'description' => 'Delar ut kort till spelare'],
        ];

        return $this->render('api/overview.html.twig', [
            'routes' => $routes
        ]);
    }

    /**
     * @Route("/api/deck", name="api_deck", methods={"GET"})
     */
    public function getDeck(): JsonResponse
    {
        $deck = $this->generateSortedDeck();
        return new JsonResponse($deck);
    }

    /**
     * @Route("/api/deck/shuffle", name="api_deck_shuffle", methods={"POST"})
     */
    public function shuffleDeck(SessionInterface $session): JsonResponse
    {
        $deck = $this->generateSortedDeck();
        shuffle($deck);
        $session->set('deck', $deck);
        return new JsonResponse($deck);
    }

    /**
     * @Route("/api/deck/draw/{number}", name="api_deck_draw", methods={"POST"}, defaults={"number": 1})
     */
    public function drawCards(SessionInterface $session, int $number): JsonResponse
    {
        $deck = $session->get('deck', $this->generateSortedDeck());
        $drawn = array_splice($deck, 0, $number);
        $session->set('deck', $deck);

        return new JsonResponse([
            'drawn' => $drawn,
            'remaining' => count($deck)
        ]);
    }

    /**
     * @Route("/api/deck/deal/{players}/{cards}", name="api_deck_deal", methods={"POST"})
     */
    public function dealCards(SessionInterface $session, int $players, int $cards): JsonResponse
    {
        $deck = $session->get('deck', $this->generateSortedDeck());
        $deals = [];
        for ($p = 0; $p < $players; $p++) {
            for ($c = 0; $c < $cards; $c++) {
                if (!empty($deck)) {
                    $deals["Player $p"][] = array_shift($deck);
                }
            }
        }
        $session->set('deck', $deck);

        return new JsonResponse([
            'deals' => $deals,
            'remaining' => count($deck)
        ]);
    }

    private function generateSortedDeck(): array
    {
        $suits = ['Clubs', 'Diamonds', 'Hearts', 'Spades'];
        $values = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King', 'Ace'];
        $deck = [];

        foreach ($suits as $suit) {
            foreach ($values as $value) {
                $deck[] = ['suit' => $suit, 'value' => $value];
            }
        }

        return $deck;
    }
}
