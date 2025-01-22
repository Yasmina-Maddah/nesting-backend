<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;
use Symfony\Component\Panther\Client;

class ScrapeGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:games';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape game titles and images from PlayHop';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting the scraping process...');

        // Create a Panther client
        $client = Client::createChromeClient(base_path('drivers/chromedriver.exe'));

        try {
            // Open the target website
            $crawler = $client->request('GET', 'https://playhop.com/');

            // Extract game titles and images
            $games = $crawler->filter('li.grid-list__game-item')->each(function ($node) {
                return [
                    'title' => $node->filter('span.game-card__title')->text(),
                    'image' => $node->filter('img.game-image')->attr('src'),
                    'link' => $node->filter('a.game-url')->attr('href'), // Update selector for the link
                ];
            });
            
            // Save games to the database
            foreach ($games as $game) {
                $this->info("Scraped Game: {$game['title']} | Image: {$game['image']} | Link: {$game['link']}");
            
                Game::updateOrCreate(
                    ['title' => $game['title']],
                    ['image' => $game['image'], 'link' => $game['link']]
                );
            }
            

            $this->info('Scraping process completed successfully.');
        } catch (\Exception $e) {
            $this->error('Error occurred during scraping: ' . $e->getMessage());
        }
    }
}
