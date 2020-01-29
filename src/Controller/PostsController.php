<?php

namespace App\Controller;

use App\Entity\Posts;
use App\Entity\Users;
use App\Form\PostType;
use App\Form\ResponseType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use NS\SimpleMDEBundle\Form\Types\MarkdownEditorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostsController extends AbstractController
{
    /**
     * @Route("/ree", name="hoeeme")
     */
    public function index()
    {
        return $this->getAll();
    }

    /**
     * @Route("/", name="home")
     */
    public function getAll(PostsRepository $repo)
    {
        $posts = $repo->getAll();
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/posts/tag", name="posts-tag")
     */
    public function tag(PostsRepository $repo)
    {
        $posts = $repo->tag();
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/posts/newest", name="posts-newest")
     */
    public function newest(PostsRepository $repo)
    {
        $posts = $repo->newest();
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/posts/unanswerer", name="posts-unanswerer")
     */
    public function unanswerer(PostsRepository $repo)
    {
        $posts = $repo->unanswered();
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }
    /**
     * @Route("/posts/vote", name="posts-vote")
     */
    public function vote(PostsRepository $repo)
    {
        $posts = $repo->getVote();
        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/posts/new", name = "post_new")
     * @Route("/posts/edit/{id}", name = "post_edit")
     */
    public function update(Posts $post = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$post){
            $post = new Posts();
        }

        
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!$post->getId()){
                $post->setTimestamp(new \DateTime());
            }

            $user = $this->getUser();
            $user3 = new Users();
        $user3->setPseudo("alaint")
            ->setPassword("alain")
            ->setLastName("alain")
            ->setFirstName("silovy")
            ->setEmail("alaint@test.com")
            ->setReputation(0)
            ->setBirthDate(new \DateTime("2019-11-15"));
            $manager->persist($user3);
            $post->setUser($user3);
            
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('home');
            // return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
        }

        return $this->render('posts/edit-post.html.twig', [
            'formPost'=>$form->createView(), "editMod" => $post->getId() !== null
        ]);
    }

    /**
     * @Route("/posts/{id}", name="post")
     */
    public function getOne(Posts $post,  Request $request, EntityManagerInterface $manager)
    {
            $response = new Posts();

        $form = $this->createForm(ResponseType::class, $response);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $response->setTimestamp(new \DateTime());
            $user = $this->getUser();
            $user3 = new Users();
        $user3->setPseudo("alaint")
            ->setPassword("alain")
            ->setLastName("alain")
            ->setFirstName("silovy")
            ->setEmail("alaint@test.com")
            ->setReputation(0)
            ->setBirthDate(new \DateTime("2019-11-15"));
            $manager->persist($user3);
            $response->setUser($user3);
            $response->setParent($post);
            
            $manager->persist($response);
            $manager->flush();

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }
        
        return $this->render('posts/show-post.html.twig', [
            'post' => $post, 'formPost'=>$form->createView()
        ]);
    }

    

    /**
     * @Route("/posts/delete/{id}", name="post_delete")
     */
    public function delete(Posts $post, EntityManagerInterface $manager)
    {
        $manager->remove($post);
        $manager->flush();

        return $this->redirectToRoute('home');
    }
}
