<?php

namespace App\Repository;

use App\Entity\Proveedores;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

/**
 * @extends ServiceEntityRepository<Proveedores>
 * 
 * @method Proveedores|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proveedores|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proveedores[]    findAll()
 * @method Proveedores[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

 // Nota: Uso Intelliphense y me da problemas con ServiceEntityRepository

class ProveedoresRepository extends ServiceEntityRepository { 

    public function __construct(ManagerRegistry $registry) {
        parent::__construct($registry, Proveedores::class);
    }

    /**
 * @throws ORMException
 * @throws OptimisticLockException
 */

public function addProveedor(Proveedores $proveedor, bool $flush = true): void 
{
    $this->getEntityManager()->persist($proveedor);
    
    if ($flush) {
        $this->getEntityManager()->flush();
    }
}

/**
 * @throws ORMException
 * @throws OptimisticLockException
 */

public function removeProveedor(Proveedores $proveedor, bool $flush = true): void {
    $this->getEntityManager()->remove($proveedor);

    if ($flush) {
        $this->getEntityManager()->flush();
    }
}

}



