<?php

namespace App\Controller;

use App\Data\Search;
use App\Entity\Shift;
use App\Entity\Employe;
use App\Form\CheckDeleteBoxType;
use App\Form\NewEmployeType;
use App\Form\SearchType;
use App\Repository\EmployeRepository;
use App\Repository\ShiftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function Symfony\Component\Clock\now;

/**
 * @method employeRepository(string $class)
 * @property $em
 */
class ManagerController extends AbstractController
{

    #[Route('/manager', name: 'app_manager')]
    #[isGranted('ROLE_ADMIN')]
    public function index(EmployeRepository $employeRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $search->page = $request->query->getInt('page', 1);
            $employe = $employeRepository->findSearch($search);


            return $this->render('manager/home_manager.html.twig', [
                'employe' => $employe,
                'form' => $form->createView(),
            ]);
        }

        $employe = $employeRepository->findAll();

        return $this->render('manager/home_manager.html.twig', [
            'employe' => $employe,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/manager/delete/{id}', name: 'app.manager.delete', methods: 'GET')]
    #[isGranted('ROLE_ADMIN')]
    public function deleteEmploye(EntityManagerInterface $em, Employe $employe ): Response
    {

        $em->remove($employe);
        $em->flush();


        return $this->redirectToRoute('app_manager');
    }

    /**
     */
    #[Route('/manager/all', name: 'app.manager.show.all')]
    #[isGranted('ROLE_ADMIN')]
    public function showAll(ManagerRegistry $doctrine, Request $request, PaginatorInterface $paginator, ShiftRepository $shiftRepository, EmployeRepository $employeRepository): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);

        $l = $shiftRepository->findAll();
        $ss = $paginator->paginate(
            $l,
            $request->query->getInt('page',1),
            9
        );

        if($form->isSubmitted() && $form->isValid()){
            $search->page = $request->query->getInt('page',1);
            $shift = $shiftRepository->findSearch($search);



            return $this->render('manager/index.html.twig', [
                'shift' => $shift,
                'form' => $form->createView(),
                'shifts'=>$ss,
            ]);
        }

        return $this->render('manager/index.html.twig', [
            'shift' => $shiftRepository->findAll(),
            'form' => $form->createView(),
            'selection' => $form->createView(),
            'shifts'=>$ss
        ]);
    }
    #[Route('/manager/shifts/remove', name: 'app.manager.shifts.remove')]
    public function remove(Request $request, ManagerRegistry $doctrine, ShiftRepository $shiftRepository) : Response
    {
        $items = $_POST['shifts'];
        $em = $doctrine->getManager();

        if(isset($items)){
            $ids = $items;
            $ids = $shiftRepository->findBy(['id' => $ids]);


        foreach ($ids as $id) {
                $shift = $em->getRepository(Shift::class)->find($id);
                $em->remove($shift);
        }

        }

        $em->flush();
        return $this->redirectToRoute('app.manager.show.all');

    }

    #[Route('/manager/shift/{nom}', name: 'app.manager.show', methods: 'GET')]
    #[isGranted('ROLE_ADMIN')]
    public function show(ManagerRegistry $doctrine, Request $request, ShiftRepository $shiftRepository,): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        $nom = $request->get('nom');
        $repository = $doctrine->getRepository(Employe::class);
        $employe = $repository->findOneBy((['nom' => $nom]));

        if($form->isSubmitted() && $form->isValid()){
            $search->page = $request->query->getInt('page', 1);
            $shift = $shiftRepository->findSearch($search);


            return $this->render('shift/shift_employe.html.twig', [
                'shift' => $shift,
                'employe' => $repository->findOneBy((['nom' => $nom])),
                'form' => $form->createView(),
            ]);
        }

        return $this->render('shift/shift_employe.html.twig', [
            'shift' => $employe->getShift(),
            'employe' => $repository->findOneBy((['nom' => $nom])),
            'form' => $form->createView()
        ]);
    }

    #[Route('/manager/delete-shift/{shift}', name: 'app.manager.shift.delete', methods: 'GET')]
    #[isGranted('ROLE_ADMIN')]
    public function delete(ManagerRegistry $doctrine, Shift $shift): Response
    {
        $em = $doctrine->getManager();
        $em->remove($shift);
        $em->flush();


        return $this->redirectToRoute('app.manager.show.all');
    }


    #[Route('/manager/nouveau-employe', name:'app.employe.new')]
    #[isGranted('ROLE_ADMIN')]
    public function addEmploye(Request $request, EntityManagerInterface $entityManager): Response
    {
        $employe = new Employe();

        $form = $this->createForm(NewEmployeType::class,$employe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $employe->setCreatedAt(now());
            $entityManager->persist($employe);
            $entityManager->flush();

            $this->addFlash('success', 'Merci! Votre formulaire a été bien soumis');
            $this->redirectToRoute('app_manager');

        }

        return $this->render('manager/new_employe.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/navebar', name:'app.navabar')]
    public function navbar(): Response{
        return $this->render('navbar.html.twig');
    }

}
