<?php

namespace App\Service\Panier;

use App\Repository\PlatRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService
{

    protected $session;
    protected $platRepository;

    public function __construct(SessionInterface $session, PlatRepository $platRepository)
    {
        $this->session = $session;
        $this->platRepository = $platRepository;
    }

    public function add(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (empty($panier[$id])) {
            $panier[$id] = 0;
        }

        $panier[$id]++;

        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getAll(): array
    {
        $panier = $this->session->get('panier', []);

        $panierWithData = [];

        foreach ($panier as $id => $quantity) {
            $panierWithData[] = [
                'plat' => $this->platRepository->find($id),
                'quantity' => $quantity
            ];
        }

        return $panierWithData;
    }

    public function getTotal(): float
    {
        $panierWithData = $this->getAll();

        $total = 0;

        foreach ($panierWithData as $couple) {
            $total += $couple['plat']->getPrix() * $couple['quantity'];
        }

        return $total;
    }
}