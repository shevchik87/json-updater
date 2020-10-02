<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Component\User\NewTokenDto;
use App\Component\User\UserManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends BaseController
{
    /**
     * @Route("/api/v1/login", name="login_user", methods={"POST"})
     */
    public function loginAction(Request $request, UserManager $manager)
    {
        $loginData = json_decode($request->getContent(), true);
        if (!isset($loginData['login'])) {
            return new JsonResponse('Login is required', 422);
        }

        if (!$manager->userIsExist($loginData['login'])) {
            return new JsonResponse('User not found', 404);
        }

        $newToken = $manager->getNewToken();
        $dto = new NewTokenDto($loginData['login'], $newToken, time()+3600);
        $manager->saveNewToken($dto);

        return new JsonResponse($dto);
    }
}
