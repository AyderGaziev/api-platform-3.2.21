<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    #[Route('/api/users', name: 'api_users_index', methods: ["GET"])]
    public function index(UserRepository $userRepository): JsonResponse
    {
        $users = $this->userService->getAllUsers();
        return $this->json($users);
    }


    #[Route('/api/users/{id}', name: 'api_users_show', methods: ["GET"])]

    public function show(User $user): JsonResponse
    {
        return $this->json($user);
    }

    #[Route('/api/users', name: 'api_users_create', methods: ["POST"])]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setAge($data['age']);
        $user->setSex($data['sex']);
        $user->setBirthday(new \DateTime($data['birthday']));
        $user->setPhone($data['phone']);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $user =  $this->userService->createUser($user);

        return $this->json($user);
    }

    #[Route('/api/users/{id}', name: 'api_users_update', methods: ["PUT"])]
    public function update(Request $request, User $user, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user->setEmail($data['email']);
        $user->setName($data['name']);
        $user->setAge($data['age']);
        $user->setSex($data['sex']);
        $user->setBirthday(new \DateTime($data['birthday']));
        $user->setPhone($data['phone']);
        $user->setUpdatedAt(new \DateTime());

        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return $this->json(['errors' => (string) $errors], 400);
        }

        $user = $this->userService->updateUser($user);

        return $this->json($user);
    }


    #[Route('/api/users/{id}', name: 'api_users_delete', methods: ["DELETE"])]
    public function delete(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);

        return $this->json(['message' => 'User deleted']);
    }
}
