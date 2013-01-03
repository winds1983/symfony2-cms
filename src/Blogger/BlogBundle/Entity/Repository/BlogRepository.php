<?php

namespace Blogger\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * BlogRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlogRepository extends EntityRepository
{
    public function getLastPosts($limit = null)
    {
        $qb = $this->createQueryBuilder('b')
        		   ->select('b, c, ct')
        		   ->leftJoin('b.comments', 'c')
        		   ->leftJoin('b.category', 'ct')
        		   ->addOrderBy('b.created', 'DESC');
        
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        
        return $qb->getQuery()
        		   ->getResult();
    }
    
    public function getTags()
    {
        $blogTags = $this->createQueryBuilder('b')
        				 ->select('b.tags')
        				 ->getQuery()
        				 ->getResult();
    
        $tags = array();
        foreach ($blogTags as $blogTag) {
            $tags = array_merge(explode(",", $blogTag['tags']), $tags);
        }
    
        foreach ($tags as &$tag) {
            $tag = trim($tag);
        }
    
        return $tags;
    }
    
    public function getTagWeights($tags)
    {
        $tagWeights = array();
        if (empty($tags))
            return $tagWeights;
    
        foreach ($tags as $tag) {
            $tagWeights[$tag] = (isset($tagWeights[$tag])) ? $tagWeights[$tag] + 1 : 1;
        }
        // Shuffle the tags
        uksort($tagWeights, function() {
            return rand() > rand();
        });
        
        $max = max($tagWeights);
        
        // Max of 5 weights
        $multiplier = ($max > 5) ? 5 / $max : 1;
        foreach ($tagWeights as &$tag) {
            $tag = ceil($tag * $multiplier);
        }
        return $tagWeights;
    }
    
    public function getBlogsForTag($tag, $limit = null)
    {
        $qb = $this->createQueryBuilder('b')
        		   ->select('b, c')
        		   //->where('FIND_IN_SET(":tag", b.tags)')
        		   ->leftJoin('b.comments', 'c')
        		   ->addOrderBy('b.created', 'DESC');
        		   //->setParameter('tag', strtolower(trim($tag)));
        
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
        
        return $qb->getQuery()
        		   ->getResult();
    }
    
    public function getBlogsForCategorySlug($slug, $limit = null)
    {
        $qb = $this->createQueryBuilder('b')
        		   ->select('b, c, ct')
        		   ->leftJoin('b.comments', 'c')
        		   //->leftJoin('b.category', 'ct', 'WITH', "ct.slug = :slug")
        		   ->leftJoin('b.category', 'ct')
        		   ->where('ct.slug = :slug')
        		   ->addOrderBy('b.created', 'DESC')
        		   ->setParameter('slug', strtolower(trim($slug)));
    
        if (false === is_null($limit))
            $qb->setMaxResults($limit);
    
        return $qb->getQuery()
        		   ->getResult();
    }
}
