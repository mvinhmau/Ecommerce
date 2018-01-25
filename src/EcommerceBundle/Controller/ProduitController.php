<?php

namespace EcommerceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManager;
use EcommerceBundle\Entity\Product;
use EcommerceBundle\Entity\Task;

use EcommerceBundle\Services\PersistProduct;
use EcommerceBundle\Services\AddProductForm;
use EcommerceBundle\Services\ResearchProductForm;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 *@Route(service="produitController")
 */

class ProduitController extends Controller
{
	private $pp;

public function __construct(PersistProduct $pp){
		$this->pp=$pp;
	}
     /**
     * @Route("/ecommerce/produit/{nom}", name="produit")
     * @Route("/ecommerce/produit/")
     */
	/*public function indexAction ($nom)
	{
		$produits= ["produit1","produit2", "produit3"];
		return $this-> render('EcommerceBundle:Default:produit.html.twig', array(
											'nom'=>$nom,
											'produits'=> $produits
											));
	}*/

	//Fonction test ajout de produit
	/**
		* @Route("/ecommerce/addProducts", name="addProducts")
		* @Route("/ecommerce/addProducts/")
		*/


	/*public function createAction($name,$price,$desc)
	{
		//entityManager
		$em= $this-> getDoctrine()->getManager();

		//creation d'un objet Product
		$product = new Product();
		$product->name = $name;
		$product->price= $price;
		$product->description=$desc;

		//persistence
		$em->persist($product);
		//insertion
		$em->flush();

		return new Response('Saved produit n°'.$product->getId());
	}*/

	public function editAction()
	{
		$doctrine= $this->getDoctrine();
		$em= $doctrine->getManager();
		$em2=$doctrine->getManager('other_connection');
	}

	//Fonction de renvoie produit en fonction de son id
	/**
        * @Route("/ecommerce/searchProductbyId/{productId}/", name="searchProductbyId")
        * @Route("/ecommerce/searchProductbyId/{productId}")
        */
	public function searchProductById($productId)
	{
		$product = $this-> getDoctrine()
			->getRepository(Product::class)
			->find($productId);
		if (!$product)
		{
			throw $this->createNotFoundException( 'No product found for id '.$productid);
		}
		else
		{
			return new Response('Product find : '.$product->name. 'prix: '. $product->price);
		}
	}

	//Fonction de renvoie produit en fonction de son nom
	/**
        * @Route("/ecommerce/searchProductbyName/{productName}/", name="searchProductbyName")
        * @Route("/ecommerce/searchProductbyName/{productName")
        */
	public function searchProductByName($productName)
	{
		$product = $this-> getDoctrine()
			->getRepository(Product::class)
			->findOneByName($productName);
		if (!$product)
		{
			throw $this->createNotFoundException( 'No product found for name '.$productName);
		}
		else
		{
			return new Response('Product find : '.$product->name. 'prix: '. $product->price);
		}
	}

	//Fonction de recherche -> prix et du nom
	/**
        * @Route("/ecommerce/searchProductbyMultiCriteria/{productName}/{price}", name="searchProductbyMultiCriteria")
        * @Route("/ecommerce/searchProductbyName/{productName}/{price}")
        */
	public function searchProductByMultiCriteria($productName, $price)
	{
		$products = $this-> getDoctrine()
			->getRepository(Product::class)
			->findBy(
				array('name' => $productName, 'price'=>(float) $price),
				array('price' => 'ASC')
			);
		//var_dump($products);
		if (!$products || count($products)<=0)
		{
			throw $this->createNotFoundException( 'No product found for name '.$productName);
		}
		else
		{
			//return new Response('Products find : '.count($products));
			return $this->render('EcommerceBundle:Default:produits.html.twig', array('products'=>$products));
		}
	}

	/**
		* @Route("/ecommerce/addProduct", name="addProduct")
		* @Route("/ecommerce/addProduct/")
		*/
	public function addForm(Request $request){
		$task= new Task();
		$form = $this->createForm(AddProductForm::class,$task);
		$form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
			$task = $form->getData();
			if (trim($task->getName())!=''){
				$recup=$this->pp->createAction($task);
				return $this->render('EcommerceBundle:Default:addProductSuccess.html.twig', array('test' => $recup,));
			}
		}
		return $this->render('EcommerceBundle:Default:addProducts.html.twig', array('form' => $form->createView(),'title'=>'ajout',));
  }

	/**
		* @Route("/ecommerce/researchProduct", name="researchProduct")
		* @Route("/ecommerce/researchProduct/")
		*/

		public function researchForm(Request $request){
			$task= new Task();
			$form = $this->createForm(ResearchProductForm::class,$task);
			$form->handleRequest($request);
			if ($form->isSubmitted() && $form->isValid()) {
				$task = $form->getData();
				$recup=$this->pp->getProduct($task);
				return $this->render('EcommerceBundle:Default:produit.html.twig', array('test' => $recup,));
			}
		return $this->render('EcommerceBundle:Default:addProducts.html.twig', array('form' => $form->createView(),'title'=>'recherche',));
	}
}
