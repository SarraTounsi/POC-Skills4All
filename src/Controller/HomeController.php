<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Category;

use App\Form\CarByCategoryType;
use App\Form\CarType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CarSearchType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class HomeController extends AbstractController
{
 
    /**
     * @Route("/home", name="home")
     */
    public function search(Request $request,EntityManagerInterface $entityManager, PaginatorInterface $paginator)
    {

        $searchForm = $this->createForm(CarSearchType::class);
        $searchForm->handleRequest($request);

        $categoryForm = $this->createForm(CarByCategoryType::class);
        $categoryForm->handleRequest($request);

        $cars = $entityManager
        ->getRepository(Car::class)
        ->findAll();
      
        if ($categoryForm->isSubmitted() && $categoryForm->isValid()) {
            $category = $categoryForm->get('category')->getData();

        
            $cars=$entityManager
            ->getRepository(Car::class)
            ->findBy(['category' => $category]);
            $pagination = $paginator->paginate(
                $cars,
                $request->query->getInt('page', 1), 
                20
            );
            return $this->render('home.html.twig', [
                'searchForm' => $searchForm->createView(),
                'categoryForm' => $categoryForm->createView(),
                'pagination' => $pagination,
            ]);
        }

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchTerm = $searchForm->get('search')->getData();

        
            $cars=$entityManager
            ->getRepository(Car::class)
            ->findBy(['name' => $searchTerm]);
            $pagination = $paginator->paginate(
                $cars,
                $request->query->getInt('page', 1), 
                20
            );
            return $this->render('home.html.twig', [
                'searchForm' => $searchForm->createView(),
                'categoryForm' => $categoryForm->createView(),
                'pagination' => $pagination,
            ]);
        }
        $pagination = $paginator->paginate(
            $cars,
            $request->query->getInt('page', 1), 
            20
        );
        return $this->render('home.html.twig', [
            'searchForm' => $searchForm->createView(),
            'categoryForm' => $categoryForm->createView(),
            'pagination' => $pagination,

        ]);
    }
}
