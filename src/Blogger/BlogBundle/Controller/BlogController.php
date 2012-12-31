<?php
namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Form\BlogType;
use Blogger\BlogBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    /**
     * Show post
     * 
     * @param integer $id
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if (!$blog) {
            throw $this->createNotFoundException('Can not find this post.');
        }
        
        // update hits
        $blog->setHits($blog->getHits()+1);
        $em->flush();
        
        $comments = $em->getRepository('BloggerBlogBundle:Comment')
        			   ->getCommentsForBlog($blog->getId());
        
        return $this->render('BloggerBlogBundle:Blog:show.html.twig', array(
            'blog' => $blog,
            'comments' => $comments,
        ));
    }
    
    /**
     * Create new post
     */
    public function createAction()
    {
        $blog = new Blog();
        $form = $this->createForm(new BlogType(), $blog);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                // Persist the blog entity
                $em = $this->getDoctrine()
                		   ->getEntityManager();
                $em->persist($blog);
                $em->flush();
                
                $this->redirect($this->generateUrl('blogger_blog_blog_show', array('id'=>$blog->getId())));
            }
        }
        
        return $this->render('BloggerBlogBundle:Blog:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}