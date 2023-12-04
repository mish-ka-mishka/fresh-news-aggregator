<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var \App\Models\Article $this */

        return [
            'id' => $this->public_id,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'published_at' => $this->published_at->toAtomString(),
            'author' => $this->author,
            'source' => $this->source,
            'cover_url' => $this->cover_url,
        ];
    }
}
