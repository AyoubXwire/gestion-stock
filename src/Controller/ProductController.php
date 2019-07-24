<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use Doctrine\Common\Persistence\ObjectManager;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @Route("/products", name="product_index")
     */
    public function index(ProductRepository $repo)
    {
        $products = $repo->findAll();

        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/products/new", name="product_new")
     * @Route("/products/{id}/edit", name="product_edit")
     */
    public function form(Request $request, Product $product = null, ObjectManager $manager)
    {
        if(!$product)
        {
            $product = new Product();
        }

        $productForm = $this->createForm(ProductType::class, $product);

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid())
        {
            $manager->persist($product);
            $manager->flush();

            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        return $this->render('product/form.html.twig', [
            'productForm' => $productForm->createView(),
            'editMode' => $product->getId() !== null
        ]);
    }

    /**
     * @Route("/products/{id}/delete", name="product_delete")
     */
    public function delete(Product $product, ObjectManager $manager)
    {
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('product_index');
    }

    /**
     * @Route("/products/{id}", name="product_show")
     */
    public function show(Product $product)
    {
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
