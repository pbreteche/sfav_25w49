<?php

declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/');

        // Validate a successful response and some content
        self::assertResponseIsSuccessful();
        self::assertSelectorTextContains('h1', 'Hello world!');

        $this->assertGreaterThan(0, $crawler->filter('html:contains("Hello world")')->count());
        $client->followRedirects(false);

        // La suite n'est pas fonctionnelle ici car nous avons utilisé un Live Component
        // pour traiter les données du formulaire
        // Le contrôleur ne tient pas compte des données transmises en POST
        $form = $crawler->selectButton('Enregistrer')->form();
        $input = ['post[body]' => 'body value'];
        $client->submit($form, $input);
        self::assertResponseIsUnprocessable();

        $form = $crawler->selectButton('Enregistrer')->form();
        $input['post[title]'] = 'title value';
        $client->submit($form, $input);
        self::assertResponseIsSuccessful();
    }
}
