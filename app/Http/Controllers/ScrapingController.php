<?php

namespace App\Http\Controllers;

use Symfony\Component\Panther\PantherTestCase;
use App\Models\Game;

class ScrapingController extends Controller
{
    public function scrapeGames()
    {
        $client = PantherTestCase::createPantherClient();

        // Define the website to scrape
        $url = 'https://www.crazygames.com/'; // Replace with an actual games website
        $crawler = $client->request('GET', $url);

        // Scrape game details
        $crawler->filter('.game-item')->each(function ($node) {
            $title = $node->filter('.title')->text();
            $link = $node->filter('a')->attr('href');
            $description = $node->filter('.description')->text();

            // Save games to the database
            Game::create([
                'title' => $title,
                'link' => $link,
                'description' => $description,
            ]);
        });

        return response()->json(['message' => 'Games scraping completed!']);
    }
}

