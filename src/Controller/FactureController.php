<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Services\ChiffreLettre;
use App\Form\ChiffreAffaireType;
use App\Repository\VenteRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/", name="facture_index")
     */
    public function index(ClientRepository $clientRepository)
    {
        $form = $this->createForm(ChiffreAffaireType::class);

        return $this->render('facture/index.html.twig', [
            'form' => $form->createView(),
            'ventes' => [],
        ]);
    }

    /**
     * @Route("/{id_vente}/{id}", name="facture_client", methods="POST|GET")
     */
    public function clientFacture(Request $request, ClientRepository $clientRepository, VenteRepository $venteRepository, $id_vente, $id)
    {
        $chiffreLettre = new ChiffreLettre;
        $form = $this->createForm(ChiffreAffaireType::class);
        $ventes = $venteRepository->findBy(['client'=>$clientRepository->find($id)->getId(), 'id'=>$id_vente]);

        $client = [];
        $montantLettre = '';
        if ($ventes != null) {
            $client = $ventes[0]->getClient();

            $voiture = $ventes[0]->getVoiture();
            $quantite = $ventes[0]->getQuantite();
            $prixUnit = $voiture->getPrixUnitaire();
            $montant = $quantite * $prixUnit;

            $montantLettre = ucwords(str_replace(' zero', '', $chiffreLettre->convert($montant))) . ' Ariary';
        }

        dump($ventes);
        
        if ($request->isXmlHttpRequest()) {

            $html = $this->renderView('facture/ajax.html.twig', [
                'ventes' => $ventes,
                'client' => $client,
                'montantLettre' => $montantLettre,
            ]);

            return new Response($html);
        }
        
        return $this->render('facture/index.html.twig', [
            'form' => $form->createView(),
            'ventes' => $ventes,
            'client' => $client,
            'montantLettre' => $montantLettre,
            'id_vente' => $id_vente,
            'client_id' => $id,
        ]);
    }

    /**
     * @Route("/pdf/{id_vente}/{id}", name="facture_pdf")
     */
    public function clientFacturePdf(Request $request, ClientRepository $clientRepository, VenteRepository $venteRepository, $id_vente, $id)
    {
        $chiffreLettre = new ChiffreLettre;
        $form = $this->createForm(ChiffreAffaireType::class);
        $ventes = $venteRepository->findBy(['client'=>$clientRepository->find($id)->getId(), 'id'=>$id_vente]);

        $client = [];
        $montantLettre = '';
        if ($ventes != null) {
            $client = $ventes[0]->getClient();

            $voiture = $ventes[0]->getVoiture();
            $quantite = $ventes[0]->getQuantite();
            $prixUnit = $voiture->getPrixUnitaire();
            $montant = $quantite * $prixUnit;

            $montantLettre = ucwords(str_replace(' zero', '', $chiffreLettre->convert($montant))) . ' Ariary';
        }
        
        return $this->render('facture/pdf.html.twig', [
            'form' => $form->createView(),
            'ventes' => $ventes,
            'client' => $client,
            'montantLettre' => $montantLettre,
            'id_vente' => $id_vente,
            'client_id' => $id,
        ]);
    }
}

