<?php

namespace App\DataFixtures;

use App\Entity\Ticket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Etat;
use App\Entity\Categorie;
use App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class AppFixtures extends Fixture
{

  public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {

        $etatNouveau = [];    
        $etats = ['Nouveau','Ouvert','Résolu','Fermé'];
        
        foreach($etats as $nom){

        $etat = new Etat();
        $etat->setNom($nom);
        $manager->persist($etat);

        if($nom === 'Nouveau'){
            
            $etatNouveau[] = $etat;
        }



        }
    
        $categoriePanne = [];
        $categorieInformation = [];

        
        $categories = ['Incident','Panne','Evolution','Anomalie','Information'];
        
    
        foreach($categories as $nom){

        $categorie = new Categorie();
        $categorie->setNom($nom);
        $manager->persist($categorie);

        if ($nom === 'Panne') {
        
         $categoriePanne[] = $categorie;
        }

        if ($nom === 'Information') {
        $categorieInformation[] = $categorie;
    }

        }

    

        $admin = new Users();
        $admin->setEmail("admin@agence.fr");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'AdMiN@1')
        );

        $employe = new Users();
        $employe->setEmail("employe@agence.fr");
        $employe->setRoles(["ROLE_USER"]);
        $employe->setPassword(
            $this->passwordHasher->hashPassword($employe, 'EmPlOyE@1')
        );


        $employe2 = new Users();
        $employe2->setEmail("employe2@agence.fr");
        $employe2->setRoles(["ROLE_USER"]);
        $employe2->setPassword(
            $this->passwordHasher->hashPassword($employe2, 'EmPlOyE@2')
        );



        $ticket1 = new Ticket();
        $ticket1->setAuteur("yakoub@gmail.com");
        $ticket1->setDescription("comment connecter a mon espace client");
        $ticket1->setCategorie($categoriePanne[0]);
        $ticket1->setEtat($etatNouveau[0]);

        



        $ticket2 = new Ticket();
        $ticket2->setAuteur("youyou@gmail.com");
        $ticket2->setDescription("Je souhaite obtenir des informations concernant les horaires d'ouverture du service informatique.");
        $ticket2->setCategorie($categorieInformation[0]);
        $ticket2->setEtat($etatNouveau[0]);

    


       
       $manager->persist($ticket1);
       $manager->persist($ticket2);
       $manager->persist($admin);
       $manager->persist($employe);
       $manager->persist($employe2);
       
        $manager->flush();
    }
}
