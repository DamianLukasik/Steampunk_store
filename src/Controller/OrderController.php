<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\OrderCalculator;

class OrderController extends AbstractController
{   
    private EntityManagerInterface $entityManager;
    private OrderCalculator $orderCalculator;

    public function __construct(EntityManagerInterface $entityManager, OrderCalculator $orderCalculator)
    {
        $this->entityManager = $entityManager;
        $this->orderCalculator = $orderCalculator;
    }

    #[Route('/orders', name: 'orders', methods: ['GET'])]
    public function index(): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findAll();

        return $this->render('order/index.html.twig', [
            'orders' => $orders,
        ]);
    }

    #[Route('/create_order', name: 'create_order', methods: ['POST'])]
    public function createOrder(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $order = new Order();
        foreach ($data as $item) {
            $product = $this->entityManager->getRepository(Product::class)->find($item['productId']);
            if ($product) {
                $orderItem = new OrderItem($order, $product, $item['quantity']);
                $order->addOrderItem($orderItem);
            }
            $this->calculationPricesAndTaxesOrder($order);
        }

        try {
            $this->entityManager->persist($order);
            $this->entityManager->flush();
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => 'Order created failed'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
            
        return new JsonResponse([
            'message' => 'Order created successfully',
            'order' => $this->normalizeOrder($order)
        ], Response::HTTP_OK);
    }

    #[Route('/get_order', name: 'get_order', methods: ['POST'])]
    public function getOrder(int $orderId): Response
    {
        if (empty($orderId)) {
            return new JsonResponse([
                'message' => 'Order Id is empty'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        $order = $this->entityManager->getRepository(Order::class)->find($orderId);

        if (empty($order)) {
            return new JsonResponse([
                'message' => 'Order is not exist'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse(['order' => $this->normalizeOrder($order)]);
    }

    private function normalizeOrder(Order $order): array
    {
        $normalizedOrder = [
            'id' => $order->getId(),
            'subtotal' => $order->getSubtotal(),
            'vat' => $order->getVat(),
            'total' => $order->getTotal(),
            'orderItems' => [],
        ];

        foreach ($order->getOrderItems() as $orderItem) {
            $normalizedOrder['orderItems'][] = [
                'productId' => $orderItem->getProduct()->getId(),
                'productName' => $orderItem->getProduct()->getName(),
                'productPrice' => $orderItem->getProduct()->getPrice(),
                'productProducer' => $orderItem->getProduct()->getProducer()->getName(),
                'quantity' => $orderItem->getQuantity(),
            ];
        }

        return $normalizedOrder;
    }

    private function calculationPricesAndTaxesOrder(Order $order): void
    {
        $result = $this->orderCalculator->calculateOrderTotal($order->getOrderItems());
    
        $order->setSubtotal($result['subtotal']);
        $order->setVat($result['vat']);
        $order->setTotal($result['total']);
        
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }    
}
