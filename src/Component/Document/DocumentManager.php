<?php

namespace App\Component\Document;

use App\Component\Helper\GeneratorHelper;
use App\Entity\Document;
use App\Repository\DocumentRepository;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManagerInterface;
use Rs\Json\Merge\Patch;

class DocumentManager
{
    private $em;

    private $generator;

    public function __construct(EntityManagerInterface $em, GeneratorHelper $generatorHelper)
    {
        $this->em = $em;
        $this->generator = $generatorHelper;
    }

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

    public function updateDocument(string $documentId, string $payloadPatch)
    {
        $this->em->beginTransaction();
        /** @var DocumentRepository $repo */
        $repo = $this->em->getRepository(Document::class);

        $document = $repo->find($documentId, LockMode::PESSIMISTIC_WRITE);

        $patch = new Patch();
        $newPayload = $patch->apply($document->getPayload(), $payloadPatch);
        $document->setPayload(json_decode($newPayload, true));
        $document->setModifyAt(new \DateTime());
        $this->em->persist($document);
        $this->em->flush();
        $this->em->commit();
        return $document;
    }

    public function publishDocument(string $documentId)
    {
        /** @var DocumentRepository $repo */
        $repo = $this->em->getRepository(Document::class);
        $repo->publish($documentId);
    }
}
