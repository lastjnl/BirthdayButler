<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ButlerController extends AbstractController

{
    #[Route('/', 'home')]
    public function startServing(): Response
    {

        $drinks = [
            ['name' => 'Coca Cola', 'price' => 3.00],
            ['name' => 'Orange Juice', 'price' => 2.50],
            ['name' => 'Beer', 'price' => 4.00],
            ['name' => 'Wine', 'price' => 5.50],
        ];

        return $this->render('butler.html.twig',[
            'drinks' => $drinks
        ]);
    }
}