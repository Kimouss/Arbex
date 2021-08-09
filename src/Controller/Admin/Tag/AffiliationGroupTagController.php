<?php

namespace App\Controller\Admin\Tag;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\AffiliationGroupTag;
use App\Form\Tag\AffiliationGroupTagType;
use App\Repository\Tag\AffiliationGroupTagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag/affiliation/group/tag")
 */
class AffiliationGroupTagController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_affiliation_group_tag_index", methods={"GET"})
     */
    public function index(AffiliationGroupTagRepository $parentPublicationTagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $parentPublicationTagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/affiliation_group_tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_affiliation_group_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $parentPublicationTag = new AffiliationGroupTag();
        $form = $this->createForm(AffiliationGroupTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parentPublicationTag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_affiliation_group_tag_index');
        }

        return $this->render('admin/tag/affiliation_group_tag/new.html.twig', [
            'affiliation_group_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_affiliation_group_tag_show", methods={"GET"})
     */
    public function show(AffiliationGroupTag $parentPublicationTag): Response
    {
        return $this->render('admin/tag/affiliation_group_tag/show.html.twig', [
            'affiliation_group_tag' => $parentPublicationTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_affiliation_group_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AffiliationGroupTag $parentPublicationTag): Response
    {
        $form = $this->createForm(AffiliationGroupTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_affiliation_group_tag_index');
        }

        return $this->render('admin/tag/affiliation_group_tag/edit.html.twig', [
            'affiliation_group_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_affiliation_group_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, AffiliationGroupTag $parentPublicationTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parentPublicationTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parentPublicationTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_affiliation_group_tag_index');
    }
}
