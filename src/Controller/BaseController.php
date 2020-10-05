<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BaseController constructor.
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @return User|null
     */
    public function getUserEntity() :?User
    {
        return $this->em->getRepository(User::class)
            ->findByUserName($this->getUser()->getUsername());
    }

    protected function getPayload(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if (isset($data['document']['payload'])) {
            return json_encode($data['document']['payload']);
        }

        return null;
    }

    /**
     * @param $data
     * @param int $options
     * @return JsonResponse
     */
    protected function response($data, $options = 0)
    {
        $d = json_encode(['document' => $data], $options);

        return new JsonResponse($d, 200, [], true);
    }
}
