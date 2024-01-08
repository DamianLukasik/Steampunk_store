<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductMaterial;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'product', methods: ['GET'])]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'product_show')]
    public function show(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);        
        $materials = $this->entityManager->getRepository(ProductMaterial::class)->findBy(['product' => $product]);

        if (!$product) {
            throw $this->createNotFoundException('Produkt o podanym ID nie istnieje.');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'materials' => $materials,
        ]);
    }
}
