<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @OA\Schema(
 *     title="User"
 * )
 */

class User extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email'
    ];

    /**
     * @OA\Property()
     * @var integer
     */
    private $id;
    
    /**
     * @OA\Property()
     * @var string
     */
    private $name;

    /**
     * @OA\Property()
     * @var string
     */
    private $email;

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
}
