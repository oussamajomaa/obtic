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
            $projets = $repo->findByPostCategory(100, 'projet');
            $developpements = $repo->findByPostCategory(100, 'developpement');
            $actualites = $repo->findByPostCategory(100, 'actualite');
            return $this->render('home/adminpage.html.twig',[
                'projets'           => $projets,
                'developpements'    => $developpements,
                'actualites'       => $actualites,
            ]);
        } else {
            $recentPost=$repo->findByPostCategory(3,'actualite');
            $projets = $repo->findByPostCategory(3, 'projet');
            $developpements = $repo->findByPostCategory(3, 'developpement');
            $actualites = $repo->findByPostCategory(3, 'actualite');
            return $this->render('home/homepage.html.twig', [
                'projets'           => $projets,
                'developpements'    => $developpements,
                'actualites'        => $actualites,
                'countProjet'       => count($repo->findByCategory('projet')),
                'countDeveloppement'       => count($repo->findByCategory('developpement')),
                'countActualite'       => count($repo->findByCategory('actualite')),
                'recentPost'            => $recentPost[0]
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
