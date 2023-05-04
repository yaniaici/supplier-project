<?php


namespace App\Controller;

use App\Entity\Proveedores;
use App\Form\ConfirmedType;
use App\Form\ProveedoresType;
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
     * @Route("/proveedores/new", name="proveedores_new", methods={"GET","POST"})
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
            'proveedor' => $proveedor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/proveedores/edit/{id}", name="proveedores_edit", methods={"GET","POST"})
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
            'mensaje' => 'Proveedor editado con exito ID: $id',
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/proveedores/edit", name="proveedores_edit_who", methods={"POST"})
     */

     public function editWho(ManagerRegistry $managerRegistry, Request $request): Response
     {
        $manager = $managerRegistry->getManager();
        $form = $this->createForm(ProveedoresType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form["ID"]->getData();
            return $this->redirectToRoute('proveedores_edit', ['id' => $id]);
        }

        return $this->render('proveedores/edit.html.twig', [
            'title' => 'Qué proveedor editamos?',
            'form' => $form->createView()
        ]);
     }


    /**
     * @Route("/proveedores/delete/{id}", name="proveedores_delete", methods={"DELETE"})
     */
    public function deleteID($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $manager = $entityManager;
        $proveedor = $manager->getRepository(Proveedores::class)->find($id);
        $id = $proveedor->getId();

        if (!$proveedor) {
            return $this->render('proveedores/error.html.twig', [
                'mensaje' => 'Proveedor no encontrado con ID $id'
            ]);
        }

        $form = $this->createForm(ConfirmedType::class);
        $form->handleRequest($request);

        if ($form -> isSubmitted()) {
            $manager->remove($proveedor);
            $manager->flush();
            $alarma = $manager -> getRepository(Proveedores::class)->find($id);
            return $this->redirectToRoute('proveedores_index');

            if ($alarma) {
                return $this->render('proveedores/error.html.twig', [
                    'mensaje' => 'No se ha podido eliminar el proveedor'
                ]);
            }
        }

        return $this->redirect('proveedores_index');

    }

    /**
     * @Route("/proveedores/delete", name="proveedores_delete_who", methods={"POST"})
     */

    public function deleteWho(Request $request, ManagerRegistry $manager): Response {

        $entityManager = $manager->getManager();

        $form = $this -> createForm(ConfirmedType::class);
        $form -> handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $id = $form["ID"] -> getData();
            return $this->redirectToRoute('proveedores_delete', ['id' => $id]);
            
        }

        return $this->render('proveedores/delete.html.twig', [
            'title' => 'Borrar proveedor',
            'form' => $form->createView()
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
