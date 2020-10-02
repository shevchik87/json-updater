<?php
declare(strict_types = 1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends BaseController
{
    /**
     * @Route("/api/v1/document", name="get_list_documents", methods={"GET"})
     */
    public function indexAction()
    {
        return new JsonResponse("data true");
    }

    /**
     * @Route("/api/v1/document", name="create_document", methods={"POST"})
     */
    public function createAction()
    {
        return new JsonResponse("ok");
    }

    /**
     * @Route("/api/v1/document/{id}", name="get_one_document", methods={"GET"})
     * @param string $id
     */
    public function getOneDocumentAction(string $id)
    {
        return new JsonResponse("ok");
    }

    /**
     * @Route("/api/v1/document/{id}", name="update_document", methods={"PATCH"})
     * @param string $id
     */
    public function updateAction(string $id)
    {
        return new JsonResponse("ok");
    }

    /**
     * @Route("/api/v1/document/{id}/publish", name="publish_document", methods={"POST"})
     * @param string $id
     * @return JsonResponse
     */
    public function publishAction(string $id)
    {
        return new JsonResponse("ok");
    }
}
