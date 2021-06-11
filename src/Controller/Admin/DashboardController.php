<?php

namespace App\Controller\Admin;

use App\Controller\ArbexAbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends ArbexAbstractController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    /**
     * @Route("/change_locale/{locale}", name="change_locale")
     */
    public function changeLocale(Request $request, $locale)
    {
        $request->getSession()->set('_locale', $locale);

        return $this->redirect($request->headers->get('referer'));
    }
}
