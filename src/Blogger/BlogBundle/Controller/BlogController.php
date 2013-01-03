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
     * @param string $slug
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')
        		   ->findOneBy(array('slug' => $slug));
        
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
     * Show post
     *
     * @param integer $id
     * @deprecated
     */
    public function viewAction($id)
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
     * Create post
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
                //$blog->upload();
                $em->persist($blog);
                $em->flush();
                
                //return $this->redirect($this->generateUrl('blogger_blog_blog_show', array('id'=>$blog->getId())));
                return $this->redirect($this->generateUrl('blogger_blog_blog_show', array('slug'=>$blog->getSlug())));
            }
        }
        
        return $this->render('BloggerBlogBundle:Blog:create.html.twig', array(
            'form' => $form->createView(),
            'actionPath' => $this->generateUrl('blogger_blog_blog_create'),
        ));
    }
    
    /**
     * Update post
     */
    public function updateAction($id)
    {
    	$em = $this->getDoctrine()->getEntityManager();
        
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
        
        if (!$blog) {
            throw $this->createNotFoundException('Can not find this post.');
        }
        
        $form = $this->createForm(new BlogType(), $blog);
    
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                // Update the blog entity
                //$blog->upload();
                $em->flush();
                
                //return $this->redirect($this->generateUrl('blogger_blog_blog_show', array('id'=>$blog->getId())));
                return $this->redirect($this->generateUrl('blogger_blog_blog_show', array('slug'=>$blog->getSlug())));
            }
        }
    
        return $this->render('BloggerBlogBundle:Blog:update.html.twig', array(
            'form' => $form->createView(),
            'actionPath' => $this->generateUrl('blogger_blog_blog_update', array('id'=>$blog->getId())),
        ));
    }
    
    /**
     * Delete post
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
    
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);
    
        if (!$blog) {
            throw $this->createNotFoundException('Can not find this post.');
        } else {
            // Delete the blog entity
            //$blog->removeComment($blog->getComments());
            $em->remove($blog);
            $em->flush();
            
            return $this->redirect($this->generateUrl('blogger_blog_page_homepage'));
        }
    }
}