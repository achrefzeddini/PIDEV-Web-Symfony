<?php

namespace UsersBundle\Controller;

use GroupsBundle\Entity\Groups;
use Symfony\Component\HttpFoundation\JsonResponse;
use UsersBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UsersBundle\Repository\UsersRepository;

/**
 * User controller.
 *
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine();
        $users = $em->getManager()->getRepository('UsersBundle:User')->findAll();
        $total = $em->getRepository(Groups::class)->CountDQL();
        $totalUser = $em->getRepository(User::class)->CountUsersDQL();
        $totalBanned = $em->getRepository(User::class)->CountBannedDQL();
        return $this->render('user/index.html.twig', array(
            'users' => $users,
            'total' => $total,
            'totalUser' => $totalUser,
            'totalBanned' => $totalBanned,
        ));
    }

    /**
     * Creates a new user entity.
     *
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('UsersBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->addRole("ROLE_USER");
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user_show', array('id' => $user->getId()));
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     */
    public function showAction(User $user)
    {
        $gu=Array();

        $idU = $user->getId();
        $deleteForm = $this->createDeleteForm($user);

        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'SELECT * FROM groups_user WHERE user_id='.$idU;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $em = $this->getDoctrine()->getManager();
        foreach ( $stmt as $rw){
            $gr = $em->getRepository(Groups::class)->find($rw['groups_id']);
            array_push($gu,$gr);
        }


        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'gu'=> $gu,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function _showAction(User $user){
        $guc=Array();

        $idU = $user->getId();
        $deleteForm = $this->createDeleteForm($user);

        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'SELECT * FROM groups_user WHERE user_id='.$idU;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $em = $this->getDoctrine()->getManager();
        foreach ( $stmt as $rw){
            $gr = $em->getRepository(Groups::class)->find($rw['groups_id']);
            array_push($guc,$gr);
        }


        return $this->render('client/myGroups.html.twig', array(
            'user' => $user,
            'guc'=> $guc,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function __showAction(User $user){
        $gucc=Array();

        $idU = $user->getId();
        $deleteForm = $this->createDeleteForm($user);

        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'SELECT * FROM groups_user WHERE user_id!='.$idU;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $em = $this->getDoctrine()->getManager();
        foreach ( $stmt as $rw){
            $gr = $em->getRepository(Groups::class)->find($rw['groups_id']);
            array_push($gucc,$gr);
        }


        return $this->render('client/notMyGroups.html.twig', array(
            'user' => $user,
            'gucc'=> $gucc,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UsersBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Ban an existing user entity.
     *
     */
    public function banAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UsersBundle:User')->find($id);



            if ($user->isEnabled() ) {
                $user->setEnabled(false);

            } else {
                $user->setEnabled(true);
            }

        $em->flush();


        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to ban a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createBanForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_index', array('id' => $user->getId())))
            ->setMethod('POST')
            ->getForm();
    }

    public function ___showAction(Request $request){
        $guc=Array();

        //$idU = $request->attributes->get('id');

        $idU= $this->get('security.token_storage')->getToken()->getUser()->getId();
        dump($idU);

        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'SELECT * FROM groups_user WHERE user_id='.$idU;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $em = $this->getDoctrine()->getManager();
        foreach ( $stmt as $rw){
            $gr = $em->getRepository(Groups::class)->find($rw['groups_id']);
            array_push($guc,$gr);
        }

        $gucc=Array();

        $sql2 = 'SELECT * FROM groups WHERE id NOT IN ( SELECT groups_id FROM groups_user WHERE user_id='.$idU.')';
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
        foreach ( $stmt2 as $rw){

                $grs = $em->getRepository(Groups::class)->find($rw['id']);
                array_push($gucc, $grs);

        }

        return $this->render('client/myGroups.html.twig', array(
            'guc'=> $guc,
            'gucc'=> $gucc,
            'idU'=> $idU,
        ));
    }
    public function joinAction(Request $request){
        $idU=$request->attributes->get('idU');
        $idG=$request->attributes->get('idG');
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'INSERT INTO groups_user (user_id, groups_id) VALUES ('.$idU.','.$idG.')';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $this->redirectToRoute( 'client_show',['id' => $idU]);
    }

    public function leaveAction(Request $request){
        $idU=$request->attributes->get('idU');
        $idG=$request->attributes->get('idG');
        $conn = $this->getDoctrine()->getManager()
            ->getConnection();
        $sql = 'DELETE FROM groups_user WHERE user_id ='.$idU.' AND groups_id= '.$idG;
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $this->redirectToRoute( 'client_show',['id' => $idU]);
    }


}
