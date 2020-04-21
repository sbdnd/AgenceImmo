<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController
{   
    private $repository;
    private $em;

    /**
     * @param PropertyRepository $repository
     * @param EntityManagerInterface $em
     */
    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/property", name="property")
     * @return Response
     */
    public function index() : Response
    {   

        return $this->render('property/index.html.twig', [
            'active_menu' => 'active',
        ]);
    }


    /**
     * @Route("/property/{slug}-{id}", name="property_show", requirements={"slug": "[a-zA-Z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug) : Response
    {          
        //redirection si le slug ne correspond pas à celui du bien sélectionné
        if ($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('property_show', [
                'id' => $property->getId(),
                'slug' => $property->getSlug()
            ], 301);
        }
        
        return $this->render('property/show.html.twig', [
            'active_menu' => 'active',
            'property' => $property
        ]);
    }
}
