<?php


namespace App\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArbexAbstractController extends AbstractController
{
    public EntityManagerInterface $entityManager;
    public PaginatorInterface $paginator;

    public function __construct(EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {

        $this->entityManager = $entityManager;
        $this->paginator = $paginator;
    }
}
