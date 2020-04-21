<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPropertyController extends AbstractController
{
    private $repository;
    private $em;

    public function __construct(PropertyRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="admin_property_index")
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/index.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/create", name="admin_property_create")
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {   
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Créé avec succès');
            return $this->redirectToRoute('admin_property_index');
        }

        return $this->render('admin/create.html.twig', [
            'property' => $property,
            'formProperty' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/{id}", name="admin_property_edit", methods="GET|POST")
     * @param Property $property
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function edit(Property $property, Request $request)
    {   
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Modifié avec succès');
            return $this->redirectToRoute('admin_property_index');
        }


        return $this->render('admin/edit.html.twig', [
            'property' => $property,
            'formProperty' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin_property_delete", methods="DELETE")
     * @param Property $property
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function delete(Property $property, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Supprimé avec succès');
        }
         return $this->redirectToRoute('admin_property_index');
    }

}