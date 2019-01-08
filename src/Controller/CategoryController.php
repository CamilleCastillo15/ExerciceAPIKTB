<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Brand;
use App\Entity\Category;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FOSRest;

class CategoryController extends Controller
{
    /**
     * Liste toutes les categories.
     * @FOSRest\Get("/categories")
     *
     * @return array
     */
    public function getCategoriesAction()
    {
        
        $repository = $this->getDoctrine()->getRepository(Category::class);

        $categories = $repository->findall();
        
        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($categories, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
     /**
     * Créer category
     * @FOSRest\Post("/categories")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function postCategoryAction(Request $request)
    {
        $category = new Category();

        $category->setName($request->get('name'));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($category);
        $em->flush();
        
        $serializer = $this->container->get('jms_serializer');
        $response = new Response($serializer->serialize($category, 'json'));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    /**
     * Supprimer une category
     * @FOSRest\Delete("/category/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function deleteCategoryAction($id, Request $request)
    {
        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $category = $repositoryCategory->findOneById($id);
        
        if (!$category) {
            throw $this->createNotFoundException('Pas de catégorie trouvée !');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($category);
        $em->flush();

        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($category, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    /**
     * Modifier une category
     * @FOSRest\Put("/category/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function putCategoryAction($id, Request $request)
    {
        $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
        $category = $repositoryCategory->findOneById($id);
        
        if (!$category) {
            throw $this->createNotFoundException('Pas de catégorie trouvée !');
        }

        $category->setName($request->get('name'));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($category);
        $em->flush();
        
        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($category, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
}
