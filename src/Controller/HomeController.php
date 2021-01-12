<?php

namespace App\Controller;

use App\Repository\PostRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $repo): Response
    {
        if ($this->getUser()) {
            $projets = $repo->findByProjet(100);
            $developpements = $repo->findByDeveloppement(100);
            $partenaires = $repo->findByPartenaire();
            return $this->render('home/adminpage.html.twig',[
                'projets'           => $projets,
                'developpements'    => $developpements,
                'partenaires'       => $partenaires,
            ]);
        } else {
            $projets = $repo->findByProjet(3);
            $developpements = $repo->findByDeveloppement(3);
            $partenaires = $repo->findByPartenaire();
            return $this->render('home/homepage.html.twig', [
                'projets'           => $projets,
                'developpements'    => $developpements,
                'partenaires'       => $partenaires,
            ]);
        }
    }

    /**
     * @Route("/show_projet{row}", name="show_projet")
     */
    public function show_projet(PostRepository $repo, $row): Response
    {
        $posts = $repo->findByProjet($row);
        return $this->render('home/show_projet.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/show_developpement{row}", name="show_developpement")
     */
    public function show_developpement(PostRepository $repo, $row): Response
    {
        $posts = $repo->findByDeveloppement($row);
        return $this->render('home/show_developpement.html.twig', [
            'posts' => $posts
        ]);
    }
}