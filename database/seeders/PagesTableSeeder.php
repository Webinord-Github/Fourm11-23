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
      
           $about = new Page([
                'title' => 'About',
                'url' => 'about',
                'content' => 'This is about us.',
                'categorie' => '2'
           ]);
            $contact = new Page([
                'title' => 'Contact',
                'url' => 'contact',
                'content' => 'You can contact us.',
                'categorie' => '2'
            ]);
            $faq = new Page([
                'title' => 'FAQ',
                'url' => 'another-page',
                'content' => 'This is another page.',
                'categorie' => '2'
            ]);
        

            $admin->pages()->saveMany([
                $about,
                $contact,
                $faq,
            ]);
    }
}
