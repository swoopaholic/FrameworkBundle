<?php

namespace Swoopaholic\Bundle\FrameworkBundle\Controller;

use Doctrine\ORM\Id\UuidGenerator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Standard CRUD controller
 */
abstract class CrudController extends Controller
{
    public function doIndexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository($this->getEntityClass())->findAll();

        return array(
            'entities' => $entities,
        );
    }

    public function doCreateAction($form, Request $request)
    {
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $form->getData();

            if (method_exists($entity, 'setLogId')) {
                $generator = new UuidGenerator();
                /** @noinspection PhpParamsInspection */
                /** @noinspection PhpParamsInspection */
                /** @noinspection PhpParamsInspection */
                /** @noinspection PhpParamsInspection */
                $id = $generator->generate($em, $entity);
                $entity->setLogId($id);
            }

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Entity has been created!');

            return true;
        }

        return array(
//            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    public function doNewAction($form)
    {
        return array(
            'form'   => $form->createView(),
        );
    }

    public function doShowAction($entity)
    {
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    public function doEditAction($form)
    {
        $entity = $form->getData();
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity' => $entity,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    public function doUpdateAction($form, Request $request)
    {
        $entity = $form->getData();
        $deleteForm = $this->createDeleteForm($entity->getId());

        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Entity has been saved!');

            return true;
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    public function doDeleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->submit($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository($this->getEntityClass())->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Entity has been deleted!');
        }

        return $this->redirect($this->generateUrl($this->getRoutePrefixName()));
    }

    /**
     * Creates a form to delete an entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    protected function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id), array('csrf_protection' => false))
            ->add('id', 'hidden')
            ->getForm()
            ;
    }

}
