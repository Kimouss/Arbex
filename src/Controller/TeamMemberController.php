<?php

namespace App\Controller;

use App\Entity\Team\Member;
use App\Repository\Team\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team_member")
 */
class TeamMemberController extends AbstractController
{
    /**
     * @Route("/", name="team_member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository): Response
    {
        $members = $memberRepository->getOrderByPosition();
        $result = [];
        foreach ($members as $member) {
            /** @var Member $member */
            $result[$member->getHierarchy()->getName()][] = $member;
        }

        return $this->render('about/team_member/index.html.twig', [
            'members' => $result,
        ]);
    }
}
