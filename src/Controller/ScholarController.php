<?php

namespace App\Controller;

use App\Entity\User\User;
use App\Form\User\UserSearchType;
use App\Repository\User\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/scholar_database")
 */
class ScholarController extends ArbexAbstractController
{
    /**
     * @Route("/search", name="scholar_database_search", methods={"GET"})
     */
    public function search(UserRepository $userRepository, Request $request): Response
    {
        $searchForm = $this->createForm(UserSearchType::class);
        $query = $userRepository->getAllQuery();

        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted()) {
            $query = $userRepository->getAllQuery();
        }

        $pagination = $this->paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
        );

        return $this->render('scholar/scholar_search/index.html.twig', [
            'pagination' => $pagination,
            'search_form' => $searchForm->createView(),
        ]);
    }

    /**
     * @Route("/list", name="scholar_database_list", methods={"GET"})
     */
    public function list(UserRepository $userRepository, Request $request): Response
    {
        $pagination = $this->paginator->paginate(
            $userRepository->getAllQuery(),
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10),
        );

        return $this->render('scholar/scholar_list/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/user/{id}/research", name="scholar_database_user_research", methods={"GET"})
     */
    public function research(User $user): Response
    {
        return $this->render('scholar/user/tabs/research.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/biography", name="scholar_database_user_biography", methods={"GET"})
     */
    public function biography(User $user): Response
    {
        return $this->render('scholar/user/tabs/biography.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/education", name="scholar_database_user_education", methods={"GET"})
     */
    public function education(User $user): Response
    {
        return $this->render('scholar/user/tabs/education.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/{id}/mentorship", name="scholar_database_user_mentorship", methods={"GET"})
     */
    public function mentorship(User $user): Response
    {
        return $this->render('scholar/user/tabs/mentorship.html.twig', [
            'user' => $user,
        ]);
    }
}
