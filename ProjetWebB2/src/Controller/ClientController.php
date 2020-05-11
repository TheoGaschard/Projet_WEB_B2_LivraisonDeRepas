<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    public function restaurant(PlatRepository $platRepository, Restaurant $restaurant): Response
    {
        return $this->render('client/restaurant.html.twig', [
            'restaurant' => $restaurant,
            'plats' => $platRepository->findby([
                        'idRestaurant' => $restaurant->getId()
        ])
            ]);
    }
}
