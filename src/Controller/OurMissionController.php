<?php

namespace App\Controller;

use App\Entity\OurMission;
use App\Repository\OurMissionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/our_mission")
 */
class OurMissionController extends AbstractController
{
    /**
     * @Route("/", name="our_mission_index", methods={"GET"})
     */
    public function index(OurMissionRepository $ourMissionRepository): Response
    {
        return $this->render('about/our_mission/index.html.twig', [
            'our_missions' => $ourMissionRepository->findAll(),
        ]);
    }
}
