<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FOS;
use FOS\RestBundle\Controller\Annotations\Prefix;

/**
 * @Prefix("api/")
 */
class UserController extends Controller
{
    /**
     * @FOS\Get("/users/{id}")
     *
     * @return \AppBundle\Entity\User
     */
    public function getAction(User $user)
    {
      //  $user->setPassword(null);
        $user->setRoles($user->getRoles()); // we can write a method in User Entity, which contains correct data

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
     * @FOS\RequestParam(name="roles")     *
     *
     * @param User $theUser
     * @param array $roles
     * @return \AppBundle\Entity\User
     */
    public function setRolesAction(User $theUser, array $roles)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if (!empty($user) && ($user->getId() === $theUser->getId())) {
            $theUser->setRoles($roles);

            $manager = $this->getDoctrine()->getManagerForClass(User::class);
            $manager->flush();

            return $theUser;
        }

        throw $this->createAccessDeniedException('You cannot change rules!');
    }
}