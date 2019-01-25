<?php

/**
 * PurchaseOrderRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 *
 * @author Saswati
 *
 * @category Repository
 */
namespace AppBundle\Repository;

class PurchaseOrderRepository extends \Doctrine\ORM\EntityRepository
{
	/**
    * 
    * get orders
    * It is used to fetch product data from database on given filters.
    *
    * @param array $data array of coloum name and its values
    * @return array $result containing required data.
    */
    public function getOrderDetails($value)
    { 
        
        $query = $this->createQueryBuilder('po')
                    ->select('po.poId')
                    ->addSelect('c.name as customer')
                    ->addSelect('a.name as account')
                    ->addSelect('st.name as salesTerm')
                    ->addSelect('po.totalAmt')
                    ->addSelect('po.notes')
                    ->addSelect('po.dueDate')
                    ->addSelect('cc.name as currency')
                    ->leftJoin('AppBundle:Customer', 'c', 'WITH', 'po.customer = c.id')
                    ->leftJoin('AppBundle:Account', 'a', 'WITH', 'po.account = a.id')
                    ->leftJoin('AppBundle:CompanyCurrency', 'cc', 'WITH', 'po.currency = cc.id')
                    ->leftJoin('AppBundle:Term', 'st', 'WITH', 'po.salesTerm = st.id');

        if($value){
            if (array_key_exists('customer',$value)) {
                 
                $query->Where('c.name = :name')
                    ->setParameter('name',$value['customer']);
            } elseif (array_key_exists('dueDate',$value)) {
 
                 $query->Where('po.dueDate = :dueDate')
                    ->setParameter('dueDate',$value['dueDate']);
            } 
        }
              
        return $query->getQuery()->getResult();
    }


}
