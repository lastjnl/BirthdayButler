<?php

// src/Controller/AdminController.php
namespace App\Controller;

use App\Entity\Drink;
use App\Form\DrinkType;
use App\Repository\DrinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'admin_dashboard')]
    public function index(DrinkRepository $drinkRepository): Response
    {

        $drinks = $drinkRepository->findAll();

        return $this->render('admin/index.html.twig', [
            'drinks' => $drinks,
        ]);
    }

    #[Route('/admin/drink/new', name: 'admin_drink_new')]
    #[Route('/admin/drink/{id}/edit', name: 'admin_drink_edit')]
    public function form(Request $request, EntityManagerInterface $em, Drink $drink = null): Response
    {

        if (!$drink) {
            $drink = new Drink();
        }

        $form = $this->createForm(DrinkType::class, $drink);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($drink);
            $em->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/form.html.twig', [
            'form' => $form->createView(),
            'edit' => $drink->getId() !== null,
        ]);
    }

    #[Route('/admin/drink/{id}/delete', name: 'admin_drink_delete')]
    public function delete(EntityManagerInterface $em, Drink $drink): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $em->remove($drink);
        $em->flush();

        return $this->redirectToRoute('admin_dashboard');
    }
}
