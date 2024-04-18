<?php
// src/Controller/ProductController.php
namespace App\Controller;

// ...
use App\Entity\Product;
use App\Form\ProductCreateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager, string $name, int $price, string $brand): Response
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setBrand($brand);

        $entityManager->persist($product);

        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
  
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }
     
            return $this->render('product/product-card.html.twig', [
            'product' => $product,]);
    }  
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductCreateType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/product-form-create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, EntityManagerInterface $entityManager, Product $product): Response
    {
        $form = $this->createForm(ProductCreateType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/product-form-update.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    public function delete(Request $request, EntityManagerInterface $entityManager, Product $product): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();

        
        return $this->redirectToRoute('home');
    }

    public function listProducts(EntityManagerInterface $entityManager): Response
    {
        $products = $entityManager->getRepository(Product::class)->findAll();

        return $this->render('product/all-products.html.twig', [
            'products' => $products,
        ]);
    }

    public function bouldering(): Response
    {
        return $this->render('home/bouldering.html.twig');
    }

    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }
    public function team(): Response
    {
        return $this->render('home/team.html.twig');
    }
    public function wall(): Response
    {
        return $this->render('home/wall.html.twig');
    }
}
