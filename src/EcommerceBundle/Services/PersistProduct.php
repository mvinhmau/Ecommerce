<?php
namespace EcommerceBundle\Services;
use Doctrine\ORM\EntityManager;
use EcommerceBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;

class PersistProduct{

  public function __construct(EntityManager $em){
    $this->em = $em;
  }
  public function createAction($task)
	{
		//entityManager
		//$em= $this-> getDoctrine()->getManager();

		//creation d'un objet Product
		$product = new Product();
		$product->setName($task->getName());
		$product->setPrice($task->getPriceMax());
		$product->setDescription($task->getDescription());
    $product->setCategory($task->getCategory());

		//persistence
		$this->em->persist($product);
		//insertion
		$this->em->flush();

    $responseString = 'Saved produit n°'.$product->getId();

		return $responseString;


	}

  public function getProduct($task){
    {
      $dql_query = $this->em->getRepository("EcommerceBundle:Product")->createQueryBuilder('o');
      if ($task->getPriceMin()!=0){
        $dql_query
          ->where('o.price >= :priceMin');
      }
      if ($task->getName()!==NULL){
        $dql_query
          ->andWhere('o.name like :name ');
      }
      if ($task->getPriceMax()!=0){
        $dql_query
          ->andWhere('o.price <= :priceMax');
      }
      if ($task->getCategory()!='NULL'){
        $dql_query
          ->andWhere('o.category = :category');
      }
      $query=$dql_query->getQuery();
      if ($task->getPriceMin()!=0){
        $query
          ->setParameter('priceMin', $task->getPriceMin());
      }
      if ($task->getName()!==NULL){
        $query
          ->setParameter('name', '%'.$task->getName().'%');
      }
      if ($task->getPriceMax()!=0){
        $query
          ->setParameter('priceMax', $task->getPriceMax());
      }
      if ($task->getCategory()!='NULL'){
        $query
          ->setParameter('category', $task->getCategory());
      }
  		/*$products = $this->em
  			->getRepository(Product::class)
  			->findBy(
  				array('name' => $task->getName())
  			);*/
  		//var_dump($products);
  		/*if (!$dql_query || count($dql_query)<=0)
  		{
  			return( 'No product found for your research');
  		}
  		else
  		{*/
  			//return new Response('Products find : '.count($products));
        return $query->getResult();

//  			return $this->render('EcommerceBundle:Default:produits.html.twig', array('products'=>$products));
  		//}
  	}
  }
}
