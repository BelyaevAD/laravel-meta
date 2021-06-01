<?php

namespace BelyaevAD\Meta;

trait Metable
{

    /**
     *  Load data or check loading
     */
    private function metaLoad()
    {
        $this->meta ??= $this?->relations['meta'] ?? $this->meta()->get();
    }

    /**
     *  ReLoadd data or check loading
     */
    public function metaReLoad()
    {
        return $this->meta = $this->meta()->get();
    }

    /**
     * Get all meta.
     *
     * @return object
     */
    public function getAllMeta()
    {
        return collect($this->meta()->pluck('value', 'key'));
    }

    /**
     * Has meta.
     *
     * @param string $key
     * @return bool
     */
    public function hasMeta($key)
    {
        $this->metaLoad();

        $meta = $this->meta->where('key', $key);

        return (bool)count($meta);
    }

    /**
     * Get meta.
     *
     * @param string $key
     * @param mixed $default
     * @return object
     */
    public function getMeta($key, $default = null)
    {
        $this->metaLoad();

        if ($meta = $this->meta->where('key', $key)->first()) {
            return $meta;
        }

        return $default;
    }

    /**
     * Get meta value.
     *
     * @param string $key
     * @return object
     */
    public function getMetaValue($key)
    {
        return $this->hasMeta($key) ? $this->getMeta($key)->value : null;
    }

    /**
     * Add meta.
     *
     * @param string $key
     * @param mixed $value
     */
    public function addMeta($key, $value)
    {
        if (!$this->meta()->where('key', $key)->count()) {
            return $this->meta()->create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    /**
     * Update or create meta.
     *
     * @param string $key
     * @param mixed $value
     * @return object|bool
     */
    public function addOrUpdateMeta($key, $value)
    {
        return $this->updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Update meta.
     *
     * @param string $key
     * @param mixed $value
     * @return object|bool
     */
    public function updateMeta($key, $value)
    {
        if ($meta = $this->getMeta($key)) {
            $meta->value = $value;

            return $meta->save();
        }

        return false;
    }

    /**
     * Delete meta.
     *
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function deleteMeta($key, $value = null)
    {
        return $value
            ? $this->meta()->where('key', $key)->where('value', $value)->delete()
            : $this->meta()->where('key', $key)->delete();
    }

    /**
     * Delete all meta.
     *
     * @return bool
     */
    public function deleteAllMeta()
    {
        return $this->meta()->delete();
    }

    /**
     * Meta relation.
     *
     * @return object
     */
    public function meta()
    {
        return $this->morphMany(\BelyaevAD\Meta\Meta::class, 'metable');
    }
}
