<?php

namespace App\Controller\Admin;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\Tag;
use App\Entity\Tag\UserTag;
use App\Form\Tag\UserTagType;
use App\Manager\Tag\PublicationTagManager;
use App\Repository\Tag\UserTagRepository;
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
    public function index(UserTagRepository $tagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $tagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request, PublicationTagManager $publicationTagManager): Response
    {
        $tag = new UserTag();
        $form = $this->createForm(UserTagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tag);
            $entityManager->flush();
            $publicationTagManager->createFromUserTag($tag);

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('admin/tag/new.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tag_show", methods={"GET"})
     */
    public function show(Tag $tag): Response
    {
        return $this->render('admin/tag/show.html.twig', [
            'tag' => $tag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, UserTag $tag): Response
    {
        $form = $this->createForm(UserTagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('admin/tag/edit.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, UserTag $tag, PublicationTagManager $publicationTagManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tag->getId(), $request->request->get('_token'))) {
            $publicationTagManager->removeFromUserTag($tag);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tag_index');
    }
}
