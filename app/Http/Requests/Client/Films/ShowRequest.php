<?php

namespace App\Http\Requests\Client\Films;

use App\Base\Request;

class ShowRequest extends Request
{
    public function authorize(): bool
    {
        return $this->film->isPublished();
    }
}
