<?php

namespace App\Controller;

use App\Entity\Roles;
use App\Form\RolesType;
use App\Repository\RolesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user/roles")
 */
class RolesController extends AbstractController
{
    /**
     * @Route("/", name="roles_index", methods={"GET"})
     */
    public function index(RolesRepository $rolesRepository): Response
    {
        return $this->render('roles/index.html.twig', [
            'roles' => $rolesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="roles_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $role = new Roles();
        $form = $this->createForm(RolesType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($role);
            $entityManager->flush();

            $this->addFlash("success" , "Rôle ajouté");

            return $this->redirectToRoute('roles_index');
        }

        return $this->render('roles/new.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/{id}/edit", name="roles_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Roles $role): Response
    {
        $form = $this->createForm(RolesType::class, $role);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();


            $this->addFlash("success" , "Mise à jour effectuée");
            return $this->redirectToRoute('roles_index');
        }

        return $this->render('roles/edit.html.twig', [
            'role' => $role,
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/{id}", name="roles_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Roles $role): Response
    {
        if ($this->isCsrfTokenValid('delete'.$role->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($role);
            $entityManager->flush();

            $this->addFlash("danger" , "Rôle supprimé");
        }

        return $this->redirectToRoute('roles_index');
    }
}
