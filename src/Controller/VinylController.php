<?php

namespace App\Controller;

use App\Service\MixRepository;
use DateTime;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Symfony\Component\String\u;

class VinylController extends AbstractController
{
    /**
     * @param bool $isDebug
     * @param MixRepository $mixRepository
     */
    public function __construct(
        private bool $isDebug,
        private MixRepository $mixRepository
    )
    {
    }

    /**
     * @return Response
     */
    #[Route('/', name: 'app_homepage', methods: ['GET'])]
    public function homepage(): Response
    {
        $tracks = [
            ['song' => 'Gangsta\'s Paradise', 'artist' => 'Coolio'],
            ['song' => 'Waterfalls', 'artist' => 'TLC'],
            ['song' => 'Creep', 'artist' => 'Radiohead'],
            ['song' => 'Kiss from a Rose', 'artist' => 'Seal'],
            ['song' => 'On Bended Knee', 'artist' => 'Boyz II Men'],
            ['song' => 'Fantasy', 'artist' => 'Mariah Carey'],
        ];
        return $this->render('vinyl/homepage.html.twig', [
            'title' => 'PB & Jams',
            'tracks' => $tracks
        ]);
    }

    /**
     * @param string|null $slug
     * @return Response
     * @throws InvalidArgumentException
     */
    #[Route('/browse/{slug}', name: 'app_browse')]
    public function browse(string $slug = null): Response
    {
        dump($this->isDebug);
        $genre = $slug ? u(str_replace('-', ' ', $slug))->title(true) : null;
        $mixes = $this->mixRepository->findAll();

        return $this->render('vinyl/browse.html.twig', [
            'genre' => $genre,
            'mixes' => $mixes,
        ]);
    }

    /**
     * @return array[]
     */
    private function getMixes(): array
    {
        // temporary fake "mixes" data
        return [
            [
                'title' => 'PB & Jams',
                'trackCount' => 14,
                'genre' => 'Rock',
                'createdAt' => new DateTime('2021-10-02'),
            ],
            [
                'title' => 'Put a Hex on your Ex',
                'trackCount' => 8,
                'genre' => 'Heavy Metal',
                'createdAt' => new DateTime('2022-04-28'),
            ],
            [
                'title' => 'Spice Grills - Summer Tunes',
                'trackCount' => 10,
                'genre' => 'Pop',
                'createdAt' => new DateTime('2019-06-20'),
            ],
        ];
    }
}