<?php

namespace App\Controller;

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
}
