<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Reference;
use App\Entity\Item;
use App\Entity\Outfit;
use App\Entity\DressHistory;
use App\Entity\SuggestionIA;
use App\Entity\Notification;
use App\Entity\SocialInteraction;
use App\Enum\GenderStatus;
use App\Enum\HeightStatus;
use App\Enum\MorphologyStatus;
use App\Enum\WeightStatus;

class AppFixtures extends Fixture
{

    public const MAX_USERS = 10;
    public const MAX_REFERENCES = 20;
    public const MAX_ITEMS = 30;
    public const MAX_OUTFITS = 15;
    public const MAX_NOTIFICATIONS = 25;
    public const MAX_SOCIAL_INTERACTIONS = 20;

    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        $users = [];
        $categories = [];
        $references = [];
        $outfits = [];
        $items = [];

        $this->createUsers($manager, $users);
        $this->createCategories($manager, $categories);
        $this->createReferences($manager, $references, $categories);
        $this->createItems($manager, $items, $users, $categories);
        $this->createOutfits($manager, $outfits, $items);
/*        $this->createDressHistories($manager, $users, $items);*/
        $this->createSuggestionIAs($manager, $users, $outfits);
        $this->createNotifications($manager, $users);
/*        $this->createSocialInteractions($manager, $users, $items);*/

        $manager->flush();
    }

    protected function createUsers(ObjectManager $manager, array &$users): void
    {
        for ($i = 0; $i < self::MAX_USERS; $i++) {
            $user = new User();
            $user->setEmail("user{$i}@example.com");
            $user->setName("User {$i}");
            $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
            $user->setRoles(['ROLE_USER']);
            $user->setGender(GenderStatus::MALE);
            $user->setHeight(HeightStatus::H150);
            $user->setWeight(WeightStatus::W70);
            $user->setMorphology(MorphologyStatus::H);
            $user->setGender(GenderStatus::MALE);
            $user->setCreatedAt(new \DateTimeImmutable());
            $users[] = $user;

            $manager->persist($user);
        }
    }

    protected function createCategories(ObjectManager $manager, array &$categories): void
    {
        $categoryNames = ['Casual', 'Sport', 'Chic', 'Business', 'Streetwear'];

        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setName($name);
            $categories[] = $category;

            $manager->persist($category);
        }
    }

    protected function createReferences(ObjectManager $manager, array &$references, array &$categories): void
    {
        for ($i = 0; $i < self::MAX_REFERENCES; $i++) {
            $reference = new Reference();
            $reference->setName("Reference {$i}");
            $reference->setCategory($categories[array_rand($categories)]);
            $reference->setMarque("Marque {$i}");
            $reference->setPrice("{$i}0");
            $reference->setPartnerLink("https://www.pull-in.com/fr_ue/pantalon-homme-dening-classic-fade-dng-classicfade.html?gad_source=1&gclid=CjwKCAiAw5W-BhAhEiwApv4goKwthgulYi7AlRv6nUwR1vCD124mQ-SxJHPUToAsl-76v8NQAQGBFhoCwLkQAvD_BwE");
            $reference->setCategory($categories[array_rand($categories)]);
            $reference->setCreatedAt(new \DateTimeImmutable());
            $references[] = $reference;

            $manager->persist($reference);
        }
    }

    protected function createItems(ObjectManager $manager, array &$items, array &$users, array &$categories): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::MAX_ITEMS; $i++) {
            $item = new Item();
            $item->setName("Item {$i}");
            $item->setDescription("Description {$i}");
            $item->setPicture("https://m.media-amazon.com/images/I/61eX8xQulLL._AC_SX679_.jpg");
            $item->setCreatedAt(new \DateTimeImmutable());
            $item->setUser($users[array_rand($users)]);
            $item->setCategory($categories[array_rand($categories)]);
            $items[] = $item;

            $manager->persist($item);
        }
    }

    protected function createOutfits(ObjectManager $manager, array &$outfits, array &$items): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::MAX_OUTFITS; $i++) {
            $outfit = new Outfit();
            $outfit->setName("Outfit " . ($i + 1));
            $outfits[] = $outfit;

            $manager->persist($outfit);
        }
    }

    // Historique des vêtements portés
    /*protected function createDressHistories(ObjectManager $manager, array &$users, array &$items): void
    {
        $faker = Factory::create();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 5); $i++) {
                $dressHistory = new DressHistory();
                $dressHistory->setUser($user);
                $dressHistory->setItem($items[array_rand($items)]);
                $dressHistory->setConsultationDate(new \DateTimeImmutable());
                $manager->persist($dressHistory);
            }
        }
    }*/


    // Suggestions de l'IA
    protected function createSuggestionIAs(ObjectManager $manager, array &$users, array &$outfits): void
    {
        $faker = Factory::create();

        foreach ($users as $user) {
            for ($i = 0; $i < rand(1, 3); $i++) {
                $suggestion = new SuggestionIA();
                $suggestion->setUser($user);
                $suggestion->setOutfit($outfits[array_rand($outfits)]);
                $suggestion->setCreatedAt(new \DateTimeImmutable());
                $manager->persist($suggestion);
            }
        }
    }

    // Notifications des utilisateurs
    protected function createNotifications(ObjectManager $manager, array &$users): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < self::MAX_NOTIFICATIONS; $i++) {
            $notification = new Notification();
            $notification->setContent($faker->sentence);
            $notification->setUser($users[array_rand($users)]);
            $notification->setSendDate(new \DateTimeImmutable());
            $manager->persist($notification);
        }
    }

    // Interactions sociales sur les items
//    protected function createSocialInteractions(ObjectManager $manager, array &$users, array &$items): void
//    {
//        $faker = Factory::create();
//
//        for ($i = 0; $i < self::MAX_SOCIAL_INTERACTIONS; $i++) {
//            $socialInteraction = new SocialInteraction();
//            $socialInteraction->setUser($users[array_rand($users)]);
//            $socialInteraction->setItem($items[array_rand($items)]);
//            $socialInteraction->setTypeInteraction('like');
//            $socialInteraction->setContent($faker->sentence);
//            $socialInteraction->setCreatedAt($faker->dateTimeThisYear());
//            $manager->persist($socialInteraction);
//        }
//    }
}