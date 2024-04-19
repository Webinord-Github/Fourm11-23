<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotsController extends Controller
{
    public function robots()
    {
        $allowedPages = [
            '/la-fourmiliere',
            '/lexique',
            '/forum',
            '/boite-a-outils',
            '/evenements',
            '/blogue',
            '/saviez-vous',
            "/lintimidation",
            "/les-membres",
            '/sources'
        ];

        $output = "User-agent: *\n";

        foreach ($allowedPages as $page) {
            $output .= "Allow: $page\n";
        }

        $output .= "Disallow: /\n";

        return response($output, 200)->header('Content-Type', 'text/plain');
    }
}
