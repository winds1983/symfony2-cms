<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if (!$blog) {
            throw $this->createNotFoundException('Can not find this post.');
        }
        
        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog' => $blog
        ));
    }
}