<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\LinkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read int $id
 * @property-read string $url
 * @property-read string|null $slug
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class Link extends Model
{
    /** @use HasFactory<LinkFactory> */
    use HasFactory;

    /**
     * Get the clicks for this link.
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }
}
