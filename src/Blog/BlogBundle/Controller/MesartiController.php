<?php

namespace Blog\BlogBundle\Controller;

use Blog\BlogBundle\Entity\Mesarti;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mesarti controller.
 *
 * @Route("mesarti")
 */
class MesartiController extends Controller
{
    /**
     * Lists all mesarti entities.
     *
     * @Route("/", name="mesarti_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mesartis = $em->getRepository('BlogBundle:Mesarti')->findAll();

        return $this->render('mesarti/index.html.twig', array(
            'mesartis' => $mesartis,
        ));
    }

    /**
     * Creates a new mesarti entity.
     *
     * @Route("/new", name="mesarti_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mesarti = new Mesarti();
        $form = $this->createForm('Blog\BlogBundle\Form\MesartiType', $mesarti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mesarti);
            $em->flush();

            return $this->redirectToRoute('mesarti_show', array('id' => $mesarti->getId()));
        }

        return $this->render('mesarti/new.html.twig', array(
            'mesarti' => $mesarti,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mesarti entity.
     *
     * @Route("/{id}", name="mesarti_show")
     * @Method("GET")
     */
    public function showAction(Mesarti $mesarti)
    {
        $deleteForm = $this->createDeleteForm($mesarti);

        return $this->render('mesarti/show.html.twig', array(
            'mesarti' => $mesarti,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mesarti entity.
     *
     * @Route("/{id}/edit", name="mesarti_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mesarti $mesarti)
    {
        $deleteForm = $this->createDeleteForm($mesarti);
        $editForm = $this->createForm('Blog\BlogBundle\Form\MesartiType', $mesarti);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mesarti_edit', array('id' => $mesarti->getId()));
        }

        return $this->render('mesarti/edit.html.twig', array(
            'mesarti' => $mesarti,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mesarti entity.
     *
     * @Route("/{id}", name="mesarti_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mesarti $mesarti)
    {
        $form = $this->createDeleteForm($mesarti);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mesarti);
            $em->flush();
        }

        return $this->redirectToRoute('mesarti_index');
    }

    /**
     * Creates a form to delete a mesarti entity.
     *
     * @param Mesarti $mesarti The mesarti entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mesarti $mesarti)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mesarti_delete', array('id' => $mesarti->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
