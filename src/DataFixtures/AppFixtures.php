<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// use App\Entity\VinylMix;
use App\Factory\VinylMixFactory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        VinylMixFactory::createMany(70);
        $manager->flush();

        // $genres = ['pop', 'rock'];

        // $mix = new VinylMix();
        // $mix->setTitle('Do you Remember... Phil Collins?!');
        // $mix->setDescription('A pure mix of drummers turned singers!');
        // $mix->setGenre($genres[array_rand($genres)]);
        // $mix->setTrackCount(rand(5, 20));
        // $mix->setVotes(rand(-50, 50));
        
        // $manager->persist($mix);
        // $manager->flush();
    }
}
