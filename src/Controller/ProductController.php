<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Brand;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as FOSRest;
use App\Entity\Article;
/**
 * Brand controller.
 *
 * @Route("/api")
 */
class ProductController extends Controller
{
    /**
     * Liste tous les Products.
     * @FOSRest\Get("/products")
     *
     * @return array
     */
    public function getProductsAction()
    {
//        $entityManager = $this->getDoctrine()->getManager();
        
        $repository = $this->getDoctrine()->getRepository(Product::class);
//        $repositoryBrand = $this->getDoctrine()->getRepository(Brand::class);
        
//        $brand_1 = $repositoryBrand->findOneBy(array('id'=>1));
        $product = $repository->findOneBy(array('id'=>2));
//        echo 'ici';
//        echo $product;
//        exit();
//        
//        $product_test = new Product();
//        $product_test->setBrandId($brand_1);
//        $product_test->setActive(1);
//        $product_test->setName(1);
//        
//        $entityManager->persist($product_test);
//        $entityManager->flush();
        
        // query for a single Product by its primary key (usually "id")
        $products = $repository->findall();
//        var_dump($products); exit();
//        return View::create($product, Response::HTTP_OK , []);
        
        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($products, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
//    /**
//     * Create Article.
//     * @FOSRest\Post("/article")
//     *
//     * @return array
//     */
//    public function postArticleAction(Request $request)
//    {
//        $article = new Article();
//        $article->setName($request->get('name'));
//        $article->setDescription($request->get('description'));
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($article);
//        $em->flush();
//        return View::create($article, Response::HTTP_CREATED , []);
//        
//    }
}