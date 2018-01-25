<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/ecommerce/home", name="home")
     * @Route("/ecommerce/home/")
     */
    public function indexAction()
    {
	//$noms=array('n1', 'n2', 'n3');
        return $this->render('EcommerceBundle:Default:index.html.twig' );
        //return $this->render('EcommerceBundle:Default:index.html.twig');
    }

     /**
     * @Route("/ecommerce/home/first/", name="first")
     */
    public function firstAction()
    {
         return $this->render('EcommerceBundle:Default:first.html.twig');
    }

    /**
     * @Route("/ecommerce/home/second/", name="second")
     */
    public function secondAction()
    {
         return $this->render('EcommerceBundle:Default:second.html.twig');
    }

    /**
     * @Route("/ecommerce/home/products/", name="products")
     */

    public function goToProducts(){
        return $this->render('EcommerceBundle:Default:products.html.twig');
    }

    public function goToAddProducts(){
        return $this->render('EcommerceBundle:Default:addProducts.html.twig');
    }
}
