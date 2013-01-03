<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
        		   ->getEntityManager();
        
        // method 1:
        //$blogs = $em->getRepository('BloggerBlogBundle:Blog')->findAll();
        
        // method 2: createQueryBuilder
        /* $blogs = $em->createQueryBuilder()
        			->select('b')
        			->from('BloggerBlogBundle:Blog', 'b')
        			->addOrderBy('b.created', 'DESC')
        			->getQuery()
        			->getResult(); */
        
        // method 3:
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
        			->getLastPosts();
        
        return $this->render('BloggerBlogBundle:Page:index.html.twig', array(
            'blogs' => $blogs,
        ));
    }
    
    public function tagsearchAction($tag)
    {
        $em = $this->getDoctrine()
        		   ->getEntityManager();
        
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
        			->getBlogsForTag($tag);
        
        return $this->render('BloggerBlogBundle:Page:tag_search.html.twig', array(
            'blogs' => $blogs,
            'tag' => $tag,
        ));
    }
    
    public function categoryAction($slug)
    {
        $em = $this->getDoctrine()
        		   ->getEntityManager();
    
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')
        			->getBlogsForCategorySlug($slug);
        
        $category = $em->getRepository('BloggerBlogBundle:Category')
        			   ->findOneBy(array('slug' => $slug));
    
        return $this->render('BloggerBlogBundle:Page:category_blogs.html.twig', array(
            'blogs' => $blogs,
            'category' => $category,
        ));
    }
    
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }
    
    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                // sending mail
                $message = \Swift_Message::newInstance()
                	->setTo($this->container->getParameter('blogger_blog.email.contact_email'), $this->container->getParameter('blogger_blog.email.contact_name'))
                	->setFrom($enquiry->getEmail(), $enquiry->getName())
                	->setSubject($enquiry->getSubject())
                	->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.html.twig', array('enquiry'=>$enquiry)));
                $this->get('mailer')->send($message);
                
                // set success flash message
                $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
                
                $this->redirect($this->generateUrl('blogger_blog_page_contact'));
            }
        }
        
        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
        	'form' => $form->createView(),
        ));
    }
    
    public function sidebarAction()
    {
        $em = $this->getDoctrine()
        		   ->getEntityManager();
    
        // tags
        $tags = $em->getRepository('BloggerBlogBundle:Blog')
        		   ->getTags();
        $tagWeights = $em->getRepository('BloggerBlogBundle:Blog')
        				 ->getTagWeights($tags);
        
        // comments
        $commentLimit   = $this->container
        					   ->getParameter('blogger_blog.comments.latest_comment_limit');
        $latestComments = $em->getRepository('BloggerBlogBundle:Comment')
        					 ->getLatestComments($commentLimit);
        
        // categories
        $categories = $em->getRepository('BloggerBlogBundle:Category')
        				 ->getAllCategory();
    
        return $this->render('BloggerBlogBundle:Page:sidebar.html.twig', array(
            'tags' => $tagWeights,
            'latestComments' => $latestComments,
            'categories' => $categories,
        ));
    }
}