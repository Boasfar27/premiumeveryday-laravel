<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'label',
        'description',
        'sort_order',
        'is_public',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_public' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, $default = null)
    {
        // Try to get from cache first
        if (Cache::has('setting.' . $key)) {
            return Cache::get('setting.' . $key);
        }

        // If not in cache, get from database
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        // Cast the value based on type
        $value = self::castValue($setting->value, $setting->type);
        
        // Cache the result
        Cache::put('setting.' . $key, $value, now()->addDay());
        
        return $value;
    }
    
    /**
     * Set a setting value
     *
     * @param string $key
     * @param mixed $value
     * @param array $attributes Additional attributes to set
     * @return \App\Models\Setting
     */
    public static function set(string $key, $value, array $attributes = [])
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            array_merge(['value' => $value], $attributes)
        );
        
        // Clear the cache for this key
        Cache::forget('setting.' . $key);
        
        return $setting;
    }
    
    /**
     * Cast value based on setting type
     *
     * @param string $value
     * @param string $type
     * @return mixed
     */
    protected static function castValue($value, $type)
    {
        return match ($type) {
            'boolean' => (bool) $value,
            'number' => is_numeric($value) ? (float) $value : 0,
            'json' => json_decode($value, true),
            default => $value,
        };
    }
    
    /**
     * Clear all settings cache
     *
     * @return void
     */
    public static function clearCache()
    {
        $settings = self::all();
        
        foreach ($settings as $setting) {
            Cache::forget('setting.' . $setting->key);
        }
    }
}
