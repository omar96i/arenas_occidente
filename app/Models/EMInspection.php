<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EMInspection extends Model
{
    use HasFactory;

    protected $casts = [
        'hourometer' => 'json',
        'extinguisher' => 'json',
        'brake_leaks' => 'json',
        'brakes_humidity' => 'json',
        'leak_hoses' => 'json',
        'cats_leak' => 'json',
        'cervo_fuga' => 'json',
        'engine_oil_leak' => 'json',
        'engine_water_leak' => 'json',
        'motor_leak_acpm' => 'json',
        'leak_transmissions' => 'json',
        'hydraulic_pump_leak' => 'json',
        'bomb_deer' => 'json',
        'radiator_leaks' => 'json',
        'fan_retainer_change' => 'json',
        'straps_change_belts' => 'json',
        'swing_motor_leaks' => 'json',
        'bucket_changing_blades' => 'json',
        'bushings_change_of_hubs' => 'json',
        'tires_change' => 'json',
        'news' => 'json',
        'lc_cabin_upper_streetlights' => 'json',
        'lc_side_lights' => 'json',
        'lc_rear_lights_upper_cabin' => 'json',
        'lc_rear_lights_side_hood' => 'json',
        'lc_stop' => 'json',
        'lc_reverse_alarm' => 'json',
        'lc_light_media' => 'json',
        'lc_stationary' => 'json',
        'lc_pito' => 'json',
        'lc_temperature_relog' => 'json',
        'lc_horometer' => 'json',
        'lc_relog_oil_pressure' => 'json',
        'lc_battery_indicator' => 'json',
        'lc_welding' => 'json',
        'news_2' => 'json',
        'brakes_bearings' => 'json',
        'bushing_bar_terminals' => 'json',
        'leaf_springs' => 'json',
        'turbo_leaks' => 'json',
        'oil_cooler_leaks' => 'json',
        'valves_oil_leaks' => 'json',
        'air_compressor_status' => 'json',
        'fan_clutch' => 'json',
        'clutch_crutch_state' => 'json',
        'dryer_valve' => 'json',
        'take_strenght' => 'json',
        'cardal_cross' => 'json',
        'gearbox' => 'json',
        'address_box' => 'json',
        'lc_main' => 'json',
        'lc_board' => 'json',
        'lc_exploradoras' => 'json',
        'lc_feathers_change' => 'json',
        'lc_motor_emcarpado' => 'json',
    ];

    protected $fillable = [
        'equipment_machinery_id',
        'date',
        'type',
        'hourometer',
        'extinguisher',
        'brake_leaks',
        'brakes_humidity',
        'leak_hoses',
        'cats_leak',
        'cervo_fuga',
        'engine_oil_leak',
        'engine_water_leak',
        'motor_leak_acpm',
        'leak_transmissions',
        'hydraulic_pump_leak',
        'bomb_deer',
        'radiator_leaks',
        'fan_retainer_change',
        'straps_change_belts',
        'swing_motor_leaks',
        'bucket_changing_blades',
        'bushings_change_of_hubs',
        'tires_change',
        'news',
        'lc_cabin_upper_streetlights',
        'lc_side_lights',
        'lc_rear_lights_upper_cabin',
        'lc_rear_lights_side_hood',
        'lc_stop',
        'lc_reverse_alarm',
        'lc_light_media',
        'lc_stationary',
        'lc_pito',
        'lc_temperature_relog',
        'lc_horometer',
        'lc_relog_oil_pressure',
        'lc_battery_indicator',
        'lc_welding',
        'news_2',
        'brakes_bearings',
        'bushing_bar_terminals',
        'leaf_springs',
        'turbo_leaks',
        'oil_cooler_leaks',
        'valves_oil_leaks',
        'air_compressor_status',
        'fan_clutch',
        'clutch_crutch_state',
        'dryer_valve',
        'take_strenght',
        'cardal_cross',
        'gearbox',
        'address_box',
        'lc_main',
        'lc_board',
        'lc_exploradoras',
        'lc_feathers_change',
        'lc_motor_emcarpado',
    ];

    /**
     * Get the equipment_machinery that owns the EMInspection
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment_machinery(): BelongsTo
    {
        return $this->belongsTo(EquipmentMachinery::class, 'equipment_machinery_id');
    }
}
