<?php

namespace App\Models\Concerns;

/**
 * Picks the current-locale value of a `{field}_{locale}` column pair
 * (e.g. name_en / name_ar), falling back to English.
 */
trait HasTranslatableFields
{
    public function localized(string $field): ?string
    {
        $locale = app()->getLocale();

        return $this->{"{$field}_{$locale}"} ?? $this->{"{$field}_en"} ?? null;
    }
}
