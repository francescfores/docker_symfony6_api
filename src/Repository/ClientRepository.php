<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
//use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface, ManagerRegistry $registry,EntityManagerInterface $manager)
{
    $this->userPasswordHasherInterface=$userPasswordHasherInterface;
    $this->manager = $manager;


    parent::__construct($registry, Client::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function save(
        $name, $gender, $date, $email,
        $password, $mobile,
        $address,
        $addressNumber,
        $blockNumber,
        $postalCode,
        $city,
        $province,
        $country,
        $lat,
        $lng
    ){
        $user = new Client();
        $date = new \DateTime($date);
        if($lng==null){
            $lng="";
        }
        if($lat == null){
            $lat = "";
        }
        $user
            ->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $user, $password
                ))
            ->setName($name)
            ->setGender($gender)
            ->setDate($date->format("d/m/Y"))
            ->setEmail($email)
            ->setMobile($mobile)
            ->setAddress($address)
            ->setAddressNumber($addressNumber)
            ->setBlockNumber($blockNumber)
            ->setPostalCode($postalCode)
            ->setCity($city)
            ->setProvince($province)
            ->setCountry($country)
            ->setPoints(0)
            ->setLocation('')
            ->setLat($lat)
            ->setLng($lng)
            ->setRoles(['ROLE_CLIENT']);
//            ->setFirstName($firstName)
//            ->setLastName($lastName);

        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }

    public function update(
        $id,
        $name,
        $gender,
        $date,
        $email,
        $mobile,
        $address,
        $addressNumber,
        $blockNumber,
        $postalCode,
        $city,
        $province,
        $country,
        $lat,
        $lng
    )
    {
        $user = $this->findOneBy(['id'=>$id]);
        $user
            ->setName($name)
            ->setGender($gender)
            ->setDate($date)
            ->setEmail($email)
            ->setMobile($mobile)
            ->setAddress($address)
            ->setAddressNumber($addressNumber)
            ->setBlockNumber($blockNumber)
            ->setPostalCode($postalCode)
            ->setCity($city)
            ->setProvince($province)
            ->setCountry($country)
            ->setLocation('')
            ->setLat($lat)
            ->setLng($lng);

        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }

    public function findByIdWihtRelations($id)
    {
        $user = $this->findOneBy(['id'=>$id]);
        $data = [];
        $data=$user->jsonSerialize();

        $awards=[];

        foreach ($user->getClientAwards() as $dat){
                array_push($awards, ['award' =>$dat, 'business' =>$dat->getBusiness()]);
        }
        $data['awards']=$awards;

        $data['transactions']=$user->getTransactions()->toArray();
        return $data;
    }

//    public function getByFederationPaginated($pages, $startPage, $resultsPerPage, $id, $search)
//    {
//        $search = $search . '%';
//        $qb = $this->createQueryBuilder('p')
//            ->where('p.name LIKE :search')
//            ->setParameter('search', $search)
//            ->getQuery();
//        $paginator = $this->paginate($qb, $startPage, $resultsPerPage);
//        return $paginator;
//    }

    public function paginate($dql, $page, $limit)
    {
        $paginator = new Paginator($dql);

        $paginator->getQuery()
            ->setFirstResult($page) // Offset
            ->setMaxResults($limit); // Limit

        return $paginator;
    }

    public function getByFederationPaginated($pages, $startPage, $resultsPerPage, $id, $search)
    {
        $search = $search . '%';
        $qb = $this->em->createQueryBuilder();
        $qb = $qb->select('a', 'u')
            ->from('App\Entity\Client', 'a')
            ->leftJoin('a.businesses', 'u')
            ->where('u.federation = :federation')
            ->andWhere('a.name LIKE :search')
            ->setParameter('search', $search)
            ->setParameter('federation', $id)
            ->getQuery();

        $paginator = $this->paginate($qb, $startPage, $resultsPerPage);
        return $paginator;
    }

    public function getByBusinessPaginated($pages, $startPage, $resultsPerPage, $id, $search)
    {
        $search = $search . '%';
        $qb = $this->em->createQueryBuilder();
        $qb = $qb->select('a', 'u')
            ->from('App\Entity\Client', 'a')
            ->leftJoin('a.businesses', 'u')
            ->where('u.id = :business')
            ->andWhere('a.name LIKE :search')
//            ->andWhere('a.createat LIKE :date_start')
            ->setParameter('search', $search)
            ->setParameter('business', $id)
//            ->setParameter('date_start', '2019-12-02 13:24:10')
            ->getQuery();
        $paginator = $this->paginate($qb, $startPage, $resultsPerPage);
        return $paginator;
    }

    // /**
    //  * @return Client[] Returns an array of Client objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Client
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
