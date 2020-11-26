<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerControllerTest extends WebTestCase
{
    public function testGetAll(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/v1/customers');

        self::assertResponseStatusCodeSame(200);
    }

    public function testCreateWithoutData(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/customers');

        self::assertResponseStatusCodeSame(400);
    }

    public function testCreate(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/v1/customers', [
            'firstName' => 'TEST NAME',
            'lastName' => 'TEST LAST NAME',
            'birthDate' => '2001-01-01',
            'gender' => 0,
            'email' => 'c1@c2.com',
            'address' => 'My Address'
        ]);

        self::assertResponseStatusCodeSame(201);

        $content = self::getContent($client);

        self::assertEquals('TEST NAME', $content['firstName']);
        self::assertEquals('TEST LAST NAME', $content['lastName']);
        self::assertEquals('2001-01-01T00:00:00+03:00', $content['birthDate']);
        self::assertEquals(0, $content['gender']);
        self::assertEquals('c1@c2.com', $content['email']);
        self::assertEquals('My Address', $content['address']);
        self::assertCount(7, $content);
    }

    public function testUpdateWithoutData(): void
    {
        $client = static::createClient();
        $customer = self::getCustomer($client);
        $client->request('PUT', '/api/v1/customers/' . $customer['id']);

        self::assertResponseStatusCodeSame(400);
    }

    public function testUpdate(): void
    {
        $client = static::createClient();
        $customer = self::getCustomer($client);
        $client->request('PUT', '/api/v1/customers/' . $customer['id'], [
            'firstName' => 'TEST NAME',
            'lastName' => 'TEST LAST NAME',
            'birthDate' => '2001-01-01',
            'gender' => 0,
            'email' => 'c1@c2.com',
            'address' => 'My Address'
        ]);

        self::assertResponseStatusCodeSame(200);

        $content = self::getContent($client);

        self::assertEquals('TEST NAME', $content['firstName']);
        self::assertEquals('TEST LAST NAME', $content['lastName']);
        self::assertEquals('2001-01-01T00:00:00+03:00', $content['birthDate']);
        self::assertEquals(0, $content['gender']);
        self::assertEquals('c1@c2.com', $content['email']);
        self::assertEquals('My Address', $content['address']);
        self::assertCount(7, $content);
    }

    public function testRemove(): void
    {
        $client = static::createClient();
        $customer = self::getCustomer($client);
        $client->request('DELETE', '/api/v1/customers/' . $customer['id']);

        self::assertResponseStatusCodeSame(204);
    }


    private static function getCustomer(KernelBrowser $client)
    {
        $client->request('GET', '/api/v1/customers');
        $content = self::getContent($client);
        return $content['items'][0];
    }

    private static function getContent(KernelBrowser $client): array
    {
        return json_decode($client->getResponse()->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}