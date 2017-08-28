<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Favorite
 * @package App
 */
class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
