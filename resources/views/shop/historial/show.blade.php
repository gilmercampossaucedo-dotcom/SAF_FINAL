@extends('layouts.shop')

@section('title', 'Detalle de Pedido #' . $sale->id . ' — StyleBox Premium')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --premium-bg: #f8fafc;
            --premium-surface: #ffffff;
            --premium-accent: #c9a84c;
            --premium-text: #0f172a;
            --premium-text-muted: #64748b;
            --premium-border: #e2e8f0;
            --premium-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        .detail-page {
            font-family: 'Inter', sans-serif;
            background: var(--premium-bg);
            min-height: 100vh;
            padding: 3rem 0 6rem;
        }

        .detail-container {
            max-width: 900px;
            margin: 0 auto;
        }

        /* ── TOP NAVIGATION ── */
        .top-nav-pro {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .btn-back-pro {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--premium-text-muted);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .btn-back-pro:hover {
            color: var(--premium-text);
        }

        /* ── MAIN CARD ── */
        .order-detail-card {
            background: var(--premium-surface);
            border-radius: 2rem;
            box-shadow: var(--premium-shadow);
            overflow: hidden;
            border: 1px solid var(--premium-border);
        }

        /* Detail Header */
        .detail-header-pro {
            background: #1e293b;
            color: #ffffff;
            padding: 2.5rem;
            position: relative;
        }

        .detail-header-pro .order-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.15em;
            color: #94a3b8;
            margin-bottom: 0.5rem;
        }

        .detail-header-pro h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .detail-header-pro .order-date {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Status Badge in Detail */
        .status-badge-detail {
            position: absolute;
            top: 2.5rem;
            right: 2.5rem;
            padding: 0.75rem 1.75rem;
            border-radius: 50px;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* ── SHIPMENT & TRACKING ── */
        .section-pro {
            padding: 2.5rem;
            border-bottom: 1px solid var(--premium-border);
        }

        .section-title-pro {
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 1.75rem;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--premium-text);
        }

        .section-title-pro i {
            color: var(--premium-accent);
        }

        /* Tracking Timeline (Larger for Detail) */
        .tracking-detail-pro {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin: 2rem 0;
        }

        .tracking-detail-pro::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 2rem;
            right: 2rem;
            height: 4px;
            background: #f1f5f9;
            z-index: 1;
        }

        .td-step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100px;
        }

        .td-dot {
            width: 32px;
            height: 32px;
            background: #ffffff;
            border: 4px solid #f1f5f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .td-label {
            font-size: 0.7rem;
            font-weight: 700;
            margin-top: 12px;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .td-step.done .td-dot {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .td-step.done .td-label {
            color: #1e293b;
        }

        .td-step.active .td-dot {
            background: #ffffff;
            border-color: #6366f1;
            box-shadow: 0 0 0 5px rgba(99, 102, 241, 0.1);
        }

        .td-step.active .td-label {
            color: #6366f1;
        }

        /* ── PRODUCT LIST ── */
        .product-row-pro {
            display: flex;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .product-row-pro:last-child {
            border-bottom: none;
        }

        .product-img-detail {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--premium-border);
            flex-shrink: 0;
        }

        .product-img-detail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info-pro {
            flex-grow: 1;
            padding: 0 1.5rem;
        }

        .product-info-pro h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: var(--premium-text);
        }

        .product-variant-badge {
            display: inline-block;
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.65rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
            margin-right: 6px;
        }

        .product-price-pro {
            text-align: right;
            min-width: 100px;
        }

        .product-price-pro .total {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--premium-text);
        }

        .product-price-pro .sub {
            font-size: 0.75rem;
            color: var(--premium-text-muted);
        }

        /* ── TOTALS ── */
        .totals-section-pro {
            background: #f8fafc;
            padding: 2.5rem;
        }

        .total-row-pro {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .total-row-pro.grand-total {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid var(--premium-border);
            font-size: 1.5rem;
            font-weight: 800;
            color: #1e293b;
        }

        /* ── INFO BLOCKS ── */
        .info-grid-pro {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            padding: 2.5rem;
        }

        .info-block-pro h5 {
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 1rem;
        }

        .info-content-pro {
            font-size: 0.95rem;
            line-height: 1.6;
            color: var(--premium-text);
        }

        /* ── MOBILE ── */
        @media (max-width: 768px) {
            .detail-header-pro {
                padding: 1.5rem;
            }

            .status-badge-detail {
                position: static;
                margin-top: 1rem;
                display: block;
                text-align: center;
            }

            .tracking-detail-pro {
                display: none;
            }

            .info-grid-pro {
                grid-template-columns: 1fr;
            }

            .product-row-pro {
                flex-wrap: wrap;
            }

            .product-price-pro {
                width: 100%;
                text-align: left;
                margin-top: 1rem;
                margin-left: 95px;
            }
        }
    </style>
@endpush

@php
    $timelineSteps = [
        ['key' => 'pendiente_pago', 'label' => 'Pedido'],
        ['key' => 'pagado', 'label' => 'Confirmado'],
        ['key' => 'preparando', 'label' => 'Empacando'],
        ['key' => 'enviado', 'label' => 'En Camino'],
        ['key' => 'entregado', 'label' => 'Entregado']
    ];

    function getDStepStatus($orderStatus, $stepKey)
    {
        $statusOrder = ['pendiente_pago' => 0, 'pendiente' => 0, 'pagado' => 1, 'preparando' => 2, 'enviado' => 3, 'entregado' => 4];
        $currentOrder = $statusOrder[$orderStatus] ?? -1;
        $stepOrder = $statusOrder[$stepKey] ?? 0;

        if ($currentOrder > $stepOrder)
            return 'done';
        if ($currentOrder === $stepOrder)
            return 'active';
        return 'future';
    }
@endphp

@section('content')
    <div class="detail-page">
        <div class="container detail-container">

            {{-- TOP NAVIGATION --}}
            <div class="top-nav-pro">
                <a href="{{ route('historial.index') }}" class="btn-back-pro">
                    <i class="fas fa-arrow-left"></i> Volver a mis compras
                </a>
                @if($sale->numero_boleta)
                    <a href="{{ route('checkout.boleta', $sale) }}" target="_blank" class="btn-back-pro text-dark">
                        <i class="fas fa-file-invoice"></i> Ver Boleta
                    </a>
                @endif
            </div>

            {{-- MAIN CONTENT CARD --}}
            <div class="order-detail-card">

                {{-- Header --}}
                <div class="detail-header-pro">
                    <div class="order-label">Resumen del Pedido</div>
                    <h2>{{ $sale->numero_boleta ?: 'Pedido #' . str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h2>
                    <div class="order-date">Realizado el {{ $sale->date->format('d \d\e F, Y \a \l\a\s H:i') }}</div>

                    <div class="status-badge-detail {{ $sale->estadoBadgeClass() }}">
                        <i class="fas {{ $sale->estadoIcon() }} me-2"></i> {{ $sale->estadoLabel() }}
                    </div>

                        @php $hasAnyPayment = $sale->comprobante_yape || $sale->payments()->exists(); @endphp

                    @if($sale->estado === 'pendiente_pago' && !$hasAnyPayment)
                        <div class="mt-4">
                            <button type="button" class="btn btn-warning fw-bold px-4 py-2 rounded-pill shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#yapeModal" onclick="initYapeQR()">
                                <i class="fas fa-wallet me-2"></i> COMPLETAR PAGO / SUBIR COMPROBANTE
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Tracking --}}
                @if($sale->estado !== 'cancelado')
                    <div class="section-pro">
                        <div class="section-title-pro"><i class="fas fa-truck-fast"></i> Seguimiento del Pedido</div>
                        <div class="tracking-detail-pro">
                            @foreach($timelineSteps as $step)
                                @php $status = getDStepStatus($sale->estado, $step['key']); @endphp
                                <div class="td-step {{ $status }}">
                                    <div class="td-dot">
                                        @if($status === 'done') <i class="fas fa-check"></i> @endif
                                    </div>
                                    <div class="td-label">{{ $step['label'] }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Products --}}
                <div class="section-pro">
                    <div class="section-title-pro"><i class="fas fa-basket-shopping"></i> Productos en tu Pedido</div>
                    <div class="order-products-list-pro">
                        @foreach($sale->details as $detail)
                            <div class="product-row-pro">
                                <div class="product-img-detail">
                                    @if($detail->product?->image)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}"
                                            alt="{{ $detail->product->name }}">
                                    @else
                                        <div
                                            class="bg-secondary-subtle h-100 d-flex align-items-center justify-content-center text-secondary">
                                            <i class="fas fa-image fs-3"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info-pro">
                                    <h4>{{ $detail->product?->name }}</h4>
                                    <div>
                                        @if($detail->talla)
                                            <span class="product-variant-badge">Talla: {{ $detail->talla->nombre }}</span>
                                        @endif
                                        @if($detail->color)
                                            <span class="product-variant-badge">Color: {{ $detail->color->name }}</span>
                                        @endif
                                    </div>
                                    <div class="small text-muted mt-2">Cantidad: {{ (int) $detail->quantity }}</div>
                                </div>
                                <div class="product-price-pro">
                                    <div class="total">S/ {{ number_format($detail->subtotal, 2) }}</div>
                                    <div class="sub">PU: S/ {{ number_format($detail->unit_price, 2) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Info Blocks --}}
                <div class="info-grid-pro">
                    <div class="info-block-pro">
                        <h5>Información de Pago</h5>
                        <div class="info-content-pro">
                            @if($sale->payments->isNotEmpty())
                                @foreach($sale->payments as $payment)
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <i class="fas fa-credit-card text-muted"></i>
                                        <strong>{{ $payment->paymentMethod?->name }}</strong>
                                    </div>
                                @endforeach
                                <div class="small text-muted">Transacción verificada de forma segura.</div>
                                @if($sale->comprobante_yape)
                                    <div class="mt-3 p-2 border rounded bg-light">
                                        <div class="small fw-bold mb-1 text-primary">Tu comprobante enviado:</div>
                                        <a href="{{ asset('storage/' . $sale->comprobante_yape) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $sale->comprobante_yape) }}" class="img-fluid rounded"
                                                style="max-height: 120px;" alt="Comprobante">
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-warning small"><i class="fas fa-clock me-1"></i> Pendiente de verificación de
                                    pago.</div>
                            @endif
                        </div>
                    </div>
                    <div class="info-block-pro">
                        <h5>Facturación</h5>
                        <div class="info-content-pro">
                            <div class="mb-1">Comprobante:
                                <strong>{{ $sale->canal_venta === 'ONLINE' ? 'Boleta Electrónica' : 'Boleta de Tienda' }}</strong>
                            </div>
                            <div class="mb-1">Cliente: <strong>{{ Auth::user()->name }}</strong></div>
                            <div>Correo: <span class="text-muted">{{ Auth::user()->email }}</span></div>
                        </div>
                    </div>
                </div>

                {{-- Totals --}}
                <div class="totals-section-pro">
                    <div class="total-row-pro">
                        <span class="text-muted">Subtotal</span>
                        <span>S/ {{ number_format($sale->total / 1.18, 2) }}</span>
                    </div>
                    <div class="total-row-pro">
                        <span class="text-muted">IGV (18%)</span>
                        <span>S/ {{ number_format($sale->total - ($sale->total / 1.18), 2) }}</span>
                    </div>
                    <div class="total-row-pro grand-total">
                        <span>Total Pagado</span>
                        <span>S/ {{ number_format($sale->total, 2) }}</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mt-5 d-flex flex-column flex-md-row gap-3">
                        <form action="{{ route('historial.repeat', $sale) }}" method="POST" class="flex-grow-1">
                            @csrf
                            <button type="submit"
                                class="btn-premium-action btn-view-detail w-100 py-3 justify-content-center">
                                <i class="fas fa-redo"></i> Volver a pedir estos productos
                            </button>
                        </form>
                        <a href="{{ route('shop.index') }}"
                            class="btn-premium-action btn-repeat-pro py-3 px-5 justify-content-center">
                            Seguir navegando
                        </a>
                    </div>
                </div>

            </div>

            {{-- Help Footer --}}
            <div class="text-center mt-5">
                <div class="text-muted small">¿Necesitas ayuda con este pedido? <a href="#"
                        class="text-dark fw-bold">Contactar Soporte Premium</a></div>
            </div>

        </div>
    </div>

    {{-- 🟣 YAPE PREMIUM MODAL ────────────────────────────────────────── --}}
    <div class="modal fade" id="yapeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="modal-header border-0 text-white p-4" style="background: #6A00FF;">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-mobile-alt me-2"></i>Pagar con Yape
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-4">
                        <div class="badge bg-light text-dark p-2 rounded-pill mb-2 px-3 border">
                            <span class="opacity-75">Monto total:</span>
                            <span class="fw-bold h5 mb-0 text-primary ms-1">S/ {{ number_format($sale->total, 2) }}</span>
                        </div>
                        <h4 class="fw-bold mb-1">StyleBox Official</h4>
                        <p class="text-muted small">Escanea el QR o yapea directamente</p>
                    </div>

                    {{-- QR Container --}}
                    <a href="yape:pay?cel=915142871" class="text-decoration-none d-block">
                        <div class="qr-container bg-white p-3 rounded-4 shadow-sm border mx-auto mb-2 d-flex align-items-center justify-content-center"
                            style="width: 220px; height: 220px;">
                            <div id="yape-qr-code"></div>
                        </div>
                        <div class="small text-primary mb-3"><i class="fas fa-external-link-alt me-1"></i> Pulsa aquí para
                            abrir Yape</div>
                    </a>

                    <div class="p-3 bg-light rounded-4 mb-4 border border-dashed">
                        <div class="small opacity-75 mb-1">Número de celular:</div>
                        <div class="h4 fw-bold text-dark mb-2">915 142 871</div>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3"
                            onclick="copyYapeNumber()">
                            <i class="fas fa-copy me-1"></i> Copiar número
                        </button>
                    </div>

                    {{-- Proof Upload --}}
                    <form id="yape-proof-form" action="{{ route('historial.upload_proof', $sale) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="text-start mb-4">
                            <label class="form-label fw-bold small mb-2">
                                <i class="fas fa-camera me-1"></i> Sube tu captura de pago
                            </label>
                            <input type="file" class="form-control form-control-sm rounded-3 border-2"
                                id="yape-comprobante-input" name="comprobante" accept="image/*"
                                onchange="previewProof(this)" required>
                            <div class="mt-2 d-none" id="yape-proof-preview">
                                <img src="" alt="Preview" class="img-thumbnail rounded-3" style="max-height: 100px;">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg w-100 rounded-4 fw-bold shadow-sm transition"
                            style="background: #6A00FF; color: #fff;" id="btn-yape-confirm">
                            YA PAGUÉ, ENVIAR COMPROBANTE
                        </button>
                    </form>
                </div>
                <div class="modal-footer border-0 bg-light p-3 justify-content-center">
                    <small class="text-muted"><i class="fas fa-shield-alt text-success me-1"></i> Transacción protegida por
                        StyleBox Security</small>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
        <script>
            // Initialize QR Code generator
            const yapeTotal = {{ $sale->total }};
            const yapePhone = '915142871';
            let qrcodeInstance = null;

            function initYapeQR() {
                setTimeout(() => {
                    const container = document.getElementById('yape-qr-code');
                    container.innerHTML = '';
                    qrcodeInstance = new QRCode(container, {
                        text: `yape:pay?cel=${yapePhone}&amt=${yapeTotal}&msg=StyleBox-Order-${yapeTotal}`,
                        width: 200,
                        height: 200,
                        colorDark: "#111111",
                        colorLight: "#ffffff",
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }, 300);
            }

            function copyYapeNumber() {
                navigator.clipboard.writeText("915142871");
                alert("Número copiado: 915142871");
            }

            function previewProof(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('yape-proof-preview');
                        preview.classList.remove('d-none');
                        preview.querySelector('img').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            document.getElementById('yape-proof-form').addEventListener('submit', function () {
                const btn = document.getElementById('btn-yape-confirm');
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>ENVIANDO...';
            });
        </script>

        <style>
            #yapeModal .form-control:focus {
                border-color: #6A00FF;
                box-shadow: 0 0 0 0.25rem rgba(106, 0, 255, 0.1);
            }

            #yapeModal .btn:hover {
                transform: translateY(-2px);
                filter: brightness(1.1);
            }

            .qr-container #yape-qr-code img {
                max-width: 100%;
                height: auto;
            }

            .bg-pending {
                background-color: #fef3c7;
                color: #92400e;
            }

            .bg-completed {
                background-color: #dcfce7;
                color: #166534;
            }

            .bg-shipping {
                background-color: #dbeafe;
                color: #1e40af;
            }

            .bg-cancelled {
                background-color: #fee2e2;
                color: #991b1b;
            }
        </style>
    @endpush
@endsection