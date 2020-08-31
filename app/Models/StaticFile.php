<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @property string extension
 * @property string name
 * @property string origin_name
 * @property string link
 */
class StaticFile extends Model
{
    const CLIENT_DISK = 'client';

    protected $appends = ['link'];

    protected $file;

    protected $depth = 3;

    protected $path;

    protected $extension;

    protected $hashName;

    protected $originalName;

    protected $nameFolder;

    public function staticFileAble(): MorphTo
    {
        return $this->morphTo();
    }

    public function getLinkAttribute()
    {
        return $this->attributes['link'] = $this->getLink();
    }

    /**
     * @param UploadedFile $file
     * @param string $nameFolder
     *
     * @return $this
     */
    public function init(UploadedFile $file, $nameFolder = self::CLIENT_DISK): self
    {
        $this->nameFolder = $nameFolder;
        $this->file = $file;
        $this->hashName = $file->hashName();
        $this->extension = $file->getClientOriginalExtension();
        $this->originalName = $file->getClientOriginalName();

        return $this;
    }

    /**
     * @return string
     */
    public function saveFile(): string
    {
        $this->file->store($this->getPath(), $this->nameFolder);

        return $this;
    }

    public function getLink()
    {
        return Storage::disk($this->nameFolder)->url($this->getPath() . $this->name);
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return Storage::disk($this->nameFolder)->getDriver()->getAdapter()->getPathPrefix() . $this->getPath() . $this->name;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        if (is_null($this->path)) {
            $nameTmp = $this->hashName ?? $this->name;
            $this->depth = ($this->depth > strlen($nameTmp)) ? strlen($nameTmp) : $this->depth;

            for ($i = 0; $i < $this->depth; $i++) {
                $this->path .= "{$nameTmp[$i]}" . DIRECTORY_SEPARATOR;
            }
        }

        return $this->path;
    }

    /**
     * @return string|null
     */
    public function getExtension(): ?string
    {
        return $this->extension;
    }

    /**
     * @return string|null
     */
    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    /**
     * @return string|null
     */
    public function getHashName(): ?string
    {
        return $this->hashName;
    }
}
