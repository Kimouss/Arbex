<?php

namespace App\Controller\Admin\Tag;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\Tag;
use App\Form\Tag\TagType;
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
    public function index(TagRepository $tagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $tagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tag_show", methods={"GET"})
     */
    public function show(TagRepository $tagRepository): Response
    {
        return $this->render('admin/tag/tag/show.html.twig', [
            'tag' => $tagRepository,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tag $tagRepository): Response
    {
        $form = $this->createForm(TagType::class, $tagRepository);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_tag_index');
        }

        return $this->render('admin/tag/tag/edit.html.twig', [
            'tag' => $tagRepository,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, Tag $tagRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tagRepository->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tagRepository);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_tag_index');
    }
}
