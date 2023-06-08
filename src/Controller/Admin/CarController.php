<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Form\CarByCategoryType;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CarSearchType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cars")
 */
class CarController extends AbstractController
{
    /**
     * @Route("/", name="app_car_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        
        $cars = $entityManager
            ->getRepository(Car::class)
            ->findAll();

        return $this->render('car/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    /**
     * @Route("/new", name="app_car_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($car);
            $entityManager->flush();

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_car_show", methods={"GET"})
     */
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_car_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_car_delete", methods={"POST"})
     */
    public function delete(Request $request, Car $car, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $car->getId(), $request->request->get('_token'))) {
            $entityManager->remove($car);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/cars/search", name="car_search")
     */
    public function search(Request $request,EntityManagerInterface $entityManager)
    {

        $form = $this->createForm(CarSearchType::class);
        $form->handleRequest($request);

        $form2 = $this->createForm(CarByCategoryType::class);
        $form2->handleRequest($request);

        $allCars = $entityManager
        ->getRepository(Car::class)
        ->findAll();
      
        if ($form2->isSubmitted() && $form2->isValid()) {
            $category = $form2->get('category')->getData();

            //$cars = $this->getDoctrine()->getRepository(Car::class)->findBy(['name' => $searchTerm]);
        
            $cars=$entityManager
            ->getRepository(Car::class)
            ->findBy(['category' => $category]);

            return $this->render('car/index.html.twig', [
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'cars' => $cars,
            ]);
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->get('search')->getData();

            //$cars = $this->getDoctrine()->getRepository(Car::class)->findBy(['name' => $searchTerm]);
        
            $cars=$entityManager
            ->getRepository(Car::class)
            ->findBy(['name' => $searchTerm]);

            return $this->render('car/index.html.twig', [
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'cars' => $cars,
            ]);
        }
        return $this->render('car/index.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'cars' => $allCars,
        ]);
    }
}
