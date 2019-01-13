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
     * Liste toutes les brand.
     * @FOSRest\Get("/brands")
     *
     * @return array
     */
    public function getBrandsAction(APIService $apiService)
    {

        $res = $apiService->getAll('Brand');
        
        return $res;
    }
    
     /**
     * Créer Brand
     * @FOSRest\Post("/brands")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function postBrandAction(Request $request)
    {
        
        $entityAttributes = array(
            "name" => $request->get('name')
        );
        
        $res = $apiService->post('Brand', $entityAttributes);
        
        return $res;
        
    }
    
    /**
     * Supprimer une brand
     * @FOSRest\Delete("/brand/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function deleteBrandAction($id, Request $request)
    {
        
        $res = $apiService->delete('Brand', $id);
        
        return $res;
        
    }
    
    /**
     * Modifier une brand
     * @FOSRest\Put("/brand/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function putBrandAction($id, Request $request)
    {
         $entityAttributes = array(
            "name" => $request->get('name')
        );
        
        $res = $apiService->put('Brand', $id, $entityAttributes);
        
        return $res;
        
    }
}
