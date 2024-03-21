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
                'content' => '1',

            ],
            [
                'name' => 'positive_admission_to_user',
                'description' => 'Admission positive utilisateur -> Destinataire: Utilisateur',
                'content' => '<h1>Bienvenue à La Fourmilière</h1>
                <p>La création de votre profil est finalisée. Vous faites maintenant partie de la communauté de La
                Fourmilière, bienvenue!</p>
                <p>Vous pouvez naviguer sur la plateforme, lire des contenus, partager votre expertise et tisser des
                liens avec des personnes qui comme vous, ont l’objectif de prévenir et de lutter contre
                l’intimidation dans leur milieu.</p>
                <p>Vous êtes encouragé·es à participer activement aux discussions et à poser des questions. C&#39;est
                en partageant vos connaissances et votre expertise que la plateforme pourra remplir son mandat
                de lutte contre l’intimidation tout en contribuant à l’amélioration continue des interventions dans
                ce domaine.</p>
                <p>Merci de votre engagement et de votre contribution envers cette cause importante. Ensemble,
                nous avons le pouvoir de créer des environnements plus sécuritaires et bienveillants, et ce, pour
                tou·tes.</p>
                <p>L’équipe de La Fourmilière.</p>',

            ],
            [
                'name' => 'negative_admission_to_user',
                'description' => 'Admission négative utilisateur -> Destinataire: Utilisateur',
                'content' => '3',

            ],
        
            [
                'name' => 'report_to_user',
                'description' => 'Signalement -> Destinataire: Utilisateur qui signale',
                'content' => '4',

            ],
            [
                'name' => 'negative_report_to_user',
                'description' => 'Décision négative signalement (message supprimé) -> Destinataire: Utilisateur impliqué',
                'content' => '5',

            ],

        ];
        AutomaticEmail::insert($emailsData);
    }
}
