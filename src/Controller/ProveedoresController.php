<?php


namespace App\Controller;

use App\Entity\Proveedores;
use App\Form\ProveedoresType;
use App\Repository\ProveedoresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @route ("/proveedores")
 */
 

class ProveedoresController extends AbstractController
{
    /**
     * @Route("/", name="proveedores_index", methods={"GET"})
     */

    public function index(ProveedoresRepository $proveedoresRepository): Response
    {
        $proveedores = $proveedoresRepository->findAll();

        return $this->render('proveedores/index.html.twig', [
            'proveedores' => $proveedores,
        ]);
    }

    /**
     * @Route("/new", name="proveedores_new", methods={"GET","POST"})
     */

    public function new(Request $request, EntityManagerInterface $entityManager) : Response {
        

        $proveedor = new Proveedores();
        $form = $this->createForm(ProveedoresType::class, $proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($proveedor);
            $entityManager->flush();

            return $this->redirectToRoute('proveedores_index');
        }

        return $this->render('proveedores/new.html.twig', [
            'proveedor' => $proveedor,
            'form' => $form->createView(),
        ]);


    }

    
}