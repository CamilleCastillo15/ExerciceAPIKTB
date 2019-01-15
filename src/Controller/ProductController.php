<?php

namespace App\Controller;

use App\Service\APIService;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FOSRest;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Product controller.
 */
class ProductController extends Controller
{
    
    /**
     * Liste tous les Product.
     * @FOSRest\Get("api/products")
     *
     * @return array
     */
    public function getProductsAction(APIService $apiService)
    {

        $res = $apiService->getAll('Product');
        
        return $res;
    }
    
     /**
     * Créer un Product
     * @FOSRest\Post("api/products")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function postProductAction(APIService $apiService, Request $request)
    {
        $params = $request->query->all();
        $entityAttributes = array();
        
        if(isset($params['brandId'])) array_push($entityAttributes, array('brandId' => $request->get('brandId')));
        else { throw new HttpException(400, 'Vous devez spécifier le brandId du product !'); }
        
        if(isset($params['active'])) $entityAttributes += [ "active" => $params['active'] ];
        
        if(isset($params['name'])) $entityAttributes += [ "name" => $params['name'] ];
        else { throw new HttpException(400, 'Vous devez spécifier le name du product !'); }
        
        if(isset($params['url'])) $entityAttributes += [ "url" => $params['url'] ];
        
        if(isset($params['description'])) $entityAttributes += [ "description" => $params['description'] ];
        
        
        $res = $apiService->post('Product', $entityAttributes);
        
        return $res;
        
    }
    
    /**
     * Supprimer un Product
     * @FOSRest\Delete("api/product/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function deleteProductAction(APIService $apiService, $id, Request $request)
    {
        
        $res = $apiService->delete('Product', $id);
        
        return $res;
        
    }
    
    /**
     * Modifier un Product
     * @FOSRest\Put("api/product/{id}")
     * 
     * @param Request $request
     * @return array|Response
     */
    public function putProductAction(APIService $apiService, $id, Request $request)
    {
        $params = $request->query->all();
        $entityAttributes = array();

        if(isset($params['brandId'])) array_push($entityAttributes, array('brandId' => $request->get('brandId')));       
        if(isset($params['active'])) $entityAttributes += [ "active" => $params['active'] ];        
        if(isset($params['name'])) $entityAttributes += [ "name" => $params['name'] ];      
        if(isset($params['url'])) $entityAttributes += [ "url" => $params['url'] ];      
        if(isset($params['description'])) $entityAttributes += [ "description" => $params['description'] ];
        
        $res = $apiService->put('Product', $id, $entityAttributes);
        
        return $res;
        
    }
}