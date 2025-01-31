<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeType;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecipeController extends AbstractController
{
    #[Route('/recipes', name: 'app_recipeAll')]
    public function index(RecipeRepository $recipeRepository): Response
    {

        $recipes = $recipeRepository->findAll();
        // dd($recipes);


        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

  #[Route('/recipe/create', name: 'app_recipe_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {

        $recipe = new Recipe();
        $recipeform = $this->createForm(RecipeType::class, $recipe);
        $recipeform->handleRequest($request);

        if($recipeform->isSubmitted() && $recipeform->isValid()) {
            // dd($recipe);
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_recipeAll');
        }

        return $this->render('recipe/create.html.twig', [
            'recipeform' => $recipeform->createView(),
        ]);
    }

    #[Route('/recipes/{id}', name: 'app_recipe')]
    public function show(int $id, RecipeRepository $recipeRepository): Response
    {

        $recipe = $recipeRepository->find($id);


        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    // #[Route('/recipes/{slug}/show', name: 'app_recipe_name')], ou enlever le s de recipe et pas besoin de /show
    #[Route('/recipes/{slug}/show', name: 'app_recipe_name')]
    public function showName(string $slug, RecipeRepository $recipeRepository): Response
    {

        $recipe = $recipeRepository->findOneBy(['slug' => $slug]);



        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    #[Route('/recipes/{id}/delete', name: 'app_recipe_delete')]
    public function delete(int $id, RecipeRepository $recipeRepository, EntityManagerInterface $entityManager): Response
    {

        $recipe = $recipeRepository->find($id);

        $entityManager->remove($recipe);
        $entityManager->flush();

        return $this->redirectToRoute('app_recipeAll');
    }


    #[Route('/recipe/update/{id}', name: 'app_recipe_update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager, RecipeRepository $recipeRepository): Response
    {

        $recipe = $recipeRepository->find($id);

        $recipeform = $this->createForm(RecipeType::class, $recipe);
        $recipeform->handleRequest($request);

        if($recipeform->isSubmitted() && $recipeform->isValid()) {
            // dd($recipe);
            $entityManager->persist($recipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_recipeAll');
        }

        return $this->render('recipe/update.html.twig', [
            'recipeform' => $recipeform,
            'recipe' => $recipe,
        ]);
    }

  
}
