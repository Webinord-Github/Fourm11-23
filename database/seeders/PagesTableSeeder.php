<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Page;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // find user admin with id of 1
        $admin = User::find(1);

        Page::truncate();

        // create many pages
      
           $accueil = new Page([
                'title' => 'Accueil',
                'url' => '/',
                'content' => null,
                'meta_title' => 'Accueil',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
           ]);
            $devenirmembre = new Page([
                'title' => 'Devenir membre',
                'url' => '/sinscrire',
                'content' => null,
                'meta_title' => 'Devenir membre',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $lafourmiliere = new Page([
                'title' => 'La Fourmilière',
                'url' => '/la-fourmiliere',
                'content' => null,
                'meta_title' => 'La Fourmilière',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $lexique = new Page([
                'title' => 'Lexique',
                'url' => '/lexique',
                'content' => null,
                'meta_title' => 'Lexique',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $forum = new Page([
                'title' => 'Forum',
                'url' => '/forum',
                'content' => null,
                'meta_title' => 'Forum',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $boiteaoutils = new Page([
                'title' => 'Boîte à outils',
                'url' => '/boite-a-outils',
                'content' => null,
                'meta_title' => 'Boîte à outils',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $evenements = new Page([
                'title' => 'Événements',
                'url' => '/evenements',
                'content' => null,
                'meta_title' => 'Événements',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $blogue = new Page([
                'title' => 'Blogue',
                'url' => '/blogue',
                'content' => null,
                'meta_title' => 'Blogue',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $saviezvous = new Page([
                'title' => 'Saviez-vous?',
                'url' => '/saviez-vous',
                'content' => null,
                'meta_title' => 'Saviez-vous?',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $lintimidation = new Page([
                'title' => "L'intimidation",
                'url' => '/lintimidation',
                'content' => null,
                'meta_title' => "L'intimidation",
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $lesmembres = new Page([
                'title' => 'Les membres',
                'url' => '/les-membres',
                'content' => null,
                'meta_title' => 'Les membres',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            $sources = new Page([
                'title' => 'Sources',
                'url' => '/sources',
                'content' => null,
                'meta_title' => 'Sources',
                'meta_desc' => "L'objectif de la plateforme est d'offrir un espace d'échange sur les pratiques de prévention et de lutte à l'intimidation. Tou·tes professionnel·les et...",
                'categorie' => 1
            ]);
            

            $admin->pages()->saveMany([
                $accueil,
                $devenirmembre,
                $lafourmiliere,
                $lexique,
                $forum,
                $boiteaoutils,
                $evenements,
                $blogue,
                $saviezvous,
                $lintimidation,
                $lesmembres,
                $sources,
            ]);
    }
}
