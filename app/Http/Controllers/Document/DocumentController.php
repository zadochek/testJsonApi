<?php

namespace App\Http\Controllers\Document;

use App\Http\Controllers\Controller;
use App\Http\Requests\Document\PaginateDocumentRequest;
use App\Models\Document;
use App\Services\DocumentService;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class DocumentController
 * @package App\Http\Controllers\Document
 *
 * @author Teleshov Zakhar
 */
class DocumentController extends Controller
{
    /**
     * @var DocumentService
     */
    private DocumentService $documentService;

    /**
     * @param DocumentService $documentService
     */
    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @param PaginateDocumentRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function index(PaginateDocumentRequest $request)
    {
        try {
            $collection = $this->documentService->getAllDocuments($request->perPage);
            return response($collection)->withHeaders(['application\json']);
        } catch (\Exception $e) {
            return $this->jsonException($e);
        }
    }

    /**
     * @return Application|ResponseFactory|Response|object
     */
    public function store()
    {
        try {
            $document = $this->documentService->createDocument();
            $document->payload = json_decode($document->payload);
            return response(['document' => $document])->withHeaders(['application\json'])->setStatusCode(201);
        } catch (\Exception $e) {
            return $this->jsonException($e);
        }
    }

    /**
     * @param Document $document
     * @return Application|ResponseFactory|Response
     */
    public function show(Document $document)
    {
        try {
            $document->payload = json_decode($document->payload, true);

            return response(['document' => $document])->withHeaders(['application/json']);
        } catch (\Exception $e) {
            return $this->jsonException($e);
        }
    }

    /**
     * @param Request $request
     * @param string $documentId
     * @return ResponseFactory|Application|Response
     */
    public function update(Request $request, string $documentId)
    {
        try {
            $data = json_decode($request->getContent(), true);
            $document = Document::findOrFail($documentId);
            if ($document->status == 'draft' && isset($data['document']['payload'])) {
                $document = $this->documentService->updateDocument($data, $document);
                return response($document)->withHeaders(['application/json']);
            } else {
                return response('', 400);
            }
        } catch (\Exception $e) {
            return $this->jsonException($e);
        }
    }

    public function publish(string $documentId)
    {
        try {
            $document = $this->documentService->publishedDocument($documentId);
            return response($document)->withHeaders(['application/json']);
        } catch (\Exception $e) {
            return $this->jsonException($e);
        }
    }
}
