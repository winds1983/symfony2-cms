<?php
namespace Blogger\BlogBundle\Entity;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\MinLength;
use Symfony\Component\Validator\Constraints\MaxLength;

class Enquiry
{
    protected $name;
    
    protected $email;
    
    protected $subject;
    
    protected $body;
    
    /**
     * 定义验证器，需实现loadValidatorMetadata静态方法，使用ClassMetadata物件为实体属性设置验证条件
     * @param ClassMetadata $metadata
     */
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('name', new NotBlank())
        		 ->addPropertyConstraint('email', new Email(array(
        		       'message' => 'This email is invalid, please enter a real email address.',
        		   )))
        		 ->addPropertyConstraint('subject', new NotBlank())
        		 ->addPropertyConstraint('subject', new MaxLength(50))
        		 ->addPropertyConstraint('body', new MinLength(50));
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
    public function getSubject()
    {
        return $this->subject;
    }
    
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }
    
    public function getBody()
    {
        return $this->body;
    }
    
    public function setBody($body)
    {
        $this->body = $body;
    }
}