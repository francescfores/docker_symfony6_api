<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BusinessRepository;
use App\Repository\FederationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends  ApiController
{
    private $userRepository;
    private $federationRepository;
    private $businessRepository;

    public function __construct(
//        FederationRepository $federationRepository,
        UserRepository $userRepository,
//        BusinessRepository $businessRepository
    )
    {
//        $this->federationRepository = $federationRepository;
        $this->userRepository = $userRepository;
//        $this->businessRepository = $businessRepository;
    }

    /**
     * @Route("/", name="user", methods={"GET"})
     */
    public function index2()
    {
        return $this->respondWithSuccess('hello');
    }


    /**
     * @Route("/user", name="user", methods={"GET"})
     */
    public function index()
    {
        $users = $this->userRepository->findAll();
        $data = [];

        foreach ($users as $user){
            $data[]=[
                'id'=>$user->getId(),
                'email'=>$user->getEmail(),
                'name'=>$user->getName(),
                'phone'=>$user->getPhone(),
                'address'=>$user->getAddress(),
                'firstName'=>$user->getFirstName(),
                'lastName'=>$user->getLastName(),
                'rol'=>$user->getRoles(),
            ];
        }
        return $this->respondWithSuccess($data);
    }

    /**
     * @Route("/user/{id}", name="user", methods={"GET"})
     */
    public function show($id)
    {
        $user = $this->userRepository->findByIdWihtRelations($id);

        return $this->respondWithSuccess($user);
    }
    /**
     * @Route("/user", name="user", methods={"POST"})
     */
    public function store(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $name = $request->get('name');
        $password = $request->get('password');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $rol = $request->get('rol');

        if (empty($password) || empty($email)){
            return $this->respondValidationError("Invalid Username or Password or Email");
        }

        $user = $this->userRepository->save($name, $email,$password, $phone, $address, $firstName, $lastName, $rol );

        return $this->respondWithSuccess($user);
    }

    public function storeFederation(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
         $federationId = $request->get('id');
        $name = $request->get('name');
        $password = $request->get('password');
        $email = $request->get('email');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $rol = $request->get('rol');

        if (empty($password) || empty($email)){
            return $this->respondValidationError("Invalid Username or Password or Email");
        }

        $user = $this->userRepository->save($name, $email,$password, $phone, $address, $firstName, $lastName, $rol );
        dump($user);
        $federation = $this->federationRepository->findOneBy(['id'=>$federationId]);
        dump($federation);

        $federation = $federation->addUser($user);
        $em->persist($federation);
        $em->flush();

        dump($federation);

        $data[]=[
            'id'=>$user->getId(),
            'email'=>$user->getEmail(),
        ];
        return $this->respondWithSuccess($data);
    }

    public function addBusiness($id, $idBusiness, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->userRepository->find(['id' => $id] );
        $business = $this->businessRepository->find(['id' => $idBusiness] );
        $user = $user->addBusiness($business);
        $em->persist($user);
        $em->flush();

        return $this->respondWithSuccess($user);

    }
    /**
     * @Route("/user/{id}", name="user", methods={"PUT"})
     */
    public function update($id, Request $request)
    {
        $user = $this->userRepository->findOneBy(['id'=>$id]);
        $request = $this->transformJsonBody($request);
        $email = $request->get('email');
        $name = $request->get('name');
        $phone = $request->get('phone');
        $address = $request->get('address');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $rol = $request->get('rol');

        if (empty($email)){
            return $this->respondValidationError("Invalid Username or Password or Email");
        }
        $user->setEmail($email);
        $user->setName($name);
        $user->setPhone($phone);
        $user->setAddress($address);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setRoles([$rol]);

        $user = $this->userRepository->update($user);

        return $this->respondWithSuccess($user);
    }

    /**
     * @Route("/user/{id}", name="user", methods={"DELETE"})
     */
    public function destroy($id)
    {
//        dump($id);
        $user = $this->userRepository->findOneBy(['id'=>$id]);
        dump($user);
        $user = $this->userRepository->remove($user);

        return $this->respondWithSuccess($user);
    }

    public function checkEmail(Request $request)
    {
        $email = $request->get('email');

        $user = $this->userRepository->findOneBy(['email'=>$email]);
        $federation = $this->federationRepository->findOneBy(['email'=>$email]);
        $business = $this->businessRepository->findOneBy(['email'=>$email]);

//        $client = $this->userRepository->findOneBy(['email'=>$email]);
        dump($email);
        dump($federation);
        dump($user);
        dump($business);

        $boolean = false;
        if(!empty($user) || !empty($federation) || !empty($business)){
            $boolean = true;
        }
        dump($boolean);
        return $this->respondWithSuccess($boolean);
    }
}
