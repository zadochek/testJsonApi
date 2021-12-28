<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

use function App\Http\Controllers\filterNotNull;

/**
 * Class DocumentService
 * @package App\Services
 *
 * @author Teleshov Zakhar
 */
class DocumentService
{
    /**
     * @param int $perPage
     * @return Collection
     */
    public function getAllDocuments(int $perPage): Collection
    {
        $documents = Document::orderBy('created_at', 'desc')->paginate($perPage);
        $pagination = collect([
            'page' => $documents->currentPage(),
            'perPage' => $perPage,
            'total' => $documents->total(),
        ]);
        return collect([
           'documents' => $documents->items(),
           'pagination' => $pagination,
        ]);
    }

    /**
     * @return Document
     */
    public function createDocument(): Document
    {
        $document = new Document();
        $document->id = Str::uuid();
        $document->payload = json_encode([]);
        $document->status = 'draft';
        $document->save();
        return $document;
    }


    /**
     * @param array $data
     * @param object $document
     * @return object
     */
    public function updateDocument(array $data, object $document): object
    {
            $payload = json_decode($document['payload'], true);
            $merge = array_merge($payload, $data['document']['payload']);
            $document->fill(['payload' => $this->filterNotNull($merge)]);
            $document->save();
            return $document;
    }

    public function publishedDocument(string $documentId)
    {
        $document = Document::findOrFail($documentId);
        $document->status = 'published';
        $document->save();
        $document->payload = json_decode($document->payload);
        return $document;
    }

    public function filterNotNull($array) {
        $array = array_map(function($item) {
            return is_array($item) ? $this->filterNotNull($item) : $item;
        }, $array);
        return array_filter($array, function($item) {
            return $item !== "" && $item !== null && (!is_array($item) || count($item) > 0);
        });
    }
}
