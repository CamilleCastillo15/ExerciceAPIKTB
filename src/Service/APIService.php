<?php

// src/Service/APIService.php
namespace App\Service;

use App\Entity\Product;
use App\Entity\Brand;
use App\Entity\Category;

use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerInterface;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\HttpException;

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
       
        $repository = $this->entityManager->getRepository('App\Entity\\'.$entity);

        $entities = $repository->findall();  
        
        return $this->serializeEntities($entities);
        
    }
    
    //fonction générique qui retourne un objet JSON
    //Et permet d'afficher l'entité indiquée dans l'URL par son id
    public function getOne($entity, $id)
    {
        $repository = $this->entityManager->getRepository('App\Entity\\'.$entity);

        $entity = $repository->findOneById($id);
        
        if($entity == null){
            throw new HttpException(404, 'L\'id indiqué ne correspond à aucune entité existante !');
        }
        
        return $this->serializeEntities($entity);
    }
    
    //fonction générique qui retourne un objet JSON
    //Et permet de créer une nouvelle entité   
    //Avec un tableau d'attributs d'entités
    //Dont les valeurs sont les paramètre de la requête POST
    public function post($entity, array $entityAttributes)
    {
        $entityName = 'App\Entity\\'.$entity;
        $entity = new $entityName();
        
        foreach($entityAttributes as $k => $v){
            if(is_array($k)){
                //Si une des clés de ce tableau est un autre tableau
                //Alors il s'agit d'un attribut 'relation', qui pointe sur une autre entité
                //On doit pouvoir retrouver le nom du Repository qui correspond au nom de l'entité étrangère
                //Ainsi que le nom de l'attribut concerné
                foreach($k as $repoName => $attributeName){
                    $repository = $this->entityManager->getRepository('App\Entity\\'.$repoName);
                    $foreignEntity = $repositoryBrand->findOneById($idForeignKey);
                    if($foreignEntity == null){
                        throw new HttpException(404, 'Le BrandId indiqué ne correspond à aucune entité existante !');
                    }
                    $entity->{'set'.$attributeName}($repositoryBrand->findOneById($idForeignKey));
                    
                }
            }else{                  
                $entity->{'set'.$k}($v); 
            }
            
        }
        
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        
        return $this->serializeEntities($entity);
    }
    
    //Permet de supprimer une entité avec son id
    public function delete($entity, $id)
    {
        $repository = $this->entityManager->getRepository('App\Entity\\'.$entity);
        $entityToDelete = $repository->findOneById($id);
        
        if($entityToDelete == null){
            throw new HttpException(404, 'L\'id indiqué ne correspond à aucune entité existante !');
        }
        
        $this->entityManager->remove($entityToDelete)->flush();

        return $this->serializeEntities($entityToDelete);
    }
    
    //Permet de modifier une entité placée en paramètre
    //Avec son id, un tableau d'attributs d'entités
    public function put($entity, $id, array $entityAttributes)
    {
        var_dump($entityAttributes);
        if(count($entityAttributes) == 0){
            throw new HttpException(400, 'Vous n\'avez spécifié aucun attribut à modifier !');
        }
        
        $repository = $this->entityManager->getRepository('App\Entity\\'.$entity);
        $entityToUpdate = $repository->findOneById($id);
        
        if($entityToUpdate == null){
            throw new HttpException(404, 'L\'id indiqué ne correspond à aucune entité existante !');
        }
        
        //On fait une boucle sur le tableau de valeurs d'attributs d'entités
        foreach($entityAttributes as $k => $v){
            if($v) {
                //Si une des clés de ce tableau est un autre tableau
                //Alors il s'agit d'un attribut 'relation', qui pointe sur une autre entité
                //On doit pouvoir retrouver le nom du Repository qui correspond au nom de l'entité étrangère
                //Ainsi que le nom de l'attribut concerné
                if(is_array($k)){
                foreach($k as $repoName => $attributeName){
                    $repository = $this->entityManager->getRepository('App\Entity\\'.$repoName);
                    $entity->{'set'.$attributeName}($repositoryBrand->findOneById($idForeignKey));
                    }
                }else{                  
                    $entity->{'set'.$k}($v); 
                }
            }    
        }
        
        $this->entityManager->persist($entityToUpdate);
        $this->entityManager->flush();
        
        return $this->serializeEntities($entityToUpdate);
    }
    
    //Utilise le bundle JMS pour sérialiser une entité ou tableaux d'entités en objet JSON
    public function serializeEntities($entities)
    {
        
        $json_data = $this->jmsSerializerBundle->serialize($entities, 'json'); 
        $response = new Response($json_data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }        
}
