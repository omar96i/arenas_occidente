<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EMInspection extends Model
{
    use HasFactory;

    protected $casts = [
        'hourometer' => 'json',
        'property_card' => 'json',
        'soat' => 'json',
        'technomechanical' => 'json',
        'company_card' => 'json',
        'ingenio_card' => 'json',
        'driving_license' => 'json',
        'helmet' => 'json',
        'boots' => 'json',
        'uniform' => 'json',
        'glasses' => 'json',
        'extinguisher' => 'json',
        'kit' => 'json',
        'reflective_tapes' => 'json',
        'cones' => 'json',
        'reflective_vest' => 'json',
        'anti_spill_kit' => 'json',
        'cleanliness' => 'json',
        'access_to_machine' => 'json',
        'ear_cap' => 'json',
        'frontal' => 'json',
        'left_side' => 'json',
        'right_side' => 'json',
        'rear' => 'json',
        'tires' => 'json',
        'mileage' => 'json',
        'leaks' => 'json',
        'pending' => 'json',
        'streetlights' => 'json',
        'stops' => 'json',
        'braking_lights' => 'json',
        'directional' => 'json',
        'parking_lot' => 'json',
        'interior_lights' => 'json',
        'reverse_alarm' => 'json',
        'whistle' => 'json',
        'nibs' => 'json',
        'how_i_drive' => 'json',
        'encarped' => 'json',
        'grease' => 'json',
        'brake_fluid' => 'json',
        'pedal_return' => 'json',
        'parking_brake' => 'json',
        'tubes' => 'json',
        'battery' => 'json',
        'electric_cables' => 'json',
        'refrigeration_system' => 'json',
        'coolant_level' => 'json',
        'oil_leaks_without' => 'json',
        'oil_leaks_with' => 'json',
        'engine_state' => 'json',
        'gear_box' => 'json',
        'fuel_tank' => 'json',
        'hydraulic_oil_tank' => 'json',
        'hydraulic_oil_cooler' => 'json',
        'hoses' => 'json',
        'engine_oil_level' => 'json',
        'visual_inspection_engine_oil' => 'json',
        'transmission_oil_level' => 'json',
        'transmission_oil_inspection' => 'json',
        'differential_oil_level' => 'json',
        'differential_oil_inspection' => 'json',
        'hydraulic_oil_level' => 'json',
        'hydraulic_oil_inspection' => 'json',
        'check_air_filters' => 'json',
        'filters_with_sunken' => 'json',
        'leaking_filters' => 'json',
        'visible_drive_organs' => 'json',
        'pen_and_shovel' => 'json',
        'warning_signs' => 'json',
        'stop_device' => 'json',
        'lifting_cylinders' => 'json',
        'articulation_cylinders' => 'json',
        'cylinder_pins' => 'json',
        'easy_access' => 'json',
        'seat' => 'json',
        'damaged_items' => 'json',
        'temperature_indicator' => 'json',
        'oil_indicator' => 'json',
        'fuel_indicator' => 'json',
        'battery_indicator' => 'json',
        'a_c' => 'json',
        'general_structure' => 'json',
        'doors' => 'json',
        'exhaust_pipe' => 'json',
        'front_left_1' => 'json',
        'front_right_2' => 'json',
        'middle_left_die_3' => 'json',
        'middle_left_die_4' => 'json',
        'middle_right_die_5' => 'json',
        'middle_right_die_6' => 'json',
        'last_left_die_7' => 'json',
        'last_left_die_8' => 'json',
        'last_right_die_9' => 'json',
        'last_right_die_10' => 'json',
        'spare_tires' => 'json',
        'wheels' => 'json',
        'nuts' => 'json',
        'tire_pressure' => 'json',
        'mirrors' => 'json',
        'windshield' => 'json',
    ];

    protected $fillable = [
        'equipment_machinery_id',
        'date',
        'hourometer',
        'property_card',
        'soat',
        'technomechanical',
        'company_card',
        'ingenio_card',
        'driving_license',
        'helmet',
        'boots',
        'uniform',
        'glasses',
        'extinguisher',
        'kit',
        'reflective_tapes',
        'cones',
        'reflective_vest',
        'anti_spill_kit',
        'cleanliness',
        'access_to_machine',
        'ear_cap',
        'frontal',
        'left_side',
        'right_side',
        'rear',
        'tires',
        'mileage',
        'leaks',
        'pending',
        'streetlights',
        'stops',
        'braking_lights',
        'directional',
        'parking_lot',
        'interior_lights',
        'reverse_alarm',
        'whistle',
        'nibs',
        'how_i_drive',
        'encarped',
        'grease',
        'brake_fluid',
        'pedal_return',
        'parking_brake',
        'tubes',
        'battery',
        'electric_cables',
        'refrigeration_system',
        'coolant_level',
        'oil_leaks_without',
        'oil_leaks_with',
        'engine_state',
        'gear_box',
        'fuel_tank',
        'hydraulic_oil_tank',
        'hydraulic_oil_cooler',
        'hoses',
        'engine_oil_level',
        'visual_inspection_engine_oil',
        'transmission_oil_level',
        'transmission_oil_inspection',
        'differential_oil_level',
        'differential_oil_inspection',
        'hydraulic_oil_level',
        'hydraulic_oil_inspection',
        'check_air_filters',
        'filters_with_sunken',
        'leaking_filters',
        'visible_drive_organs',
        'pen_and_shovel',
        'warning_signs',
        'stop_device',
        'lifting_cylinders',
        'articulation_cylinders',
        'cylinder_pins',
        'easy_access',
        'seat',
        'damaged_items',
        'temperature_indicator',
        'oil_indicator',
        'fuel_indicator',
        'battery_indicator',
        'a_c',
        'general_structure',
        'doors',
        'exhaust_pipe',
        'front_left_1',
        'front_right_2',
        'middle_left_die_3',
        'middle_left_die_4',
        'middle_right_die_5',
        'middle_right_die_6',
        'last_left_die_7',
        'last_left_die_8',
        'last_right_die_9',
        'last_right_die_10',
        'spare_tires',
        'wheels',
        'nuts',
        'tire_pressure',
        'mirrors',
        'windshield',
        'observations',
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

    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            // Actualizar datos del control de inspeccion
            $extinguisher = json_decode($model->extinguisher, true);
            $hourometer = json_decode($model->hourometer, true);

            $inspection_control = EMInspectionControl::latest()
                ->where('equipment_machinery_id', $model->equipment_machinery_id)
                ->first();

            if ($inspection_control) {

                $inspection_control->extinguisher_expiration = $extinguisher['date'];
                $inspection_control->hourometer = $hourometer['description'];
                $inspection_control->last_report = $model->date;
                $inspection_control->next_report = $inspection_control->last_report->copy()->addDays($inspection_control->frequency);

                // estado de la ultima inspeccion
                $daysUntilNextReport = $inspection_control->last_report->diffInDays(now());
                if ($daysUntilNextReport < 0) {
                    $inspection_control->status = 'PASADO';
                } elseif ($daysUntilNextReport < 7) {
                    $inspection_control->status = 'PROXIMO';
                } else {
                    $inspection_control->status = 'BUEN ESTADO';
                }

                $daysUntilExtinguisherExpiration = $inspection_control->extinguisher_expiration->diffInDays(now());
                if ($daysUntilExtinguisherExpiration < 0) {
                    $inspection_control->extinguisher_status = 'PASADO';
                } elseif ($daysUntilNextReport < 7) {
                    $inspection_control->extinguisher_status = 'PROXIMO';
                } else {
                    $inspection_control->extinguisher_status = 'BUEN ESTADO';
                }

                $inspection_control->save();
            }else{
                $new_inspection_control = new EMInspectionControl();
                $new_inspection_control->equipment_machinery_id = $model->equipment_machinery_id;
                $new_inspection_control->last_report = Carbon::now();
                $new_inspection_control->actual_report = '';
                $new_inspection_control->next_report = Carbon::now()->addDays(60);
                $new_inspection_control->hourometer = $hourometer['description'];
                $new_inspection_control->frequency = 60;
                $new_inspection_control->unit = 'dias';
                $new_inspection_control->status = 'BUEN ESTADO';
                $new_inspection_control->extinguisher_expiration = $extinguisher['date'];;
                $new_inspection_control->extinguisher_status = '';
                $new_inspection_control->save();
                $new_inspection_control->updateExtinguisherStatus();
            }
        });

        static::updating(function ($model) {
        });
    }
}
