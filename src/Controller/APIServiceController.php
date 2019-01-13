<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Brand;
use App\Entity\Category;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class APIServiceController extends Controller 
{
    //fonction générique qui retourne un objet JSON
    //Avec toutes les lignes retournées par un 'findAll'
    //En cherchant sur un repository lié à une entité
    public function getAll($entity)
    {
//        $class = $entity."::class";
//
        var_dump($this);
//        
//        $repository = $this->getDoctrine()->getRepository(Product::class);
////        $repository = $this->getDoctrine()->getRepository("'App\Entity\'".$entity);
//
//        $entities = $repository->findall();  
//        
//        return $this->serializeEntities($entities);
        
        return new Response();
        
    }
    
    //fonction générique qui retourne un objet JSON
    //Et permet d'afficher l'entité indiquée dans l'URL par son id
    public function getOne($entity, $id)
    {
        $repository = $this->getDoctrine()->getRepository("App\Entity".$entity);

        $entity = $repository->findOneById($id);
        
        return $this->serializeEntities($entity);
    }
    
    //fonction générique qui retourne un objet JSON
    //Et permet de créer une nouvelle entité
    public function post($entity, array $entityAttributes)
    {
        $entity = new $entity.'()';
        
        foreach($entityAttributes as $k => $v){
            $entity->set.$k.($v);
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entity)->flush();
        
        return $this->serializeEntities($entity);
    }
    
    public function delete($entity, $id)
    {
        $repository = $this->getDoctrine()->getRepository("App\Entity".$entity);
        $entityToDelete = $repository->findOneById($id);
        
        if (!$entityToDelete) {
            throw $this->createNotFoundException('Pas d\'entité trouvée !');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($entityToDelete)->flush();

        return $this->serializeEntities($entityToDelete);
    }
    
    public function put($entity, $id, array $entityAttributes)
    {
        $repository = $this->getDoctrine()->getRepository("App\Entity".$entity);
        $entityToUpdate = $repository->findOneById($id);
        
        if (!$entityToUpdate) {
            throw $this->createNotFoundException('Pas d\'entité trouvée !');
        }
        
        foreach($entityAttributes as $k => $v){
            
            if($v) $entityToUpdate->set.$k.($v);
            
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($entityToUpdate)->flush();
        
        return $this->serializeEntities($entityToUpdate);
    }
    
    public function serializeEntities($entities)
    {
        
        $serializer = $this->container->get('jms_serializer');
        $json_data = $serializer->serialize($entities, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }        
}
