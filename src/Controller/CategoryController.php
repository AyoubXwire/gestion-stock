<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{
    /**
     * @Route("/categories", name="category_index")
     */
    public function index(CategoryRepository $repo)
    {
        $categories = $repo->findAll();

        return $this->render('category/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categories/new", name="category_new")
     * @Route("/categories/{id}/edit", name="category_edit")
     */
    public function form(Request $request, Category $category = null, ObjectManager $manager)
    {
        if(!$category)
        {
            $category = new Category();
        }

        $categoryForm = $this->createForm(CategoryType::class, $category);

        $categoryForm->handleRequest($request);

        if ($categoryForm->isSubmitted() && $categoryForm->isValid())
        {
            $manager->persist($category);
            $manager->flush();

            return $this->redirectToRoute('category_show', ['id' => $category->getId()]);
        }

        return $this->render('category/form.html.twig', [
            'categoryForm' => $categoryForm->createView()
        ]);
    }

    /**
     * @Route("/categories/{id}/delete", name="category_delete")
     */
    public function delete(Category $category, ObjectManager $manager)
    {
        $manager->remove($category);
        $manager->flush();

        return $this->redirectToRoute('category_index');
    }

    /**
     * @Route("/categories/{id}", name="category_show")
     */
    public function show(Category $category)
    {
        return $this->render('category/show.html.twig', [
            'category' => $category
        ]);
    }
}
