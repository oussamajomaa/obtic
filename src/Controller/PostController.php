<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\CategoryType;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class PostController extends AbstractController
{


    /**
     * @Route("/add_post", name="add_post")
     */
    public function add_post(Request $request, EntityManagerInterface $manager): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class,$post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $post->setUser($this->getUser());
            $manager->persist($post);
            $manager->flush();
            $this->addFlash(
                'success', 
                "L'article' <strong>{$post->getTitle()}</strong> a été ajouté");
                return $this->redirectToRoute('home');
        }

        return $this->render('admin/post/add_post.html.twig', [
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/edit_post{id}", name="edit_post")
     */
    public function edit_post(Request $request, EntityManagerInterface $manager, Post $post): Response
    {
        $form = $this->createForm(PostType::class,$post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $post->setUser($this->getUser());
            $manager->persist($post);
            $manager->flush();
            $this->addFlash(
                'success', 
                "L'article' <strong>{$post->getTitle()}</strong> a été modifié");
                return $this->redirectToRoute('home');
        }

        return $this->render('admin/post/edit_post.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete_post{id}", name="delete_post")
     */
    public function delete_post(EntityManagerInterface $manager, Post $post)
    {
        $manager->remove($post);
        $manager->flush();
        $this->addFlash(
            'danger', 
            "L'article' <strong>{$post->getTitle()}</strong> a été supprimé");
            return $this->redirectToRoute('home');

    }


    /**
     * @Route("/add_category", name="add_category")
     */
    public function add_category(Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $manager->persist($category);
            $manager->flush();
            $this->addFlash(
                    'success', 
                    "La catégorie <strong>{$category->getName()}</strong> a été ajouté");
                    return $this->redirectToRoute('home');
        }

        return $this->render('admin/category/add_category.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
