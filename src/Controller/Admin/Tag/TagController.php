<?php

namespace App\Controller\Admin\Tag;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\ParentPublicationTag;
use App\Form\Tag\ParentPublicationTagType;
use App\Repository\Tag\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag")
 */
class TagController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_tag_index", methods={"GET"})
     */
    public function index(TagRepository $parentPublicationTagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $parentPublicationTagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $parentPublicationTag = new ParentPublicationTag();
        $form = $this->createForm(ParentPublicationTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parentPublicationTag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('admin/tag/tag/new.html.twig', [
            'tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tag_show", methods={"GET"})
     */
    public function show(ParentPublicationTag $parentPublicationTag): Response
    {
        return $this->render('admin/tag/tag/show.html.twig', [
            'tag' => $parentPublicationTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ParentPublicationTag $parentPublicationTag): Response
    {
        $form = $this->createForm(ParentPublicationTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('admin/tag/tag/edit.html.twig', [
            'tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, ParentPublicationTag $parentPublicationTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parentPublicationTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parentPublicationTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tag_index');
    }
}
