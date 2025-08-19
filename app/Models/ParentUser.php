<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\ParentUser
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $occupation
 * @property string|null $emergency_contact
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Student> $children
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ParentUser whereUpdatedAt($value)
 * @method static \Database\Factories\ParentUserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ParentUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'parents';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'occupation',
        'emergency_contact',
    ];

    /**
     * Get the user that owns the parent record.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the children (students) associated with this parent.
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
            ->withPivot('relationship')
            ->withTimestamps();
    }
}