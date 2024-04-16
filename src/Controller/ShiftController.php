<?php

namespace App\Controller;

use App\Entity\Shift;
use App\Form\ShiftType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Clock\now;

class ShiftController extends AbstractController
{
    #[Route('/shift', name: 'app_shift',)]
    #[isGranted('ROLE_USER')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $shift = new Shift();

        $form = $this->createForm(ShiftType::class,$shift);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $sommeHeures = $shift->calculHeuresNormales();
            $shift->setNombreTotalHeures($sommeHeures);
            $shift->setCreatedAt(now());
            $entityManager->persist($shift);
            $entityManager->flush();

            $this->addFlash('success', 'Merci! Votre formulaire a été bien soumis');
            $this->redirectToRoute('app_shift');

        }

        //dd($shift);

        return $this->render('shift/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
