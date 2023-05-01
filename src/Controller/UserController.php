<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Car;

#[Route('/home')]
class UserController extends AbstractController
{
    
    #[Route('', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home_page', ['page' => 1]);
    }

    #[Route('/{page}', name: 'app_home_page', requirements: ['page' => '\d+'])]
    public function index_page($page, EntityManagerInterface $entityManager): Response
    {
        $cars = $entityManager->getRepository(Car::class)->findByAvailable(true);

        $pages = count($cars) / 5;
        if(intval($pages) != $pages) $pages = intval($pages) + 1;

        if($page <= 0) $page = 1;
        else if($page > $pages) $page = $pages;

        
        $page_cars = array_slice($cars, ($page-1)*5, 5);

        return $this->render('user/index.html.twig', [
            'name' => $this->getUser()->getName(),
            'page' => $page,
            'pages' => $pages,
            'page_cars' => $page_cars,
        ]);
    }

    #[Route('/{page}/{action}', name: 'app_home_action', requirements: ['id' => '\d+', 'action' => 'previous|next'])]
    public function action($page, $action, Request $request, EntityManagerInterface $entityManager): Response
    {
        $cars = $entityManager->getRepository(Car::class)->findByAvailable(true);

        $pages = count($cars) / 5;
        if(intval($pages) != $pages) $pages = intval($pages) + 1;

        if($action == "next")$page += 1;
        else if($action == "previous")$page -= 1;
        if($page <= 0) $page = 1;
        else if($page > $pages) $page = $pages;

        
        $page_cars = array_slice($cars, ($page-1)*5, 5);
        
            
        return $this->render('home/index.html.twig', [
            'name' => $this->getUser()->getName(),
            'page' => $page,
            'pages' => $pages,
            'page_songs' => $page_songs,
        ]);
    }
}
