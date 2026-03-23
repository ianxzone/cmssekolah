<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'event',
        'properties',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the user who performed the activity
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subject model (the thing that was acted upon)
     */
    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Scope for filtering by log name
     */
    public function scopeForLog($query, $logName)
    {
        return $query->where('log_name', $logName);
    }

    /**
     * Scope for filtering by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for filtering by event type
     */
    public function scopeForEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Get properties as array
     */
    public function getPropertiesAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    /**
     * Set properties from array
     */
    public function setPropertiesAttribute($value)
    {
        $this->attributes['properties'] = is_array($value) ? json_encode($value) : $value;
    }

    /**
     * Log a created event
     */
    public static function logCreated($user, $subject, $properties = null)
    {
        return static::create([
            'user_id' => $user->id,
            'log_name' => self::getLogName($subject),
            'description' => class_basename($subject) . ' created',
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'event' => 'created',
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log an updated event
     */
    public static function logUpdated($user, $subject, $properties = null)
    {
        return static::create([
            'user_id' => $user->id,
            'log_name' => self::getLogName($subject),
            'description' => class_basename($subject) . ' updated',
            'subject_type' => get_class($subject),
            'subject_id' => $subject->id,
            'event' => 'updated',
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log a deleted event
     */
    public static function logDeleted($user, $subject, $properties = null)
    {
        return static::create([
            'user_id' => $user->id,
            'log_name' => self::getLogName($subject),
            'description' => class_basename($subject) . ' deleted',
            'subject_type' => get_class($subject),
            'subject_id' => null, // Subject no longer exists
            'event' => 'deleted',
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get log name from subject
     */
    protected static function getLogName($subject): string
    {
        $className = class_basename($subject);
        
        // Map common models to log names
        $mapping = [
            'Post' => 'posts',
            'Page' => 'pages',
            'Category' => 'categories',
            'Tag' => 'tags',
            'Media' => 'media',
            'Event' => 'events',
            'Testimonial' => 'testimonials',
            'Form' => 'forms',
            'FormSubmission' => 'form_submissions',
            'User' => 'users',
            'Setting' => 'settings',
            'Role' => 'roles',
        ];

        return $mapping[$className] ?? strtolower($className . 's');
    }
}
