<?php


namespace App\Controller;

use App\Entity\Proveedores;
use App\Form\ConfirmedType;
use App\Form\ProveedoresType;
use App\Form\WhoType;
use App\Repository\ProveedoresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/", name="proveedores_index")
     */
    public function index(): Response
    {
        return $this->render('proveedores/index.html.twig', [
            'title' => 'Proveedores',
        ]);
    }


    /**
     * @Route("/proveedores/new", name="proveedores_new")
     */

    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manager = $entityManager;
        $proveedor = new Proveedores();

        // Inicializamos con algunos datos
        $proveedor->setFechaCreacion(new \DateTime('now'));
        $proveedor->setFechaActualizacion(new \DateTime('now'));
        $proveedor->setActivo(true);

        $form = $this->createForm(ProveedoresType::class, $proveedor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($proveedor);
            $manager->flush();

            return $this->redirectToRoute('proveedores_index');
        }

        return $this->render('proveedores/new.html.twig', [
            'title' => 'Nuevo proveedor',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/proveedores/edit/{id}", name="proveedores_edit")
     */


    public function editID(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $manager = $entityManager;
        $proveedor = $entityManager->getRepository(Proveedores::class)->find($id);

        if (!$proveedor) {
            return $this->render('proveedores/error.html.twig', [
                'mensaje' => 'Proveedor no encontrado con ID $id'
            ]);
        }

        $proveedor->setFechaActualizacion(new \DateTime('now'));
        $form = $this->createForm(ProveedoresType::class, $proveedor);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->flush();

            return $this->redirectToRoute('proveedores_index');
        }

        return $this->render('proveedores/edit.html.twig', [
            'mensaje' => 'Qué deseas editar?',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/proveedores/edit", name="proveedores_edit_who")
     */

    public function editWho(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $manager = $managerRegistry->getManager();
        $form = $this->createForm(WhoType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form["ID"]->getData();
            return $this->redirectToRoute('proveedores_edit', ['id' => $id]);
        }

        return $this->render('proveedores/menuWho.html.twig', [
            'title' => 'Qué proveedor editamos?',
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/proveedores/delete/{id}", name="proveedores_delete")
     */
    public function deleteID(Request $request, EntityManagerInterface $manager, $id): Response
    {
        $entityManager = $manager;
        $proveedor = $entityManager->getRepository(Proveedores::class)->find($id);


        if (!$proveedor) {

            return $this->render('proveedores/error.html.twig', [
                'mensaje' => "Proveedor no encontrado con ID $id"
            ]);

        }


        $form = $this->createForm(ConfirmedType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->remove($proveedor);
            $entityManager->flush();
            $alarma = $entityManager->getRepository(Proveedores::class)->find($id);

            if ($alarma) {
                throw $this->createNotFoundException(
                    'Error en la eliminación del proveedor'
                );
            }
            return $this->redirect('http://localhost/supplier-project/public/');
        }

        return $this->render('proveedores/delete.html.twig', [
            'title' => 'Eliminar proveedor',
            'form' => $form->createView(),
            'proveedor' => $proveedor
        ]);

        
    }

    /**
     * @Route("/proveedores/delete", name="proveedores_delete_who")
     */
    public function deleteWho(ManagerRegistry $manager, Request $request): Response
    {   
        $entityManager = $manager->getManager();

        $form = $this->createForm(WhoType::class);
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form["ID"]->getData();
            return $this->redirect("http://localhost/supplier-project/public/proveedores/delete/$id");              
        }

        return $this->render('proveedores/menuWho.html.twig', [
            'title' => 'Qué proveedor deseas eliminar?', 'form' => $form->createView(),
        ]);        
    }




    /**
     * @Route("/proveedores/read", name="proveedores_read")
     */
    public function read(ManagerRegistry $doctrine): Response
    {
        $proveedores = $doctrine->getRepository(Proveedores::class);

        $data = $proveedores->findAll();

        return $this->render('proveedores/read.html.twig', [
            'title' => 'Listado de proveedores', 'data' => $data
        ]);
    }
}
