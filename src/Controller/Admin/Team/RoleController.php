<?php

namespace App\Controller\Admin\Team;

use App\Controller\ArbexAbstractController;
use App\Entity\Team\Role;
use App\Form\Team\RoleType;
use App\Repository\Team\RoleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/team/role")
 */
class RoleController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_team_role_index", methods={"GET"})
     */
    public function index(RoleRepository $roleRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $roleRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/team/role/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_team_role_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $role = new Role();
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($role);
            $entityManager->flush();

            return $this->redirectToRoute('admin_team_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/team/role/new.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_team_role_show", methods={"GET"})
     */
    public function show(Role $role): Response
    {
        return $this->render('admin/team/role/show.html.twig', [
            'role' => $role,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_team_role_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Role $role): Response
    {
        $form = $this->createForm(RoleType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_team_role_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/team/role/edit.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_team_role_delete", methods={"POST"})
     */
    public function delete(Request $request, Role $role): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($role);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_team_role_index', [], Response::HTTP_SEE_OTHER);
    }
}
