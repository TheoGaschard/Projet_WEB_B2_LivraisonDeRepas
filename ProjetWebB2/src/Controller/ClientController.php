<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use App\Service\Panier\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }


    /**
     * @Route("/client/{id}/restaurant", name="restaurant", methods={"GET"})
     */
    public function restaurant(PlatRepository $platRepository,
     Restaurant $restaurant,
     PanierService $panierService): Response
    {




        return $this->render('client/restaurant.html.twig', [
            'restaurant' => $restaurant,
            'plats' => $platRepository->findby([
                        'idRestaurant' => $restaurant->getId()
        ]),
            "items" => $panierService->getAll(),
            "total" => $panierService->getTotal()
            ]);
    }


    /**
     * @Route("/client/{id}/restaurant/ajouter/{idPlat}", name="panier_add")
     * @Entity("plat", expr="repository.find(idPlat)")
     */
    public function add($idPlat, PanierService $panierService,Restaurant $restaurant)
    {
        $panierService->add($idPlat);

        return $this->redirectToRoute("restaurant",[
        'restaurant' => $restaurant,
        'id' => $restaurant->getId()
        ]);
    }

    /**
     * @Route("/client/{id}/restaurant//supprimer/{idPlat}", name="panier_remove")
     * @Entity("plat", expr="repository.find(idPlat)")
     */
    public function remove($idPlat, PanierService $panierService,Restaurant $restaurant)
    {
        $panierService->remove($idPlat);

        return $this->redirectToRoute('restaurant',[
            'restaurant' => $restaurant,
            'id' => $restaurant->getId()
            ]);
    }


}
