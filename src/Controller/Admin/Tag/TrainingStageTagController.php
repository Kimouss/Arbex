<?php

namespace App\Controller\Admin\Tag;

use App\Controller\ArbexAbstractController;
use App\Entity\Tag\TrainingStageTag;
use App\Form\Tag\TrainingStageTagType;
use App\Repository\Tag\TrainingStageTagRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/tag/training_stage/tag")
 */
class TrainingStageTagController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_training_stage_tag_index", methods={"GET"})
     */
    public function index(TrainingStageTagRepository $parentPublicationTagRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $parentPublicationTagRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/tag/training_stage_tag/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_training_stage_tag_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $parentPublicationTag = new TrainingStageTag();
        $form = $this->createForm(TrainingStageTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($parentPublicationTag);
            $entityManager->flush();

            return $this->redirectToRoute('admin_training_stage_tag_index');
        }

        return $this->render('admin/tag/training_stage_tag/new.html.twig', [
            'training_stage_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_training_stage_tag_show", methods={"GET"})
     */
    public function show(TrainingStageTag $parentPublicationTag): Response
    {
        return $this->render('admin/tag/training_stage_tag/show.html.twig', [
            'training_stage_tag' => $parentPublicationTag,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_training_stage_tag_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TrainingStageTag $parentPublicationTag): Response
    {
        $form = $this->createForm(TrainingStageTagType::class, $parentPublicationTag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_training_stage_tag_index');
        }

        return $this->render('admin/tag/training_stage_tag/edit.html.twig', [
            'training_stage_tag' => $parentPublicationTag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_training_stage_tag_delete", methods={"POST"})
     */
    public function delete(Request $request, TrainingStageTag $parentPublicationTag): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parentPublicationTag->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($parentPublicationTag);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_training_stage_tag_index');
    }
}
