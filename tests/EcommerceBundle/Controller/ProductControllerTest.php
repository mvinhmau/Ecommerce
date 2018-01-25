<?php
//cmd vendor/bin/phpunit
//source http://jobeet.thuau.fr/testez-vos-formulaires

namespace Ecommerce\EcommerceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use EcommerceBundle\Controller\ProduitController;


class ProduitControllerTest extends WebTestCase
{
    public function testAddProduct()
    {
       //test envoie et saisi du formulaire 
       $client = static::createClient();
       $crawler = $client->request('GET', '/ecommerce/addProduct');

       $this->assertEquals(1, $crawler->filter('h3:contains("Page projet ajout")')->count());


       $form = $crawler->selectButton('add_product_form_save')->form();

       $form['add_product_form[name]']       = 'test';
       $form['add_product_form[priceMax]']      = 100;
       $form['add_product_form[description]']    = 'description';
       $form['add_product_form[category]']       = 'Computer';

       $crawler = $client->submit($form);
       
       $this->assertEquals(1, $crawler->filter('h3:contains("Page projet ajout succes")')->count());

       //test présence dans la bdd
       $kernel = static::createKernel();
       $kernel->boot();
       $em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
     
       $query = $em->createQuery('SELECT count(p.name) from EcommerceBundle\Entity\Product p WHERE p.name = :name');
       $query->setParameter('name', 'test');
       $this->assertTrue($query->getSingleScalarResult()>0);
    }

    

     public function testResearchExistingProduct()
    {
        
       $client = static::createClient();
       $crawler = $client->request('GET', '/ecommerce/researchProduct');

       $this->assertEquals(1, $crawler->filter('h3:contains("Page projet recherche")')->count());

       //avoir dans sa bdd un produit respectant les conditions suivantes 
       $form = $crawler->selectButton('research_product_form_save')->form();

       $form['research_product_form[name]']       = 'test';
       $form['research_product_form[priceMin]']      = 15;
       $form['research_product_form[priceMax]']      = 150;

       $crawler = $client->submit($form);
       
       $this->assertEquals(1, $crawler->filter('h1:contains("Liste des Produits")')->count());
       $this->assertTrue($crawler->filter('li:contains("test")')->count()>0);

       
    }

     public function testResearchNoExistingProduct()
    {
        
       $client = static::createClient();
       $crawler = $client->request('GET', '/ecommerce/researchProduct');

       $this->assertEquals(1, $crawler->filter('h3:contains("Page projet recherche")')->count());

       //avoir dans sa bdd un produit respectant les conditions suivantes 
       $form = $crawler->selectButton('research_product_form_save')->form();

       $form['research_product_form[name]']       = 'test';
       $form['research_product_form[priceMin]']      = 200;
       $form['research_product_form[priceMax]']      = 300;

       $crawler = $client->submit($form);
       
       $this->assertEquals(1, $crawler->filter('h1:contains("Liste des Produits")')->count());
       $this->assertEquals(0,$crawler->filter('li:contains("test")')->count());

       
    }

   
}
