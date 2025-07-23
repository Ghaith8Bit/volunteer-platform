<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'reporter_id',
        'reason',
        'status',
        'user_id',
        'opportunity_id',
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
}
