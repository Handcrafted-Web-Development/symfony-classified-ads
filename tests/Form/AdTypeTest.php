<?php

namespace App\Tests\Form;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class AdTypeTest extends WebTestCase
{
    public function testFormAd(): void
    {
        $client = static::createClient();

        $formData = [
            'form[title]' => 'iPhone X en parfait état, à vendre à un bon prix !',
            'form[description]' => 'Un iPhone X, comme neuf, avec une capacité de 64 Go, aucune rayure ni problème. Livré avec un étui de protection en cuir.',
            'form[price]' => 350,
            'form[year]' => 2017,
            'form[size]' => 6,
            'form[brand]' => 'Apple',
            'form[dueDate]' => date('Y-m-d'),
            'form[guarantee]' => 'Garantie 6 mois',
        ];

        $crawler = $client->request('GET', '/ad');

        $form = $crawler->selectButton('Create Ad')->form();
        $client->submit($form, $formData);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
