<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    #[Route('/order', name: 'order_drink', methods: ['POST'])]
    public function order(Request $request): Response
    {
        $drinkName = $request->request->get('drink_name');
        // Process the order (e.g., save to database, send notification, etc.)
        
        // Redirect back to homepage with a success message
        $this->addFlash('success', 'Your order for ' . $drinkName . ' has been placed successfully!');
        return $this->redirectToRoute('home');
    }
}
