<?php

namespace GroupsBundle\Controller;

use GroupsBundle\Entity\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Entity\User;

/**
 * Group controller.
 *
 * @Route("groups")
 */
class GroupsController extends Controller
{
    /**
     * Lists all group entities.
     *
     * @Route("/", name="groups_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine();

        $groups = $em->getManager()->getRepository('GroupsBundle:Groups')->findAll();
        $total = $em->getRepository(Groups::class)->CountDQL();
        $totalUser = $em->getRepository(User::class)->CountUsersDQL();
        $totalBanned = $em->getRepository(User::class)->CountBannedDQL();
        return $this->render('groups/index.html.twig', array(
            'groups' => $groups,
            'total' => $total,
            'totalUser' => $totalUser,
            'totalBanned' => $totalBanned,
        ));
    }

    /**
     * Creates a new group entity.
     *
     * @Route("/new", name="groups_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $groupp = new Groups();
        $form = $this->createForm('GroupsBundle\Form\GroupsType', $groupp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupp);
            $em->flush();

            return $this->redirectToRoute('groups_show', array('id' => $groupp->getId()));
        }

        return $this->render('groups/new.html.twig', array(
            'group' => $groupp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a group entity.
     *
     * @Route("/{id}", name="groups_show")
     * @Method("GET")
     */
    public function showAction(Groups $group)
    {
        $ug=Array();
        $idG = $group->getId();
        $deleteForm = $this->createDeleteForm($group);

        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'SELECT * FROM groups_user WHERE groups_id='.$idG;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $em = $this->getDoctrine();
        dump($idG);
        foreach ( $stmt as $rw){
            $gr = $em->getRepository(User::class)->find($rw['user_id']);
            array_push($ug,$gr);
        }
        return $this->render('groups/show.html.twig', array(
            'group' => $group,
            'ug'=> $ug,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a group entity.
     *
     * @param Groups $group The group entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Groups $group)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groups_delete', array('id' => $group->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing group entity.
     *
     * @Route("/{id}/edit", name="groups_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Groups $group)
    {
        $deleteForm = $this->createDeleteForm($group);
        $editForm = $this->createForm('GroupsBundle\Form\GroupsType', $group);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groups_edit', array('id' => $group->getId()));
        }

        return $this->render('groups/edit.html.twig', array(
            'group' => $group,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a group entity.
     *
     * @Route("/{id}/delete", name="groups_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Groups $group)
    {
        $form = $this->createDeleteForm($group);
        $form->handleRequest($request);
        dump($group);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->remove($group);
            $em->flush();
        }

        return $this->redirectToRoute('groups_index');
    }

/**
* Finds and displays a group entity.
*
* @Route("/users:{id}", name="client_userIn")
* @Method("GET")
*/
    public function userInAction(Groups $group)
    {
        $ug=Array();
        $idG = $group->getId();
        $idU= $this->get('security.token_storage')->getToken()->getUser()->getId();
        $deleteForm = $this->createDeleteForm($group);

        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'SELECT * FROM groups_user WHERE groups_id='.$idG;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $em = $this->getDoctrine();
        dump($idG);
        foreach ( $stmt as $rw){
            $gr = $em->getRepository(User::class)->find($rw['user_id']);
            array_push($ug,$gr);
        }
        return $this->render('client/usersIn.html.twig', array(
            'group' => $group,
            'idU' => $idU,
            'ug'=> $ug,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
