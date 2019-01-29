<?php

namespace AppBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 * @author Saswati
 *
 * @category Repository
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{

	/**
    * 
    * get products
    * It is used to fetch product data from database on given filters.
    *
    * @param array $data array of coloum name and its values
    * @return array $result containing required data.
    */
    public function getProducts($value)
    { 
        
        $query = $this->createQueryBuilder('p')
                    ->select('p.sku')
                    ->addSelect('p.name')
                    ->addSelect('p.description')
                    ->addSelect('p.level')
                    ->addSelect('p.taxable')
                    ->addSelect('p.unit_price')
                    ->addSelect('p.level')
                    ->addSelect('p.quantity_on_hand')
                    ->addSelect('p.product')
                    ->addSelect('p.image')
                    ->addSelect('p.reorder_point')
                    ->addSelect('t.code as type')
                    ->addSelect('v.name as vendor')
                    ->addSelect('ct.name as category')
                    ->leftJoin('AppBundle:Vendor', 'v', 'WITH', 'p.prefered_vendor = v.id')
                    ->leftJoin('AppBundle:Type', 't', 'WITH', 'p.type = t.id')
                    ->leftJoin('AppBundle:ItemCategoryType', 'ct', 'WITH', 'p.item_category_type = ct.id');
        if($value){
            if (array_key_exists('data',$value)) {
                $demo = json_decode($value,true);
                 $query->Where('p.sku IN (:sku)')
                    ->setParameter('sku', explode(',',$demo['data']));
            } elseif (array_key_exists('name',$value)) {

                 $query->Where('p.name = :name')
                    ->setParameter('name',$value['name']);

            } elseif (array_key_exists('category',$value)) {

                 $query->Where('ct.name = :name')
                    ->setParameter('name',$value['category']);
            } 
        }
                             
        return $query->getQuery()->getResult();
    }

    /**
    * 
    * get vendor Details related to the products
    * It is used to fetch vendor data from database on given filters.
    *
    * @param array $data array of coloum name and its values
    * @return array $result containing required data.
    */
    public function getVendorDetail($value)
    { 
        $query = $this->createQueryBuilder('p')
                    ->select('p.sku')
                    ->addSelect('p.name')
                    ->addSelect('v.emailAddress as email')
                    ->addSelect('v.name as vendor')
                    ->leftJoin('AppBundle:Vendor', 'v', 'WITH', 'p.prefered_vendor = v.id');
        
         
        $query->Where('p.product = :product')
                ->setParameter('product', $value);
        return $query->getQuery()->getResult();
    }

}
