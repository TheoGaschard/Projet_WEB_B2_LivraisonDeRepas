<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RestaurateurController extends AbstractController
{
    /**
     * @Route("/restaurateur", name="restaurateur")
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurateur/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }
}
