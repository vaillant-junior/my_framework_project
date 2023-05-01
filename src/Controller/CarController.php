<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\RentFormType;
use App\Entity\Rent;


#[Route('/car')]
class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(): Response
    {
        $rent_car = $this->getUser()->getRents();

        return $this->render('car/index.html.twig', [
            "rent_car" => $rent_car
        ]);
    }

    #[Route('/car/{id}', name: 'app_car_detail', requirements: ['id' => '\d+'])]
    public function index_detail(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        $rent = new Rent();
        $form = $this->createForm(RentFormType::class, $rent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $car->setAvailable(false);
            $entityManager->persist($car);
            $entityManager->flush();

            $rent->setPrice($car->getPrice()*$rent->getDuration());
            $rent->setFinished(false);
            $rent->setUser($this->getUser());
            $rent->setCar($car);

            $entityManager->persist($rent);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_home_page', ['page' => 1]);
        }

        return $this->render('car/detail.html.twig', [
            'car' => $car,
            'rentForm' => $form->createView(),
        ]);
    }

}
