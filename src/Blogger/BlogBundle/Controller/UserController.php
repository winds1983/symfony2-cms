<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Form\UserRegisterType;

class UserController extends Controller
{
	/**
	 * register a new user
	 */
    public function registerAction()
    {
        $user = new User();
        $form = $this->createForm(new UserRegisterType(), $user);
        
        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
            	// generate and set password
            	$factory = $this->get('security.encoder_factory');
            	$encoder = $factory->getEncoder($user);
            	$password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            	$user->setPassword($password);
            	
                // Persist the user entity
                $em = $this->getDoctrine()
                		   ->getEntityManager();
                $em->persist($user);
                $em->flush();
                
                return $this->redirect($this->generateUrl('blogger_blog_page_homepage'));
            }
        }
        
        return $this->render('BloggerBlogBundle:User:register.html.twig', array(
			'form' => $form->createView(),
			'actionPath' => $this->generateUrl('blogger_blog_user_register'),
        ));
    }
}