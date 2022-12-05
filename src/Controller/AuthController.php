<?php
namespace App\Controller;


use App\Entity\Client;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class AuthController extends ApiController
{
    private $userRepository;
    private $clientRepository;

    public function __construct(
        UserRepository $userRepository,
        ClientRepository $clientRepository
    )
    {
        $this->userRepository=$userRepository;
        $this->clientRepository=$clientRepository;
    }

    public function registerUser(Request $request)
    {
        $request = $this->transformJsonBody($request);
        $name = $request->get('name');
        $password = $request->get('password');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $rol = $request->get('rol');

//        if (empty($password) || empty($email)){
//            return $this->respondValidationError("Invalid Username or Password or Email");
//        }

        if (!empty($this->userRepository->findOneBy(['email'=>$email]))){
            return $this->respondValidationError("Invalid Email" );
        }

        $user = $this->userRepository->save($name, $email,$password, $phone, $address, $firstName, $lastName, $rol );
        //$user = $this->userRepository->save('superadmin', 'superadmin@gmail.com','1234', 'phone', 'addres', '$firstName', '¡$lastName', 'ROLE_ADMIN' );

        return $this->respondWithSuccess($user);
    }

    public function register(Request $request)
    {

        $request = $this->transformJsonBody($request);
        $name = $request->get('name');
        $gender = $request->get('gender');
        $date = $request->get('date');
        $password = $request->get('password');
        $email = $request->get('email');
        $mobile = $request->get('mobile');
        $address = $request->get('address');
        $addressNumber = $request->get('addressNumber');
        $blockNumber = $request->get('blockNumber');
        $postalCode = $request->get('postalCode');
        $city = $request->get('city');
        $province = $request->get('province');
        $country = $request->get('country');
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $location = '';
//        $firstName = $request->get('firstName');
//        $lastName = $request->get('lastName');
        /*return new JsonResponse ([
            $request->get('name'),
            $request->get('password'),
            $request->get('email'),
            $request->get('mobile'),
            $request->get('address'),
            $request->get('addressNumber'),
            $request->get('blockNumber'),
            $request->get('postalCode'),
            $request->get('city'),
            $request->get('province'),
            $request->get('country'),
        ]);*/


        if (
            empty($password) || empty($email) ||
            empty($mobile) || empty($address) ||
            empty($addressNumber) ||
            empty($postalCode) || empty($city) ||
            empty($province) || empty($country)
        ){
            return $this->respondValidationError("Invalid Username or Password or Email");
        }

        if (!empty($this->clientRepository->findOneBy(['email'=>$email]))){
            return $this->respondValidationError("Invalid Email" );
        }


        $client = $this->clientRepository->save(
            $name,$gender,$date, $email,
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
        );
        $data[]=[
            'id'=>$client->getId(),
            'email'=>$client->getEmail(),
        ];
        return $this->respondWithSuccess($data);
    }

//    public function register(Request $request, UserPasswordEncoderInterface $encoder)
//    {
//        $em = $this->getDoctrine()->getManager();
//        $request = $this->transformJsonBody($request);
//        $name = $request->get('name');
//        $password = $request->get('password');
//        $email = $request->get('email');
//
//        if (empty($password) || empty($email)){
//            return $this->respondValidationError("Invalid Username or Password or Email");
//        }
//
//
//        $user = new User();
//        $user->setPassword($encoder->encodePassword($user, $password));
//        $user->setEmail($email);
//        $user->setName($name);
//        $em->persist($user);
//        $em->flush();
//        return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
//    }

    /**
     * @param UserInterface $user
     * @param JWTTokenManagerInterface $JWTManager
     * @return JsonResponse
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager)
    {
        return new JsonResponse(['tokens' => $JWTManager->create($user)]);
    }

}
