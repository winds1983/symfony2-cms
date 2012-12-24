<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\Type\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('BloggerBlogBundle:Page:index.html.twig');
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
                	->setFrom($this->container->getParameter('blogger_blog.email.contact_email'), $this->container->getParameter('blogger_blog.email.contact_name'))
                	->setTo($enquiry->getEmail(), $enquiry->getName())
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
}