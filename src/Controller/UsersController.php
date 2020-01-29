<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users", name="users")
     */
    public function index()
    {
        return $this->redirectToRoute('lusers');
    }

    /**
     * @Route("/users/ls", name="lusers")
     */
    public function getAll(UsersRepository $repo)
    {
        $users = $repo->findAll();
        return $this->render('users/userlist.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/users/new", name = "user_new")
     * @Route("/users/edit/{id}", name = "user_edit")
     */
    public function update(Users $user = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$user){
            $user = new Users();
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$user->getId()){
                $user->setReputation(0);
            }
            
            
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('lusers');
        }

        return $this->render('users/edit-user.html.twig', [
            'formUser'=>$form->createView(), "editMod" => $user->getId() !== null
        ]);
    }

    /**
     * @Route("/users/{id}", name="user")
     */
    public function getOne(Users $user)
    {
        return $this->render('users/show-user.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/users/delete/{id}", name="user_delete")
     */
    public function delete(Users $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('lusers');
    }
}
