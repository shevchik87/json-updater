<?php
declare(strict_types = 1);

namespace App\Component\Document;

use App\Component\Helper\GeneratorHelper;
use App\Entity\Document;
use App\Repository\DocumentRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Rs\Json\Merge\Patch;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var GeneratorHelper
     */
    private $generator;

    /**
     * @var Patch
     */
    private $patch;

    /**
     * DocumentManager constructor.
     * @param EntityManagerInterface $em
     * @param GeneratorHelper $generatorHelper
     * @param Patch $patch
     */
    public function __construct(EntityManagerInterface $em, GeneratorHelper $generatorHelper, Patch $patch)
    {
        $this->em = $em;
        $this->generator = $generatorHelper;
        $this->patch = $patch;
    }

    /**
     * @param int $userId
     * @return Document
     * @throws \Exception
     */
    public function createDocument(int $userId)
    {
        $document = new Document();
        $document
            ->setId($this->generator->generateUUID())
            ->setStatus(Document::STATUS_DRAFT)
            ->setPayload([])
            ->setCreatedAt(new \DateTime())
            ->setModifyAt(new \DateTime())
            ->setUserId($userId);
        $this->em->persist($document);
        $this->em->flush();

        return $document;
    }

    /**
     * @param string $documentId
     * @param string $payloadPatch
     * @return Document|null
     * @throws \Exception
     */
    public function updateDocument(string $documentId, string $payloadPatch)
    {
        try {
            $this->em->beginTransaction();
            /** @var DocumentRepository $repo */
            $repo = $this->em->getRepository(Document::class);

            $document = $repo->find($documentId, LockMode::PESSIMISTIC_WRITE);

            if (!$document) {
                throw new NotFoundHttpException('Document not found');
            }

            if ($document->isPublished()) {
                throw new HttpException(400,'Document is published');
            }

            $newPayload = $this->patch->apply($document->getPayload(), $payloadPatch);
            $document->setPayload(json_decode($newPayload, true));
            $document->setModifyAt(new \DateTime());
            $this->em->persist($document);
            $this->em->flush();
            $this->em->commit();
            return $document;
        } catch (\Exception $e) {
            $this->em->rollback();
            throw $e;
        }
    }

    /**
     * @param string $documentId
     * @return Document|null
     */
    public function publishDocument(string $documentId)
    {
        /** @var DocumentRepository $repo */
        $repo = $this->em->getRepository(Document::class);

        $repo->publish($documentId);

        return $repo->find($documentId);
    }
}
