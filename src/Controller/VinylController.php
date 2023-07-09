<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController
{
    /**
     * @return Response
     */
    #[Route('/')]
    public function homepage(): Response
    {
        return new Response('Title: best!!', 200);
    }

    /**
     * @param Request $request
     * @param string|null $slug
     * @return Response
     */
    #[Route('/browse/{slug}')]
    public function browse(Request $request, string $slug = null): Response
    {
        if ($slug) {
            $title = 'Genres: '.u(str_replace('-', ' ', $slug))->title(true);
        } else {
            $title = 'All Genres';
        }

        return new Response( $title, 200);
    }
}