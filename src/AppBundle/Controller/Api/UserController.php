<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as FOS;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class UserController extends Controller
{
    /**
     * @FOS\Get("/users/{id}")
     *
     * @return \AppBundle\Entity\User
     */
    public function getAction(User $user)
    {
        return $user;
    }

    /**
     * @FOS\Get("/users")
     *
     * @return \AppBundle\Entity\User[]
     */
    public function listAction()
    {
        return $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
    }

    /**
     * @FOS\Put("/users/{id}/roles")
     *
     * @FOS\RequestParam(name="roles")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return \AppBundle\Entity\User
     */
    public function setRolesAction(User $theUser, array $roles)
    {
        if (empty($roles)){
            throw new AccessDeniedException("Cannot remove user roles.");
        }

        $theUser->setRoles($roles);

        $manager = $this->getDoctrine()->getManagerForClass(User::class);

        $manager->flush();

        return $theUser;
    }
}