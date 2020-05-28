<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\PlatCommande;
use App\Entity\Quantity;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\PlatCommandeType;
use App\Form\UserType;
use App\Repository\CommandeRepository;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use App\Service\Panier\PanierService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(RestaurantRepository $restaurantRepository,
    PanierService $panierService): Response
    {
        $panierService->removeAll();

        return $this->render('client/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
        ]);
    }


    /**
     * @Route("/{id}/edit", name="client_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,User $user ): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('client');
        }

        return $this->render('client/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
          


    /**
     * @Route("/client/{id}/restaurant", name="restaurant", methods={"GET","POST"})
     */
    public function restaurant(PlatRepository $platRepository,
     Restaurant $restaurant,
     PanierService $panierService,
     Request $request,
     UserInterface $user): Response
    {

        $platCommande = new PlatCommande();
        $form = $this->createForm(PlatCommandeType::class, $platCommande);
        $form->handleRequest($request);
        

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            $commande = new Commande();
            $commande->setFrais(2.5);
            $commande->setPrix($panierService->getTotal()+ $commande->getFrais());
            $commande->setAdresseLivraison($user->getAddresse());
            $commande->setVilleLivraison($user->getVille());
            $commande->setDate(new DateTime('+ 2 hour'));
            $commande->setDateLivraison(new DateTime('+ 3 hour'));
            $commande->setStatut("En Cours");
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($commande);
    
            // actually executes the queries (i.e. the INSERT query)
            $panier = $panierService->getAll();
            for ($i = 1; $i < count($panier) ; $i++) {
          
            $platc = new PlatCommande();
            $platc->setPlat($panier[$i]['plat']);
            $platc->setQuantite($panier[$i]['quantity']);
            $platc->setCommande($commande);
          
            $entityManager->persist($platc);
              }



            $entityManager = $this->getDoctrine()->getManager();
            $platCommande->setCommande($commande);
            $platCommande->setPlat($panier[0]['plat']);
            $entityManager->persist($platCommande);
            $entityManager->flush();

            return $this->redirectToRoute('commande', [
                'restaurant' => $restaurant,
                "items" => $panierService->getAll(),
                "total" => $panierService->getTotal(),
                'id' => $restaurant->getId(),
                'idCommande' => $commande->getId(),
                ]);
        }


        return $this->render('client/restaurant.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
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
    public function add($idPlat, PanierService $panierService,Restaurant $restaurant,Request $request)
    {
        $panierService->add($idPlat,$request);



        return $this->redirectToRoute('restaurant',[
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


    /**
     * @Route("/client/{id}/commande/{idCommande}", name="commande", methods={"GET"})
     * @Entity("commande", expr="repository.find(idCommande)")
     */
    public function commande(
     Restaurant $restaurant,
     PanierService $panierService,
     CommandeRepository $commandeRepository,
     Commande $commande,
     $idCommande): Response
    {
        $commande = $commandeRepository->findOneBy(['id' => $idCommande]);
        $entityManager = $this->getDoctrine()->getManager();
        $commande->setDate(new DateTime('+ 2 hour'));
        $commande->setDateLivraison(new DateTime('+ 3 hour'));
        $entityManager->persist($commande);
        $entityManager->flush();

        return $this->render('client/commande.html.twig', [
            'restaurant' => $restaurant,
            "total" => $panierService->getTotal(),
            "itemes" => $panierService->getAll(),
            'idCommande' => $idCommande,
            'commandes' => $commandeRepository->findOneBy([
            'id' => $idCommande,
])
    ]);
    }

    /**
     * @Route("/client/{id}/commande/{idCommande}/success", name="success", methods={"GET"})
     * @Entity("commande", expr="repository.find(idCommande)")
     */
    public function success(
        Restaurant $restaurant,
        PanierService $panierService,
        CommandeRepository $commandeRepository,
        Commande $commande,
        $idCommande,
        UserInterface $user,
        \Swift_Mailer $mailer): Response
       {

        $commande = $commandeRepository->findOneBy(['id' => $idCommande]);
        $entityManager = $this->getDoctrine()->getManager();
        $commande->setStatut("En préparation");
        $entityManager->persist($commande);
        $entityManager->flush();



    $factureClient = (new \Swift_Message('Votre facture du site EatHome !'))
    ->setFrom("soranyuxe@gmail.com")
    ->setTo("soranyuxe@gmail.com")
    // Pour des raisons de simplicités les mails seront envoyés dans ma propre boîte mail
    // car les mails des fixtures ne seront pas forcément les notres et on pourra pas voir 

    // ->setTo($user->getUsername())
    ->setBody(
        $this->renderView(
            'email/client.html.twig',
            [
                'restaurant' => $restaurant,
                "total" => $panierService->getTotal(),
                "itemes" => $panierService->getAll(),
                'commandes' => $commandeRepository->findOneBy([
                'id' => $idCommande,
        ])
            ]),

        'text/html'
    )
;

    $commandeRestaurateur = (new \Swift_Message('Votre commande à effectuer du site EatHome !'))
    ->setFrom("soranyuxe@gmail.com")
    ->setTo("soranyuxe@gmail.com")
    // Pour des raisons de simplicités les mails seront envoyés dans ma propre boîte mail
    // car les mails des fixtures ne seront pas forcément les notres et on pourra pas voir

    // ->setTo($restaurant->getEmail())
    ->setBody(
        $this->renderView(
            'email/restaurant.html.twig',
            [
                'restaurant' => $restaurant,
                "total" => $panierService->getTotal(),
                "itemes" => $panierService->getAll(),
                'commandes' => $commandeRepository->findOneBy([
                'id' => $idCommande,
        ])
            ]),

        'text/html'
    )
    ;

    $livreur = (new \Swift_Message('Nouvelle commande en approche !'))
    ->setFrom("soranyuxe@gmail.com")
    ->setTo("soranyuxe@gmail.com")
    // Pour des raisons de simplicités les mails seront envoyés dans ma propre boîte mail
    // car les mails des fixtures ne seront pas forcément les notres et on pourra pas voir
    // pour le livreur on suppose que notre entreprise dispose d'une section spécialisée
    // pour la livraison et qu'il renvoit le mail au livreur le plus proche du restaurant

    ->setBody(
        $this->renderView(
            'email/livreur.html.twig',
            [
                'restaurant' => $restaurant,
                "total" => $panierService->getTotal(),
                "itemes" => $panierService->getAll(),
                'commandes' => $commandeRepository->findOneBy([
                'id' => $idCommande,
        ])
            ]),

        'text/html'
    )
;

$mailer->send($factureClient);
$mailer->send($commandeRestaurateur);
$mailer->send($livreur);

return $this->render('client/success.html.twig');


}
}
