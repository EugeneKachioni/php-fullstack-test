<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as FOS;
use AppBundle\Entity\Post;
class CommentController extends Controller
{
    /**
     * @FOS\Get("/posts/{id}/comments", requirements={"postId":"\d+"})
     *
     * @return \AppBundle\Entity\Comment[]
     */
    public function getComments(Post $post)
    {
        return $this->getDoctrine()
            ->getManagerForClass(Comment::class)
            ->createQueryBuilder()
            ->select('comment')
            ->from(Comment::class, 'comment')
            ->where('comment.post = :post')
            ->setParameter('post', $post)
            ->getQuery()
            ->execute();
    }
}