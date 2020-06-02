<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande/restaurateur/{id}", name="commandeRestaurateur")
     */
    public function restaurateurCommandeDone(
        CommandeRepository $commandeRepository,
        $id
    )
    {
        $commande = $commandeRepository->findOneBy(['id' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $commande->setStatut('En livraison');
        $entityManager->persist($commande);
        $entityManager->flush();
        return $this->render('commande/restaurateur.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }


    /**
     * @Route("/commande/livreur/{id}", name="commandeFinis")
     */
    public function livreurCommandeDone(
        CommandeRepository $commandeRepository,
        $id
    )
    {
        $commande = $commandeRepository->findOneBy(['id' => $id]);
        $entityManager = $this->getDoctrine()->getManager();
        $commande->setStatut('Terminé');
        $entityManager->persist($commande);
        $entityManager->flush();
        return $this->render('commande/livreur.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }
}
