<?php

// src/Service/APIService.php
namespace App\Service;

use App\Entity\Product;
use App\Entity\Brand;
use App\Entity\Category;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

use Symfony\Component\HttpFoundation\Response;

class APIService 
{
    
    protected $objectManager;
    protected $jms_serializer;

    public function __construct(
            EntityManagerInterface $entityManager, 
            SerializerInterface $jmsSerializerBundle
        )
    {
        $this->entityManager = $entityManager;
        $this->jmsSerializerBundle = $jmsSerializerBundle;
    }

    
    //fonction générique qui retourne un objet JSON
    //Avec toutes les lignes retournées par un 'findAll'
    //En cherchant sur un repository lié à une entité
    public function getAll($entity)
    {
       
        $class = $entity.'::Class';
        $repository = $this->entityManager->getRepository('App\Entity\\'.$entity);

        $entities = $repository->findall();  
        
        return $this->serializeEntities($entities);
        
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
        
        $json_data = $this->jmsSerializerBundle->serialize($entities, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }        
}
