<?php

namespace App\Controller;

use App\Service\APIService;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FOSRest;

class CategoryController extends Controller
{    
    /**
     * Liste toutes les Categories.
     * @FOSRest\Get("api/categories")
     *
     * @return array
     */
    public function getCategoriesAction(APIService $apiService)
    {

        $res = $apiService->getAll('Category');
        
        return $res;
    }
    
     /**
     * Créer une Category
     * @FOSRest\Post("api/categories")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function postCategoryAction(APIService $apiService, Request $request)
    {
        
        $entityAttributes = array(
            "name" => $request->get('name')
        );
        
        $res = $apiService->post('Category', $entityAttributes);
        
        return $res;
        
    }
    
    /**
     * Supprimer une Category
     * @FOSRest\Delete("api/category/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function deleteCategoryAction(APIService $apiService, $id, Request $request)
    {
        
        $res = $apiService->delete('Category', $id);
        
        return $res;
        
    }
    
    /**
     * Modifier une Category
     * @FOSRest\Put("api/category/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function putCategoryAction(APIService $apiService, $id, Request $request)
    {
         $entityAttributes = array(
            "name" => $request->get('name')
        );
        
        $res = $apiService->put('Category', $id, $entityAttributes);
        
        return $res;
        
    }
}
