<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\ClickFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read int $link_id
 * @property-read string|null $session_id_hash
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class Click extends Model
{
    /** @use HasFactory<ClickFactory> */
    use HasFactory;

    /**
     * The links that owns the click.
     *
     * @return BelongsTo<Link, $this>
     */
    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class);
    }
}
