<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    private $userPasswordHasherInterface;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface, ManagerRegistry $registry,EntityManagerInterface $manager)
    {
        $this->userPasswordHasherInterface=$userPasswordHasherInterface;
        $this->manager = $manager;

        parent::__construct($registry, User::class);
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

    public function save($name, $email,$password, $phone, $address, $firstName, $lastName, $rol)
    {
        $user = new User();
        $user
            ->setPassword(
                $this->userPasswordHasherInterface->hashPassword(
                    $user, $password
                ))
            ->setName($name)
            ->setEmail($email)
            ->setPhone($phone)
            ->setAddress($address)
            ->setFirstName($firstName)
            ->setLastName($lastName)
            ->setRoles([$rol]);

        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }

    public function update(User $user)
    {
        $this->manager->persist($user);
        $this->manager->flush();

        $data[]=[
            'id'=>$user->getId(),
            'email'=>$user->getEmail(),
            'name'=>$user->getName(),
        ];

        return $data;
    }

    public function remove(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
    }

    public function findByIdWihtRelations($id)
    {
        $user = $this->findOneBy(['id'=>$id]);
        $data = [];

        if($user!=null){
            $data=$user->jsonSerialize();
            $data['federations']=$user->getFederations()->toArray();
            $data['businesses']=$user->getBusinesses()->toArray();
        }
        return $data;

    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
