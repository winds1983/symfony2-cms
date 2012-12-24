<?php
namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Form\EnquiryType;

use Symfony\Component\Form\FormBuilder;

use Blogger\BlogBundle\Entity\Enquiry;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        /* $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
            }
        } */
        
        return $this->render('BloggerBlogBundle:Page:contact.html.twig');
    }
}