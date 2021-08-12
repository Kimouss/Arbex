<?php

namespace App\Controller\Admin\Team;

use App\Controller\ArbexAbstractController;
use App\Entity\Team\Member;
use App\Form\Team\MemberType;
use App\Repository\Team\MemberRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/team/member")
 */
class MemberController extends ArbexAbstractController
{
    /**
     * @Route("/", name="admin_team_member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $memberRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/team/member/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/new", name="admin_team_member_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('admin_team_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/team/member/new.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_team_member_show", methods={"GET"})
     */
    public function show(Member $member): Response
    {
        return $this->render('admin/team/member/show.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_team_member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Member $member): Response
    {
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_team_member_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/team/member/edit.html.twig', [
            'member' => $member,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_team_member_delete", methods={"POST"})
     */
    public function delete(Request $request, Member $member): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_team_member_index', [], Response::HTTP_SEE_OTHER);
    }
}
