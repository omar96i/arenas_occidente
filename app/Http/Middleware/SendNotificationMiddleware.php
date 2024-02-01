<?php

namespace App\Http\Middleware;

use App\Models\EMInspectionControl;
use App\Models\EquipmentMachinery;
use App\Models\EquipmentMachinerySoat;
use App\Models\EquipmentMachinerySure;
use App\Models\EquipmentMachineryTechno;
use App\Models\MaintenanceScheduling;
use App\Models\Notification;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\isNull;

class SendNotificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $recipientEmail = "administracion@arenasdeoccidente.com"; //correo al que se envia
        $notification = Notification::where('email', $recipientEmail)->first();

        if (!$notification || $this->validateNotification($notification)) {
            $inspections = $this->updateInspections();
            $extinguishers = $this->updateExtinguisher();
            $schedules = $this->updateSchedules();
            $documents = $this->updateDocuments();



            // aqui se envia la notificacion al correo----------

            Mail::send('email.notifications', [
                'documents' => $documents,
                'inspections' => $inspections,
                'schedules' => $schedules,
                'extinguishers' => $extinguishers,

            ], function ($message) use ($recipientEmail) {
                $message->to($recipientEmail);
            });

            // --------------------------------------------------

            // cambiar estado de la notificacion
            if (!$notification) {
                $notification = new Notification(['email' => $recipientEmail]);
            }
            $notification->notification_sent = true;
            $notification->save();
        }

        return $next($request);
    }

    protected function validateNotification($notification)
    {
        if ($notification->updated_at->isToday() && !$notification->notification_sent) {
            return true;
        } else {
            return false;
        }
    }

    protected function updateInspections()
    {
        // actualizacion diaria de estado del control de la inspeccion
        $inspection_controls = EMInspectionControl::whereIn('status', ['PASADO', 'PROXIMO'])->get();
        foreach ($inspection_controls as $inspection_control) {
            $inspection_control->updateStatus();
        }

        return EMInspectionControl::whereIn('status', ['PASADO', 'PROXIMO'])->get();
    }

    protected function updateSchedules()
    {
        $maintenance_scehdulings = MaintenanceScheduling::whereIn('status', ['PASADO', 'PROXIMO', 'BUEN ESTADO'])->get();
        foreach ($maintenance_scehdulings as $maintenance_scehduling) {
            $maintenance_scehduling->updateStatus();
        }

        return MaintenanceScheduling::whereIn('status', ['PASADO', 'PROXIMO'])->get();
    }

    protected function updateDocuments()
    {
        $equipments = EquipmentMachinery::with(['soats' => function ($query) {
            $query->latest()->first();
        }], ['technos' => function ($query) {
            $query->latest()->first();
        }], ['insurance' => function ($query) {
            $query->latest()->first();
        }])->get();

        foreach ($equipments as $equipment) {
            if ($eq_soat = $equipment->soats->first()) {
                $eq_soat->updateStatus();
            }
        
            if ($eq_techno = $equipment->technos->first()) {
                $eq_techno->updateStatus();
            }
        
            if ($eq_sure = $equipment->insurance->first()) {
                $eq_sure->updateStatus();
            }
        }

        $today = Carbon::now();

        $equipment_machinery_soats = EquipmentMachinerySoat::where(function ($query) use ($today) {
            $query->whereBetween('validity', [$today, $today->copy()->addDays(60)]);
        })->orWhere('status', 'Expirado')->get();

        $equipment_machinery_sure = EquipmentMachinerySure::where(function ($query) use ($today) {
            $query->whereBetween('validity', [$today, $today->copy()->addDays(60)]);
        })->orWhere('status', 'Expirado')->get();

        $equipment_machinery_techno = EquipmentMachineryTechno::where(function ($query) use ($today) {
            $query->whereBetween('date_revision', [$today, $today->copy()->addDays(60)]);
        })->orWhere('status', 'Expirado')->get();

        return [
            'equipment_machinery_soats' => $equipment_machinery_soats,
            'equipment_machinery_sure' => $equipment_machinery_sure,
            'equipment_machinery_techno' => $equipment_machinery_techno,
        ];
    }

    protected function updateExtinguisher()
    {
        $equipments = EquipmentMachinery::with(['inspection_control' => function ($query) {
            $query->latest()->first();
        }])->get();

        foreach ($equipments as $equipment) {
            if ($equipment->inspection_control->isNotEmpty()) {
                $latestInspection = $equipment->inspection_control->first();
                $latestInspection->updateExtinguisherStatus();
            }
        }

        return EMInspectionControl::whereIn('extinguisher_status', ['PASADO', 'PROXIMO'])->get();
    }
}
