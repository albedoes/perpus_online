<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BukuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'scientific_name' => $this->scientific_name ?? 'Tidak diketahui',
            'origin' => $this->origin ?? 'Tidak diketahui',
            'description' => $this->description ?? 'Tidak ada deskripsi',
            'image' => $this->getImageUrl(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get the correct image URL.
     */
    private function getImageUrl()
    {
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image; // Jika sudah berupa URL
        } elseif ($this->image) {
            return Storage::url($this->image); // Jika disimpan di storage Laravel
        }

        return url('storage/no-image.jpg'); // Default gambar jika tidak ada
    }
}
