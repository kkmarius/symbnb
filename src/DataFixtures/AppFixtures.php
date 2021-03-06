<?php

namespace App\DataFixtures;

use App\Entity\Ad;
use Faker\Factory;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr-FR');
        
        // $product = new Product();
        for($i=1; $i<=30; $i++){
            $ad = new Ad();

            $title = $faker->sentence();
            $coverImage = $faker->imageUrl(1000,350);
            $introduction = $faker->paragraph(2);
            $content = '<p>' . $faker->paragraph(5). '</p>'.'<p>' . $faker->paragraph(5). '</p>'.'<p>' . $faker->paragraph(5). '</p>'.'<p>' . $faker->paragraph(5). '</p>'.'<p>' . $faker->paragraph(5). '</p>';



            $ad->setTitle($title)
                ->setCoverImage($coverImage)
                ->setIntroduction($introduction)
                ->setContent($content)
                ->setPrice(mt_rand(40,200))
                ->setRooms(mt_rand(1,5));

            for ($j=1; $j <= mt_rand(2,5); $j++) { 
                $image = new Image();
                
                $image->setUrl($faker->imageUrl())
                        ->setCaption($faker->sentence())
                        ->setAd($ad);
                $manager->persist($image);
            }

            
            // $manager->persist($product);
            $manager->persist($ad);
        }
        
        $manager->flush();
    }
}
