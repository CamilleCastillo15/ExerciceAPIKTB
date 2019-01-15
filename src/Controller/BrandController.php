<?php

namespace App\Controller;

use App\Service\APIService;
//use App\Controller\APIServiceController;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Brand controller.
 */
class BrandController extends Controller
{
    
    /**
     * Liste toutes les Brands.
     * @FOSRest\Get("api/brands")
     *
     * @return array
     */
    public function getBrandsAction(APIService $apiService)
    {

        $res = $apiService->getAll('Brand');
        
        return $res;
    }
    
     /**
     * Créer une Brand
     * @FOSRest\Post("api/brands")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function postBrandAction(APIService $apiService, Request $request)
    {
        
        $entityAttributes = array(
            "name" => $request->get('name')
        );
        
        $res = $apiService->post('Brand', $entityAttributes);
        
        return $res;
        
    }
    
    /**
     * Supprimer une Brand
     * @FOSRest\Delete("api/brand/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function deleteBrandAction(APIService $apiService, $id, Request $request)
    {
        
        $res = $apiService->delete('Brand', $id);
        
        return $res;
        
    }
    
    /**
     * Modifier une Brand
     * @FOSRest\Put("api/brand/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function putBrandAction(APIService $apiService, $id, Request $request)
    {
         $entityAttributes = array(
            "name" => $request->get('name')
        );
        
        $res = $apiService->put('Brand', $id, $entityAttributes);
        
        return $res;
        
    }
}
