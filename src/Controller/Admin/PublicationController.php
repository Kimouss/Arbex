<?php

namespace App\Controller\Admin;

use App\Controller\ArbexAbstractController;
use App\Entity\Publication;
use App\Entity\User\User;
use App\Form\Publication\PublicationType;
use App\Repository\PublicationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/publication")
 */
class PublicationController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $publicationRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/publication/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('admin_publication_index');
        }

        return $this->render('admin/publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('admin/publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_publication_index');
        }

        return $this->render('admin/publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_publication_delete", methods={"POST"})
     */
    public function delete(Request $request, Publication $publication): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_publication_index');
    }

    /**
     * @Route("/{user_id}/publications", name="admin_publication_list", methods={"GET"})
     * @ParamConverter("user", options={"mapping": {"user_id": "id"}})
     */
    public function list(PublicationRepository $publicationRepository, User $user, Request  $request): Response
    {
        $searchForm = $this->createForm(TagSearchType::class);
        $query = $publicationRepository->getAllByUser($user->getId());
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted()) {
            $query = $publicationRepository->getSearchQuery($user->getId(), $request->get('publication_search'));
        }

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/publication/partials/_list.html.twig', [
            'user' => $user,
            'pagination' => $pagination,
            'search_form' => $searchForm->createView(),
        ]);
    }
}
