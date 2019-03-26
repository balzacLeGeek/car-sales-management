<?php

namespace App\Controller;

use App\Repository\VenteRepository;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Fusioncharts\FusionCharts;

class ChartController extends AbstractController
{
    /**
     * @Route("/chart/{id_vente}/{id}", name="chart_vente")
     */
    public function chart(Request $request, ClientRepository $clientRepository, VenteRepository $venteRepository, $id_vente, $id)
    {
        $ventes = $venteRepository->findBy(['client'=>$clientRepository->find($id)->getId(), 'id'=>$id_vente]);

        $client = [];
        if ($ventes != null) {
            $client = $ventes[0]->getClient();

            $voiture = $ventes[0]->getVoiture();
            $quantite = $ventes[0]->getQuantite();
            $prixUnit = $voiture->getPrixUnitaire();
            $montant = $quantite * $prixUnit;
        }

        // $Chart = new FusionCharts("column2d", "MyFirstChart" , "700", "400", "chart-container", "json", $jsonEncodedData);

        $chart = [
            "chart" => [
                "caption"=> "Market Share of Web Servers",
                "plottooltext"=> "<b>percentValue</b> of web servers run on label servers",
                "showlegend"=> "1",
                "showpercentvalues"=> "1",
                "legendposition"=> "bottom",
                "usedataplotcolorforlabels"=> "1",
                "theme"=> "fusion"
            ],
            "data" => [
                [
                    "label" => "Apache",
                    "value" => "32647479"
                ],
                [
                    "label" => "Microsoft",
                    "value" => "22100932"
                ],
                [
                    "label" => "Zeus",
                    "value" => "14376"
                ],
                [
                    "label" => "Other",
                    "value" => "18674221"
                ],
            ]
        ];

        $columnChart = new FusionCharts("pie2d", "ex1", "100%", 400, "chart-1", "json", json_encode($chart));
        $chart = $columnChart->render();
        
        return $this->render('chart/index.html.twig', [
            'ventes' => $ventes,
            'client' => $client,
            'id_vente' => $id_vente,
            'client_id' => $id,
            'chart' => $chart,
        ]);
    }
}
