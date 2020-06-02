<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Entity\Restaurant;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

/**
 * @Route("/restaurateur/restaurant/{id}/plat")
 */
class PlatController extends AbstractController
{



    /**
     * @Route("/", name="plat_index", methods={"GET"})
     */
    public function index(PlatRepository $platRepository, Restaurant $restaurant): Response
    {
        return $this->render('plat/index.html.twig', [
            'restaurant' => $restaurant,
            'plats' => $platRepository->findby([
                        'idRestaurant' => $restaurant->getId()
        ])
            ]);
    }

    /**
     * @Route("/new", name="plat_new", methods={"GET","POST"})
     */
    public function new(Request $request, Restaurant $restaurant): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($plat);
            $entityManager->flush();

            return $this->redirectToRoute('plat_index', [
                'restaurant' => $restaurant,
                'id' => $restaurant->getId()
                ]);
        }

        return $this->render('plat/new.html.twig', [
            'plat' => $plat,
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPlat}", name="plat_show", methods={"GET"})
     * @Entity("plat", expr="repository.find(idPlat)")
     */
    public function show(Plat $plat, Restaurant $restaurant): Response
    {

        return $this->render('plat/show.html.twig', [
            'plat' => $plat,
            'restaurant' => $restaurant,
        ]);
    }


    // public function show(Plat $plat, Restaurant $restaurant): Response
    // {
    //     $name = $plat->getNom();
    //     $idRestaurant = $restaurant->getId();
    //     $repo = $this->getDoctrine()->getRepository(Plat::class);
    //     $plat = $repo->findOneBy([
    //         'nom' => $name,
    //         'idRestaurant' => $idRestaurant
    //     ]);
    //     return $this->render('plat/show.html.twig', [
    //         'plat' => $plat,
    //         'restaurant' => $restaurant,
    //     ]);
    // }

    /**
     * @Route("/{idPlat}/edit", name="plat_edit", methods={"GET","POST"})
     * @Entity("plat", expr="repository.find(idPlat)")
     */
    public function edit(Request $request, Plat $plat, Restaurant $restaurant): Response
    {
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plat_index', [
            'restaurant' => $restaurant,
            'id' => $restaurant->getId()
            ]);
        }

        return $this->render('plat/edit.html.twig', [
            'plat' => $plat,
            'restaurant' => $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPlat}", name="plat_delete", methods={"DELETE"})
     * @Entity("plat", expr="repository.find(idPlat)")
     */
    public function delete(Request $request, Plat $plat, Restaurant $restaurant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plat_index', [
            'restaurant' => $restaurant,
            'id' => $restaurant->getId()
            ]);
    }
}
