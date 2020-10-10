<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Showcase
{
    public function showData()
    {
        return new Response(
            '<html><body>Hello World!</body></html>'
        );
    }
}