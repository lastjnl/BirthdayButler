<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Repository\DrinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ButlerController extends AbstractController

{
    #[Route('/', 'home')]
    public function startServing(DrinkRepository $drinkRepository): Response
    {
        return $this->render('home.html.twig');
    }

    public function browseMenu(DrinkRepository $drinkRepository): Response
    {
        $drinks = $drinkRepository->findAll();

        return $this->render('butler.html.twig',[
            'drinks' => $drinks
        ]);
    }
}