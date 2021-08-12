<?php

namespace App\Controller;

use App\Repository\OurHistoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/our_history")
 */
class OurHistoryController extends AbstractController
{
    /**
     * @Route("/", name="our_history_index", methods={"GET"})
     */
    public function index(OurHistoryRepository $ourHistoryRepository): Response
    {
        return $this->render('about/our_history/index.html.twig', [
            'our_histories' => $ourHistoryRepository->findBy([], ['id' => 'DESC'], 1, 0),
        ]);
    }
}
