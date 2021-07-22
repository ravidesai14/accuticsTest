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
class Input extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'campaign_id','type','value'
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
    private $campaign_id;

    /**
     * @OA\Property(description="channel,source,campaign_name,target_url")
     * @var string
     */
    private $type;

    /**
     * @OA\Property()
     * @var string
     */
    private $value;

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
    
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
