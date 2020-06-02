<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoderInterface)
    {
        $this->passwordEncoder = $userPasswordEncoderInterface;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $user = new User();
        $user->setEmail('aka@aka.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'aka12345'
            ))
            ->setNom('Akane');
        
            $manager->persist($user);

        $restaurant = new Restaurant();
        $restaurant->setNom("Mac Do")
                    ->setType("fast-food")
                    ->setAdresse("5 rue du moulin")
                    ->setDescription("Fast food le plus répandu et culte.")
                    ->setImage("https://dirigeants-entreprise.com/images/t5714-800-800-80.jpg")
                    ->setEmail('macdo@gmail.com')
                    ->setIdRestaurateur(3);

            $manager->persist($restaurant);

        $restaurant = new Restaurant();
        $restaurant->setNom("Mister Tacos")
                    ->setType("Tacos/Kebab")
                    ->setAdresse("7 rue du moulin")
                    ->setDescription("Envie d’un bon tacos? Commandez chez le meilleur Tacos de la région.")
                    ->setImage("https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcQs3kFgbE5PGGVYq6LdCLxevkinZu59QZdVAGbs2h8lgAlePUbe")
                    ->setEmail('tacos@gmail.com')
                    ->setIdRestaurateur(4);

            $manager->persist($restaurant);
        
        $restaurant = new Restaurant();
        $restaurant->setNom("Sushi Wok")
                    ->setType("Asiatique")
                    ->setAdresse("2 rue du moulin")
                    ->setDescription("Spécialités asiatiques")
                    ->setImage("https://www.nippon.com/fr/ncommon/contents/japan-data/174999/174999.jpg")
                    ->setEmail('sushi@gmail.com')
                    ->setIdRestaurateur(5);

            $manager->persist($restaurant);
        
        $manager->flush();
    }
}
