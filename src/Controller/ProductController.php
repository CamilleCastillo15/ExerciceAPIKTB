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
 * Product controller.
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
        
        $repository = $this->getDoctrine()->getRepository(Product::class);

        $products = $repository->findall();
        
        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($products, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * Créer produit
     * @FOSRest\Post("/products")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function postProductAction(Request $request)
    {
        $product = new Product();
        
        $repositoryBrand = $this->getDoctrine()->getRepository(Brand::class);
        $brand = $repositoryBrand->findOneById($request->get('brandId'));
        
        $product->setBrandId($brand)->setActive($request->get('active'))->setName($request->get('name'))
                ->setUrl($request->get('url'))->setDescription($request->get('description'));
        
        $em->persist($article);
        $em->flush();
        
        $serializer = $this->container->get('jms_serializer');
        $response = new Response($serializer->serialize($product, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    /**
     * Supprimer un produit
     * @FOSRest\Delete("/product/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function deleteProductAction($id, Request $request)
    {
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $product = $repositoryProduct->findOneById($id);
        
        if (!$product) {
            throw $this->createNotFoundException('Pas de produit trouvé !');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($product);
        $em->flush();

        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($product, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    /**
     * Modifier un produit
     * @FOSRest\Put("/product/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function putProductAction($id, Request $request)
    {
        $repositoryProduct = $this->getDoctrine()->getRepository(Product::class);
        $product = $repositoryProduct->findOneById($id);
        
        if (!$product) {
            throw $this->createNotFoundException('Pas de produit trouvé !');
        }
        
        if($request->get('brandId')){           
            $repositoryBrand = $this->getDoctrine()->getRepository(Brand::class);
            $brand = $repositoryBrand->findOneById($request->get('brandId'));
            
            $product->setBrandId($brand);
        }
        
        if($request->get('active')) $product->setActive($request->get('active'));
        if($request->get('name')) $product->setName($request->get('name'));
        if($request->get('url')) $product->setUrl($request->get('url'));
        if($request->get('description')) $product->setDescription($request->get('description'));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($product);
        $em->flush();
        
        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($product, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
}