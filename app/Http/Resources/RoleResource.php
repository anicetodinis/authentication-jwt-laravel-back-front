<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'guard_name' => $this->guard_name, // Geralmente será 'web' ou 'api'
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')), // Incluir permissões
            'created_at' => $this->created_at->format('d/m/Y H:i:s'),
        ];
    }
}
