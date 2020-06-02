<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AdminController as BaseAdminController;


class AdminController extends BaseAdminController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboard(
        RestaurantRepository $restaurantRepository,
        CommandeRepository $commandeRepository
    )
    {
        $restaurants = $restaurantRepository->findAll();
        $revenus = 2.5 * sizeof($commandeRepository->findby([
            'statut' => "Terminé"
    ]));

        return $this->render('admin/index.html.twig', [
            'restaurants' => sizeof($restaurants),
            'commandePasse' => sizeof($commandeRepository->findAll()),
            'commandeCours' => sizeof($commandeRepository->findby([
                'statut' => "En préparation"
        ])),
            'commandeFinis' => sizeof($commandeRepository->findby([
                'statut' => "Terminé"
        ])),
            'revenus' => $revenus,
        ]);
    }
}
