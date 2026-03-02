<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'canal_venta',
        'numero_boleta',
        'user_id',
        'buyer_id',
        'client_id',
        'total',
        'status',
        'date',
        // Lifecycle fields
        'estado',
        'fecha_confirmacion_pago',
        'confirmado_por',
        // Legacy/POS fields
        'estado_pedido',
        // Legacy delivery fields (home delivery - future use)
        'delivery',
        'delivery_address',
        'delivery_district',
        'delivery_reference',
        'delivery_cost',
        // Pickup / "mi delivery" fields
        'tipo_entrega',
        'nombre_repartidor',
        'dni_repartidor',
        'telefono_repartidor',
        'empresa_delivery',
        'placa_vehiculo',
        'comprobante_yape',
    ];

    protected $casts = [
        'date' => 'datetime',
        'fecha_confirmacion_pago' => 'datetime',
        'delivery' => 'boolean',
        'total' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
    ];

    // ── Order states for Virtual Management ───────────────────────────────────

    const ESTADOS = [
        'pendiente_pago' => 'Pendiente de pago',
        'pagado' => 'Pagado / Confirmado',
        'preparando' => 'En preparación',
        'enviado' => 'Enviado / En camino',
        'entregado' => 'Entregado',
        'cancelado' => 'Cancelado',
    ];

    const TIPOS_ENTREGA = [
        'envio_domicilio' => 'Envío a domicilio',
        'recojo_tienda' => 'Recojo en tienda',
        'mi_delivery' => 'Mi delivery recoge en tienda',
    ];

    // ── Helpers ──────────────────────────────────────────────────────────────

    public function confirmador()
    {
        return $this->belongsTo(User::class, 'confirmado_por');
    }

    public function estadoLabel(): string
    {
        $hasPayment = $this->comprobante_yape || ($this->relationLoaded('payments') ? $this->payments->isNotEmpty() : $this->payments()->exists());

        if ($this->estado === 'pendiente_pago' && $hasPayment) {
            return 'En verificación (Pago)';
        }
        return self::ESTADOS[$this->estado] ?? ucfirst($this->estado);
    }

    public function estadoBadgeClass(): string
    {
        $hasPayment = $this->comprobante_yape || ($this->relationLoaded('payments') ? $this->payments->isNotEmpty() : $this->payments()->exists());

        if ($this->estado === 'pendiente_pago' && $hasPayment) {
            return 'bg-info bg-opacity-25 text-info border border-info';
        }

        return match ($this->estado) {
            'pendiente_pago', 'pendiente' => 'bg-pending',
            'pagado', 'entregado' => 'bg-completed',
            'preparando', 'enviado' => 'bg-shipping',
            'cancelado' => 'bg-cancelled',
            default => 'bg-secondary text-white'
        };
    }

    public function estadoIcon(): string
    {
        $hasPayment = $this->comprobante_yape || ($this->relationLoaded('payments') ? $this->payments->isNotEmpty() : $this->payments()->exists());

        if ($this->estado === 'pendiente_pago' && $hasPayment) {
            return 'fa-search-dollar';
        }

        return match ($this->estado) {
            'pendiente_pago' => 'fa-wallet',
            'pendiente' => 'fa-clock',
            'pagado' => 'fa-check-circle',
            'preparando' => 'fa-box-open',
            'enviado' => 'fa-truck-fast',
            'entregado' => 'fa-house-circle-check',
            'cancelado' => 'fa-circle-xmark',
            default => 'fa-question-circle'
        };
    }

    public function estadoPedidoLabel(): string
    {
        return self::ESTADOS[$this->estado_pedido] ?? ucfirst($this->estado_pedido);
    }

    public function tipoEntregaLabel(): string
    {
        return self::TIPOS_ENTREGA[$this->tipo_entrega] ?? ucfirst($this->tipo_entrega);
    }

    public function esDeliveryPropio(): bool
    {
        return $this->tipo_entrega === 'mi_delivery';
    }

    /** Calculated grand total including delivery cost (always 0 for pickup). */
    public function grandTotal(): float
    {
        return (float) ($this->total + ($this->delivery_cost ?? 0));
    }

    // ── Relationships ─────────────────────────────────────────────────────────

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** The authenticated buyer (comprador) who placed the order online. */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(SalePayment::class);
    }
}
