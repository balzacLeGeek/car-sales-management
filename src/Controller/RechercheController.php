<?php

namespace App\Controller;

use App\Form\ChiffreAffaireType;
use App\Repository\VenteRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/recherche")
 */
class RechercheController extends AbstractController
{
    /**
     * @Route("/", name="recherche")
     */
    public function index(ClientRepository $clientRepository)
    {
        $form = $this->createForm(ChiffreAffaireType::class);

        return $this->render('recherche/index.html.twig', [
            'form' => $form->createView(),
            'ventes' => [],
        ]);
    }

    /**
     * @Route("/date/{id}", name="recherche_date", methods="POST")
     */
    public function search(ClientRepository $clientRepository, VenteRepository $venteRepository, Request $request, $id)
    {;
        if ($request->isXmlHttpRequest()) {
            $ventes = $venteRepository->findBy(['client'=>$clientRepository->find($id)->getId()]);
        
            $client = [];

            if ($ventes != null) {
                $client = $ventes[0]->getClient();

                $voiture = $ventes[0]->getVoiture();
                $prixUnit = $voiture->getPrixUnitaire();
                $quantite = $ventes[0]->getQuantite();
                $montant = $quantite * $prixUnit;

                $html = $this->renderView('recherche/result.html.twig', [
                    'ventes' => $ventes,
                    'client' => $client,
                ]);
            }
            else {
                $html = $this->renderView('recherche/result.html.twig', [
                    'ventes' => [],
                    'client' => [],
                ]);
            }

            return new Response($html);
        }
    }
}
