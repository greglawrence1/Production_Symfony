<?php
// src/DataFixtures/ProductDataFixture.php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductDataFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Create sample products
        $productsData = [
            ['name' => 'Chalk Ball', 'price' => 1999, 'brand' => 'Decathlon'],
            ['name' => 'Running Shoes', 'price' => 2999, 'brand' => 'Nike'],
            ['name' => 'Yoga Mat', 'price' => 2499, 'brand' => 'Adidas'],
        ];

        foreach ($productsData as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setPrice($data['price']);
            $product->setBrand($data['brand']);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
