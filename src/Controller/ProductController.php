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

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager, string $name, int $price, string $brand): Response
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);
        $product->setBrand($brand);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
    #[Route('/create-multiple-products')]
    public function createMultipleProducts(EntityManagerInterface $entityManager): Response
{
    $this->createProduct($entityManager, 'Chalk Ball', 1999, 'Decathlon');
    $this->createProduct($entityManager, 'Running Shoes', 2999, 'Nike');
    $this->createProduct($entityManager, 'Yoga Mat', 2499, 'Adidas');

    return new Response('Multiple products created successfully.');
}
  
    public function show(EntityManagerInterface $entityManager, int $id): Response
    {
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        //return new Response('Check out this great product: '.$product->getName());

            return $this->render('product/product-card.html.twig', [
            'product' => $product,]);
        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
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
        ]);
    }

}