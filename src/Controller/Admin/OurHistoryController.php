<?php

namespace App\Controller\Admin;

use App\Controller\ArbexAbstractController;
use App\Entity\OurHistory;
use App\Form\OurHistoryType;
use App\Repository\OurHistoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/our/history")
 */
class OurHistoryController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_our_history_index", methods={"GET"})
     */
    public function index(OurHistoryRepository $ourHistoryRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $ourHistoryRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/our_history/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_our_history_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ourHistory = new OurHistory();
        $form = $this->createForm(OurHistoryType::class, $ourHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ourHistory);
            $entityManager->flush();

            return $this->redirectToRoute('admin_our_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/our_history/new.html.twig', [
            'our_history' => $ourHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_our_history_show", methods={"GET"})
     */
    public function show(OurHistory $ourHistory): Response
    {
        return $this->render('admin/our_history/show.html.twig', [
            'our_history' => $ourHistory,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_our_history_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, OurHistory $ourHistory): Response
    {
        $form = $this->createForm(OurHistoryType::class, $ourHistory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_our_history_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/our_history/edit.html.twig', [
            'our_history' => $ourHistory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_our_history_delete", methods={"POST"})
     */
    public function delete(Request $request, OurHistory $ourHistory): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ourHistory->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ourHistory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_our_history_index', [], Response::HTTP_SEE_OTHER);
    }
}
