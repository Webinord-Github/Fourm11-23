<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AutomaticEmail;
class automatic_emails_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AutomaticEmail::truncate();
        $emailsData = [
            [
                'name' => 'new_user_to_user',
                'description' => 'Nouvel utilisateur -> Destinataire: Utilisateur',
                'content' => null,

            ],
            [
                'name' => 'new_user_to_admin',
                'description' => 'Nouvel utilisateur -> Destinataire: Admin',
                'content' => null,

            ],
            [
                'name' => 'positive_admission_to_user',
                'description' => 'Admission positive utilisateur -> Destinataire: Utilisateur',
                'content' => null,

            ],
            [
                'name' => 'negative_admission_to_user',
                'description' => 'Admission négative utilisateur -> Destinataire: Utilisateur',
                'content' => null,

            ],
            [
                'name' => 'welcome_to_user',
                'description' => 'Courriel de bienvenue -> Destinataire: Utilisateur',
                'content' => null,

            ],
            [
                'name' => 'report_to_user',
                'description' => 'Signalement -> Destinataire: Utilisateur qui signale',
                'content' => null,

            ],
            [
                'name' => 'positive_report_to_admin',
                'description' => 'Signalement -> Destinataire: Admin',
                'content' => null,

            ],
            [
                'name' => 'positive_report_to_user',
                'description' => 'Décision positive signalement -> Destinataire: Utilisateur impliqué',
                'content' => null,

            ],
            [
                'name' => 'negative_report_to_user',
                'description' => 'Décision négative signalement -> Destinataire: Utilisateur impliqué',
                'content' => null,

            ],
            [
                'name' => 'new_tool_to_admin',
                'description' => "Soumission d'un nouvel outil -> Destinataire: Admin",
                'content' => null,

            ],
            [
                'name' => 'new_blog_to_admin',
                'description' => "Soumission d'un nouvel article de blog -> Destinataire: Admin",
                'content' => null,

            ],
        ];
        AutomaticEmail::insert($emailsData);
    }
}
