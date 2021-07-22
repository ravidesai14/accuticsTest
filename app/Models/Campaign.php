<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Campaign
 * @package App\Models
 * @OA\Schema(
 *     title="Campaign"
 * )
 */
class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id'
    ];

    /**
     * @OA\Property()
     * @var integer
     */
    private $id;

    /**
     * @OA\Property()
     * @var integer
     */
    private $user_id;

    /**
     * @OA\Property()
     * @var datetime
     */
    private $created_at;

    /**
     * @OA\Property()
     * @var datetime
     */
    private $updated_at;

    /**
     *  @OA\Property(
     *      property="inputs",type="array",
     *      @OA\Items(ref="#/components/schemas/Input")
     *  )
    */

    public function inputs()
    {
        return $this->hasMany(Input::class);
    }

    /**
     *  @OA\Property(
     *          property="user",
     *          ref="#/components/schemas/User"
     *   )
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
