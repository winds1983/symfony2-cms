<?php
namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\Repository\BlogRepository")
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks()
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="string", length=150)
     */
    protected $slug;
    
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $author;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $content;
    
    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $image;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $tags;
    
    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="blog")
     */
    protected $comments;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $created;
    
    /**
     * @ORM\Column(type="datetime")
     */
    protected $updated;
    
    public function __construct()
    {
        $this->comments = new ArrayCollection();
        
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
    }
    
    /**
     * @ORM\PrePersist
     */
    public function setCreatedValue()
    {
        $this->created = $this->setCreated(new \DateTime());
        $this->updated = $this->setUpdated(new \DateTime());
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->updated = $this->setUpdated(new \DateTime());
    }
    
    /* public function __toString()
    {
        return $this->getTitle();
    } */

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $this->setSlug($this->title);
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Set slug
     *
     * @param string $slug
     * @return Blog
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    
        return $this;
    }
    
    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Blog
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    
        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Blog
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent($length = null)
    {
        if (false === is_null($length) && $length > 0)
            return substr(strip_tags($this->content), 0, $length);
        else
			return $this->content;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Blog
     */
    public function setImage($image)
    {
        $this->image = $image;
    
        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set tags
     *
     * @param string $tags
     * @return Blog
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Blog
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Blog
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add comments
     *
     * @param Blogger\BlogBundle\Entity\Comment $comments
     * @return Blog
     */
    public function addComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;
    
        return $this;
    }

    /**
     * Remove comments
     *
     * @param Blogger\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Blogger\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
    
    /**
     * Format slug
     */
    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
    
        // trim
        $text = trim($text, '-');
    
        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
    
        // lowercase
        $text = strtolower($text);
    
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
    
        if (empty($text)) {
            return 'n-a';
        }
    
        return $text;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('author', new NotBlank());
        $metadata->addPropertyConstraint('content', new NotBlank());
    }
}