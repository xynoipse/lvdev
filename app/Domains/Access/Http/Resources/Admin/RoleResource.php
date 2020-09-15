<?php

namespace App\Domains\Access\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'permissions' => array_map(
                function ($permissions) {
                    return $permissions['name'];
                },
                $this->permissions->toArray()
            ),
        ];
    }
}
