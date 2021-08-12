<?php

namespace App\Controller\Admin;

use App\Controller\ArbexAbstractController;
use App\Entity\OurMission;
use App\Form\OurMissionType;
use App\Repository\OurMissionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/our/mission")
 */
class OurMissionController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_our_mission_index", methods={"GET"})
     */
    public function index(OurMissionRepository $ourMissionRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $ourMissionRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/our_mission/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_our_mission_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ourMission = new OurMission();
        $form = $this->createForm(OurMissionType::class, $ourMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ourMission);
            $entityManager->flush();

            return $this->redirectToRoute('admin_our_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/our_mission/new.html.twig', [
            'our_mission' => $ourMission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_our_mission_show", methods={"GET"})
     */
    public function show(OurMission $ourMission): Response
    {
        return $this->render('admin/our_mission/show.html.twig', [
            'our_mission' => $ourMission,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_our_mission_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OurMission $ourMission): Response
    {
        $form = $this->createForm(OurMissionType::class, $ourMission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_our_mission_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/our_mission/edit.html.twig', [
            'our_mission' => $ourMission,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_our_mission_delete", methods={"POST"})
     */
    public function delete(Request $request, OurMission $ourMission): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ourMission->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ourMission);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_our_mission_index', [], Response::HTTP_SEE_OTHER);
    }
}
