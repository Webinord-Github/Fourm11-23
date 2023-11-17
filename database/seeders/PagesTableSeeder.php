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
                'categorie' => 1
           ]);
            $devenirmembre = new Page([
                'title' => 'Devenir membre',
                'url' => 'sinscre',
                'content' => null,
                'categorie' => 1
            ]);
            $lafourmiliere = new Page([
                'title' => 'La Fourmilière',
                'url' => 'la-fourmiliere',
                'content' => null,
                'categorie' => 1
            ]);
            $lexique = new Page([
                'title' => 'Lexique',
                'url' => 'lexique',
                'content' => null,
                'categorie' => 1
            ]);
            $forum = new Page([
                'title' => 'Forum',
                'url' => 'forum',
                'content' => null,
                'categorie' => 1
            ]);
            $boiteaoutils = new Page([
                'title' => 'Boîte à outils',
                'url' => 'boite-a-outils',
                'content' => null,
                'categorie' => 1
            ]);
            $evenements = new Page([
                'title' => 'Événements',
                'url' => 'evenements',
                'content' => null,
                'categorie' => 1
            ]);
            $blogue = new Page([
                'title' => 'Blogue',
                'url' => 'blogue',
                'content' => null,
                'categorie' => 1
            ]);
            $saviezvous = new Page([
                'title' => 'Saviez-vous?',
                'url' => 'saviez-vous',
                'content' => null,
                'categorie' => 1
            ]);
            $lintimidation = new Page([
                'title' => "L'intimidation",
                'url' => 'lintimidation',
                'content' => null,
                'categorie' => 1
            ]);
            $lesmembres = new Page([
                'title' => 'Les membres',
                'url' => 'les-membres',
                'content' => null,
                'categorie' => 1
            ]);
            $sources = new Page([
                'title' => 'Sources',
                'url' => 'sources',
                'content' => null,
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
