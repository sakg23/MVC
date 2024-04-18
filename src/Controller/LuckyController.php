<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class LuckyController
{
    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: '.$number.'</body></html>'
        );
    }

    #[Route("/lucky/hi")]
    public function hi(): Response
    {
        return new Response(
            '<html><body>Hi to you!</body></html>'
        );
    }

    #[Route('/api/', name: 'api_index')]
    public function apiIndex(): Response
    {
        $content = '<html><body>';
        $content .= '<h1>API Routes</h1>';
        $content .= '<ul>';
        $content .= '<li><a href="/api/quote">/api/quote</a> - Get today\'s quote</li>';
        $content .= '<li><a href="/api/lucky/number">/api/lucky/number</a> - Get a lucky number</li>';
        // Add more routes if needed
        $content .= '</ul>';
        $content .= '</body></html>';

        return new Response($content);
    }

    #[Route("/api/quote")]
    public function apiQuote(): JsonResponse
    {
        $quotes = [
            "The only way to do great work is to love what you do.",
            "Innovation distinguishes between a leader and a follower.",
            "Your time is limited, do not waste it living someone else`s life."
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        $data = [
            'quote' => $randomQuote,
            'date' => date('Y-m-d'),
            'timestamp' => time()
        ];

        return new JsonResponse($data);
    }
}
