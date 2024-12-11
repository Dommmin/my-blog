<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = 50;

        $output = new ConsoleOutput();

        $progressBar = new ProgressBar($output, $count);
        $progressBar->setBarWidth(50);
        $progressBar->start();

        for ($i = 0; $i < $count; $i++) {
            $imageUrl = 'https://picsum.photos/640/480';
            $imageName = 'images/'.Str::random(10).'.jpg';

            Storage::disk('public')->put($imageName, file_get_contents($imageUrl));

            Post::factory()->create([
                'image' => $imageName,
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();

        $output->writeln('');
        $output->writeln('Proces zakończony!');
    }
}
