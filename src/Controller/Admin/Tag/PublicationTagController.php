<?php

namespace App\Controller\Admin\Tag;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\PublicationTag;
use App\Form\Tag\PublicationTagType;
use App\Repository\Tag\PublicationTagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag/publication/tag")
 */
class PublicationTagController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_publication_tag_index", methods={"GET"})
     */
    public function index(PublicationTagRepository $parentPublicationTagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $parentPublicationTagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/publication_tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_publication_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $parentPublicationTag = new PublicationTag();
        $form = $this->createForm(PublicationTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parentPublicationTag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_publication_tag_index');
        }

        return $this->render('admin/tag/publication_tag/new.html.twig', [
            'publication_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_publication_tag_show", methods={"GET"})
     */
    public function show(PublicationTag $parentPublicationTag): Response
    {
        return $this->render('admin/tag/publication_tag/show.html.twig', [
            'publication_tag' => $parentPublicationTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_publication_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PublicationTag $parentPublicationTag): Response
    {
        $form = $this->createForm(PublicationTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_publication_tag_index');
        }

        return $this->render('admin/tag/publication_tag/edit.html.twig', [
            'publication_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_publication_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, PublicationTag $parentPublicationTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parentPublicationTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parentPublicationTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_publication_tag_index');
    }
}
