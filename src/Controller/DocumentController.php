<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Component\Document\DocumentManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    public function createAction(DocumentManager $manager)
    {
        $user = $this->getUserEntity();
        $document = $manager->createDocument($user->getId());

        return $this->response($document, JSON_FORCE_OBJECT);
    }

    /**
     * @Route("/api/v1/document/{id}", name="get_one_document", methods={"GET"})
     * @param string $id
     */
    public function getOneDocumentAction(string $id)
    {
        $doc = $this->getDoctrine()->getRepository(DocumentManager::class)->find($id);
        return $this->response($doc);
    }

    /**
     * @Route("/api/v1/document/{id}", name="update_document", methods={"PATCH"})
     * @param string $id
     */
    public function updateAction(Request $request, DocumentManager $manager, string $id)
    {
        $payload = $this->getPayload($request);
        $user = $this->getUserEntity();
        if (!$payload) {
            return new JsonResponse("Payload is required", 400);
        }


        $document = $manager->updateDocument($id, $payload);

        return $this->response($document);
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
