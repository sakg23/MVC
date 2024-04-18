<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends AbstractController
{
    #[Route('/report', name: 'report')]
    public function index(): Response
    {
        // Här kan du samla och visa informationen om dina redovisningstexter
        // T.ex. rendera en template som visar en lista över kmom och en kort sammanfattning av varje
        return $this->render('report.html.twig');
    }
}
