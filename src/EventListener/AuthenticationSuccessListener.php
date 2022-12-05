<?php


namespace App\EventListener;
// src/App/EventListener/AuthenticationSuccessListener.php
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;


class AuthenticationSuccessListener
{
    private $userRepository;
    private $clientRepository;
    private $manager;

    public function __construct(
        UserRepository $userRepository,
        ClientRepository $clientRepository,
        EntityManagerInterface $manager
    ){
        $this->userRepository=$userRepository;
        $this->clientRepository=$clientRepository;
    }
    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof UserInterface) {
            return;
        }
        $entityName =$user->getClassName();
        if($entityName=='Client'){
            $user = $this->clientRepository->findOneBy(['email'=>$user->getUsername()]);

            $data['user'] = array(
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $user->getName(),
                'password' => $user->getPassword(),
                'address' => $user->getAddress(),
                'mobile' => $user->getMobile(),
                'gender' => $user->getGender(),
                'date' => $user->getDate(),
                'role' => $user->getRoles()[0],
                'location' => $user->getLocation(),
                'lat'  => $user->getLat(),
                'lng'  => $user->getLng(),
                'lat_geolocation'  => $user->getLatGeolocation(),
                'lng_geolocation'  => $user->getLngGeolocation(),
                'points' => $user->getPoints(),
                'awards' => $user->getClientAwards()->toArray(),
                'transactions' => $user->getTransactions()->toArray()
            );
        }else{
            $user = $this->userRepository->findByIdWihtRelations($user->getId());
            $data['user'] = $user;
        }

        $event->setData($data);
    }
}
