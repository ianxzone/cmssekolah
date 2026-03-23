<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUniqueSlug
{
    /**
     * Boot the trait.
     */
    protected static function bootHasUniqueSlug()
    {
        static::creating(function ($model) {
            $model->generateUniqueSlug();
        });

        static::updating(function ($model) {
            if ($model->isDirty('title') && !$model->isDirty('slug')) {
                $model->generateUniqueSlug();
            }
        });
    }

    /**
     * Generate a unique slug for the model.
     */
    public function generateUniqueSlug()
    {
        $baseSlug = Str::slug($this->slug ?: $this->title);
        $slug = $baseSlug;
        $counter = 2;

        while ($this->slugExists($slug)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $this->slug = $slug;
    }

    /**
     * Check if the slug exists in the model's table.
     */
    protected function slugExists($slug)
    {
        $query = static::where('slug', $slug);

        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }
}
