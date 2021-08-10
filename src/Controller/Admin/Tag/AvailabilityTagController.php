<?php

namespace App\Controller\Admin\Tag;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\AvailabilityTag;
use App\Form\Tag\AvailabilityTagType;
use App\Repository\Tag\AvailabilityTagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag/availability/tag")
 */
class AvailabilityTagController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_availability_tag_index", methods={"GET"})
     */
    public function index(AvailabilityTagRepository $parentPublicationTagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $parentPublicationTagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/availability_tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_availability_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $parentPublicationTag = new AvailabilityTag();
        $form = $this->createForm(AvailabilityTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parentPublicationTag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_availability_tag_index');
        }

        return $this->render('admin/tag/availability_tag/new.html.twig', [
            'availability_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_availability_tag_show", methods={"GET"})
     */
    public function show(AvailabilityTag $parentPublicationTag): Response
    {
        return $this->render('admin/tag/availability_tag/show.html.twig', [
            'availability_tag' => $parentPublicationTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_availability_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AvailabilityTag $parentPublicationTag): Response
    {
        $form = $this->createForm(AvailabilityTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_availability_tag_index');
        }

        return $this->render('admin/tag/availability_tag/edit.html.twig', [
            'availability_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_availability_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, AvailabilityTag $parentPublicationTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parentPublicationTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parentPublicationTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_availability_tag_index');
    }
}
