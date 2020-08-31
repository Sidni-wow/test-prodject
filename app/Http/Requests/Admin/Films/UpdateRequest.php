<?php

namespace App\Http\Requests\Admin\Films;

use App\Base\Request;
use App\Models\StaticFile;

class UpdateRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1024',
            'published_at' => 'sometimes|nullable|accepted',
            'watch_soon_at' => 'sometimes|nullable|date',
            'image' => 'filled|image|mimes:jpeg,png|max:4096',
        ];
    }

    /**
     * @param array $validated
     *
     * @return array
     */
    protected function processValidated(array $validated): array
    {
        if ($this->hasFile('image')) {
            $staticFile = (new StaticFile());
            $staticFile->init($this->file('image'), StaticFile::CLIENT_DISK)->saveFile();
            $validated['image'] = $staticFile->getPath() . $staticFile->getHashName();
        }

        $validated['published_at'] = isset($validated['published_at']) ? now() : null;

        return $validated;
    }
}
