<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ChiffreAffaireType;
use App\Repository\VenteRepository;
use App\Repository\ClientRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/chiffre-affaire")
 */
class ChiffreAffaireController extends Controller
{
    /**
     * @Route("/", name="chiffre_affaire_index")
     */
    public function index(ClientRepository $clientRepository)
    {
        $form = $this->createForm(ChiffreAffaireType::class);

        return $this->render('chiffre_affaire/index.html.twig', [
            'form' => $form->createView(),
            'ventes' => [],
        ]);
    }

    /**
     * @Route("/{id}", name="chiffre_affaire", methods="POST|GET")
     */
    public function clientChiffreAffaire(Request $request, ClientRepository $clientRepository, VenteRepository $venteRepository, $id)
    {
        $form = $this->createForm(ChiffreAffaireType::class);
        $ventes = $venteRepository->findBy(['client'=>$clientRepository->find($id)->getId()]);

        $client = $ventes[0]->getClient();
        
        if ($request->isXmlHttpRequest()) {

            $html = $this->renderView('chiffre_affaire/ajax.html.twig', [
                'ventes' => $ventes,
                'client' => $client,
            ]);

            return new Response($html);
        }
        
        return $this->render('chiffre_affaire/index.html.twig', [
            'form' => $form->createView(),
            'ventes' => $ventes,
            'client' => $client,
        ]);
    }
}
