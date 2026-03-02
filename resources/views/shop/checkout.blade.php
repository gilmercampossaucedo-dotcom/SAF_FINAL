@extends('layouts.shop')

@section('title', 'Checkout — StyleBox')

@push('styles')
    <style>
        /* ── High-End Premium Checkout Styles ── */
        :root {
            --premium-bg: #fdfdfd;
            --premium-card-bg: #ffffff;
            --premium-accent: #111111;
            --premium-radius: 18px;
            --premium-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            --premium-transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .checkout-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1.5rem 1rem 4rem;
            background: var(--premium-bg);
            min-height: 100vh;
        }

        /* Fade-in Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .section-card {
            background: var(--premium-card-bg);
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 14px;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
            box-shadow: var(--premium-shadow);
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }

        .section-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .section-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .section-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .section-title {
            font-size: 0.9rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            color: var(--premium-accent);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Delivery Premium Cards */
        .delivery-option {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            border: 1.5px solid #f1f5f9;
            border-radius: 16px;
            cursor: pointer;
            transition: var(--premium-transition);
            background: #fff;
            margin-bottom: 1rem;
        }

        .delivery-option:hover {
            border-color: #cbd5e1;
            transform: scale(1.01);
        }

        .delivery-option.selected {
            border-color: var(--premium-accent);
            background: #fff;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .delivery-option .icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            background: #f8f9fa;
            flex-shrink: 0;
        }

        .delivery-option.selected .icon-wrap {
            background: var(--premium-accent);
            color: #fff;
        }

        /* Payment Premium List (Vertical) */
        .payment-list-v {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .payment-option {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border: 1.5px solid #f1f5f9;
            border-radius: 16px;
            cursor: pointer;
            transition: var(--premium-transition);
            background: #fff;
            min-height: 80px;
        }

        .payment-option:hover {
            border-color: #cbd5e1;
            background: #fcfcfc;
        }

        .payment-option.selected {
            border-color: #10b981; /* Success Green for selection like Joinnus */
            background: #f0fdf4;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.08);
        }

        .payment-left-section {
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        /* Custom Radio Indicator */
        .payment-radio-custom {
            width: 22px;
            height: 22px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .payment-option.selected .payment-radio-custom {
            border-color: #10b981;
            background: #10b981;
        }

        .payment-radio-custom::after {
            content: '';
            width: 8px;
            height: 8px;
            background: #fff;
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .payment-option.selected .payment-radio-custom::after {
            transform: scale(1);
        }

        .payment-details .fw-bold {
            font-size: 1rem;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        .payment-details .text-muted {
            font-size: 0.8rem !important;
        }

        .payment-right-section {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .payment-method-logo {
            height: 32px;
            width: auto;
            max-width: 80px;
            object-fit: contain;
            filter: grayscale(0.2);
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .payment-option.selected .payment-method-logo {
            filter: grayscale(0);
            opacity: 1;
        }

        .payment-method-badge {
            background: #f1f5f9;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #475569;
            text-transform: uppercase;
        }

        .payment-option.selected .payment-method-badge {
            background: #dcfce7;
            color: #15803d;
        }

        /* Shopify/Apple Dark Summary Sidebar */
        .shopify-summary {
            background: #111;
            color: #fff;
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 2rem;
        }

        .summary-title {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            opacity: 0.6;
        }

        .order-item-mini {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.25rem;
            padding-bottom: 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mini-thumb {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
        }

        .total-display {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid rgba(255, 255, 255, 0.1);
        }

        .total-amount {
            font-size: 2.5rem;
            font-weight: 900;
            color: #ffd700;
            /* Gold */
            line-height: 1;
        }

        .btn-premium-confirm {
            background: #fff;
            color: #000;
            border: none;
            padding: 1.25rem;
            border-radius: 16px;
            width: 100%;
            font-weight: 800;
            font-size: 1.1rem;
            margin-top: 2rem;
            transition: var(--premium-transition);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.1);
        }

        .btn-premium-confirm:hover {
            background: #f0f0f0;
            transform: scale(1.02);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.2);
        }

        .security-lock {
            margin-top: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            font-size: 0.8rem;
            opacity: 0.5;
        }

        /* Mobile Sticky Bottom */
        @media (max-width: 991.98px) {
            .mobile-sticky-footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: #fff;
                padding: 1rem 1.5rem;
                box-shadow: 0 -10px 25px rgba(0, 0, 0, 0.05);
                z-index: 1000;
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-top: 1px solid #f1f5f9;
            }

            .checkout-wrapper {
                padding-bottom: 8rem;
            }
        }

        .form-control:focus {
            border-color: #1a1a1a;
            box-shadow: 0 0 0 0.2rem rgba(26, 26, 26, .1);
        }

        .info-delivery-alert {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid #bae6fd;
            border-radius: 10px;
            padding: 0.85rem 1rem;
            font-size: 0.875rem;
            color: #0369a1;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-wrapper">

        {{-- Page title (Minimal) --}}
        <div class="mb-3">
            <h1 class="fw-bold mb-0" style="font-size: 1.25rem;">Finalizar compra</h1>
            <p class="text-muted small mb-0">Confirma tu pedido abajo.</p>
        </div>

        {{-- Global error --}}
        @if(session('error'))
            <div class="alert alert-danger rounded-3 mb-3">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
            @csrf

            <div class="row g-5 align-items-start">

                {{-- LEFT COLUMN: Details, Delivery & Payment --}}
                <div class="col-lg-7">

                    {{-- ── 1. Método de entrega (Visual Selection) ── --}}
                <div class="section-card">
                    <p class="section-title"><i class="fas fa-truck-loading"></i>Método de entrega</p>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="delivery-option {{ old('tipo_entrega', 'envio_domicilio') == 'envio_domicilio' ? 'selected' : '' }}"
                                id="label-recojo" for="tipo-recojo">
                                <input type="radio" name="tipo_entrega" id="tipo-recojo" value="envio_domicilio"
                                    style="opacity:0; position:absolute;"
                                    {{ old('tipo_entrega', 'envio_domicilio') == 'envio_domicilio' ? 'checked' : '' }}>
                                <div class="icon-wrap">
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">Envío a domicilio</div>
                                    <div class="text-muted small">Entrega en la puerta de tu casa.</div>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="delivery-option {{ old('tipo_entrega') == 'mi_delivery' ? 'selected' : '' }}"
                                id="label-delivery" for="tipo-delivery">
                                <input type="radio" name="tipo_entrega" id="tipo-delivery" value="mi_delivery"
                                    style="opacity:0; position:absolute;"
                                    {{ old('tipo_entrega') == 'mi_delivery' ? 'checked' : '' }}>
                                <div class="icon-wrap">
                                    <i class="fas fa-motorcycle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold">Recojo Externo</div>
                                    <div class="text-muted small">Tú envías a tu propio repartidor.</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- ── Repartidor fields (Only for Recojo Externo) ── --}}
                    <div id="repartidor-section" class="{{ old('tipo_entrega') == 'mi_delivery' ? 'visible' : '' }}"
                        style="{{ old('tipo_entrega') == 'mi_delivery' ? '' : 'display: none;' }}">
                        <div class="info-delivery-alert mt-3 mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Nota:</strong> Te avisaremos cuando el pedido esté listo para ser recogido.
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="nombre_repartidor"
                                        value="{{ old('nombre_repartidor') }}" id="rep-name" placeholder="Juan Perez">
                                    <label for="rep-name">Nombre del repartidor</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="dni_repartidor"
                                        value="{{ old('dni_repartidor') }}" id="rep-dni" placeholder="DNI">
                                    <label for="rep-dni">DNI / Identificación</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    {{-- ── 3. Método de pago (Premium Vertical List) ── --}}
                    <div class="section-card">
                        <p class="section-title"><i class="fas fa-wallet"></i>Escoge cómo pagar</p>

                        <div class="payment-list-v">
                            @php $seenNames = []; @endphp
                            @foreach($paymentMethods as $method)
                                @php
                                    $mName = strtolower($method->name);
                                    if (in_array($mName, $seenNames)) continue;
                                    $seenNames[] = $mName;

                                    $pm_icon = 'fa-money-bill-wave';
                                    $pm_desc = 'Pago seguro y confiable';
                                    $pm_logo = null;
                                    $pm_badge = null;

                                    if (Str::contains($mName, 'yape')) {
                                        $pm_icon = 'fa-mobile-alt';
                                        $pm_desc = 'Escanea el código QR desde tu celular';
                                        $pm_logo = 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Yape_logo.png';
                                        $pm_badge = 'Recomendado';
                                    } elseif (Str::contains($mName, 'plin')) {
                                        $pm_icon = 'fa-bolt';
                                        $pm_desc = 'Transferencia directa inmediata';
                                        $pm_logo = 'https://logos-world.net/wp-content/uploads/2023/02/Plin-Logo.png';
                                    } elseif (Str::contains($mName, 'tarjeta')) {
                                        $pm_icon = 'fa-credit-card';
                                        $pm_desc = 'Visa, Mastercard, Amex, Diners';
                                        $pm_badge = 'Seguro';
                                    } elseif (Str::contains($mName, 'mercado')) {
                                        $pm_icon = 'fa-handshake';
                                        $pm_desc = 'Paga con tu cuenta de Mercado Pago';
                                        $pm_logo = 'https://logospng.org/download/mercado-pago/logo-mercado-pago-256.png';
                                    }
                                @endphp
                                <label class="payment-option {{ old('payment_method_id') == $method->id ? 'selected' : '' }}" 
                                       for="pm-{{ $method->id }}">
                                    <input type="radio" name="payment_method_id" id="pm-{{ $method->id }}" 
                                           value="{{ $method->id }}" class="payment-radio" required
                                           style="opacity:0; position:absolute; pointer-events:none;"
                                           {{ old('payment_method_id') == $method->id ? 'checked' : '' }}>
                                    
                                    <div class="payment-left-section">
                                        <div class="payment-radio-custom"></div>
                                        <div class="payment-details">
                                            <div class="fw-bold">{{ $method->name }}</div>
                                            <div class="text-muted small">{{ $pm_desc }}</div>
                                        </div>
                                    </div>

                                    <div class="payment-right-section">
                                        @if($pm_badge)
                                            <span class="payment-method-badge d-none d-sm-inline-block">{{ $pm_badge }}</span>
                                        @endif
                                        
                                        @if($pm_logo)
                                            <img src="{{ $pm_logo }}" class="payment-method-logo" alt="{{ $method->name }}">
                                        @elseif(Str::contains($mName, 'tarjeta'))
                                            <div class="d-flex gap-1 opacity-75">
                                                <i class="fab fa-cc-visa fa-lg text-primary"></i>
                                                <i class="fab fa-cc-mastercard fa-lg text-danger"></i>
                                                <i class="fab fa-cc-amex fa-lg text-info"></i>
                                            </div>
                                        @else
                                            <div class="payment-icon-lg border-0 bg-transparent opacity-50">
                                                <i class="fas {{ $pm_icon }} fa-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                </label>
                            @endforeach

                            {{-- Apple Pay Mockup --}}
                                <div class="payment-option opacity-50 pe-none grayscale">
                                    <div class="payment-left-section">
                                        <div class="payment-radio-custom"></div>
                                        <div class="payment-details">
                                            <div class="fw-bold">Apple Pay</div>
                                            <div class="text-muted small">Próximamente disponible</div>
                                        </div>
                                    </div>
                                    <div class="payment-right-section">
                                        <i class="fab fa-apple-pay fa-2x"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Matching reference image: Total a pagar in section --}}
                            <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                                <div class="h5 fw-bold mb-0" style="color: #6366f1;">
                                    <span class="text-muted small fw-normal">Total a pagar</span>
                                    <span class="ms-2">S/ {{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="small text-muted d-none d-sm-block">
                                    <i class="fas fa-shield-alt text-success me-1"></i> Transacción segura
                                </div>
                            </div>
                        </div>

                </div>{{-- /LEFT --}}

                {{-- RIGHT COLUMN: Shopify-style Summary --}}
                <div class="col-lg-5">
                    <div class="shopify-summary">
                        <p class="summary-title">Resumen del pedido</p>

                        <div class="order-scroll-mini mb-4" style="max-height: 250px; overflow-y: auto;">
                            @foreach($items as $item)
                                <div class="order-item-mini">
                                    <img src="{{ asset('storage/' . ($item['image'] ?? '')) }}" class="mini-thumb">
                                    <div class="flex-grow-1">
                                        <div class="small fw-bold">{{ $item['name'] }}</div>
                                        <div class="small opacity-50">{{ $item['quantity'] }} unidad(es)</div>
                                    </div>
                                    <div class="small fw-bold">S/ {{ number_format($item['price'], 2) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="d-flex justify-content-between opacity-75 mb-2">
                            <span>Subtotal</span>
                            <span>S/ {{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between opacity-75 mb-4">
                            <span>Gastos de envío</span>
                            <span class="text-success fw-bold">GRATIS</span>
                        </div>

                        <div class="total-display d-flex justify-content-between align-items-end">
                            <div class="small opacity-50 fw-bold">TOTAL</div>
                            <div class="total-amount">S/ {{ number_format($subtotal, 2) }}</div>
                        </div>

                        <button type="submit" class="btn-premium-confirm" id="btn-main-submit">
                            <i class="fas fa-lock me-2"></i>CONFIRMAR PEDIDO
                        </button>

                        <div class="security-lock">
                            <i class="fas fa-shield-check"></i> Pago 100% Seguro — Certificado SSL
                        </div>

                        <a href="{{ route('cart.index') }}"
                            class="btn btn-link link-light w-100 mt-4 opacity-50 text-decoration-none small">
                            <i class="fas fa-chevron-left me-1"></i> Modificar mi selección
                        </a>
                    </div>
                </div>

            </div>{{-- /row --}}
        </form>

        </div>{{-- /checkout-wrapper --}}

        {{-- 🟣 YAPE PREMIUM MODAL ────────────────────────────────────────── --}}
        <div class="modal fade" id="yapeModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="modal-header border-0 text-white p-4" style="background: #6A00FF;">
                        <h5 class="modal-title fw-bold">
                            <i class="fas fa-mobile-alt me-2"></i>Pagar con Yape
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <div class="mb-4">
                            <div class="badge bg-light text-dark p-2 rounded-pill mb-2 px-3 border">
                                <span class="opacity-75">Monto total:</span> 
                                <span class="fw-bold h5 mb-0 text-primary ms-1">S/ {{ number_format($subtotal, 2) }}</span>
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
                            <div class="small text-primary mb-3"><i class="fas fa-external-link-alt me-1"></i> Pulsa aquí para abrir Yape</div>
                        </a>

                        <div class="p-3 bg-light rounded-4 mb-4 border border-dashed">
                            <div class="small opacity-75 mb-1">Número de celular:</div>
                            <div class="h4 fw-bold text-dark mb-2">915 142 871</div>
                            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="copyYapeNumber()">
                                <i class="fas fa-copy me-1"></i> Copiar número
                            </button>
                        </div>

                        {{-- Proof Upload --}}
                        <div class="text-start mb-4">
                            <label class="form-label fw-bold small mb-2">
                                <i class="fas fa-camera me-1"></i> Sube tu captura de pago
                            </label>
                            <input type="file" class="form-control form-control-sm rounded-3 border-2" 
                                   id="yape-comprobante-input" name="yape_proof" accept="image/*"
                                   onchange="previewProof(this)">
                            <div class="mt-2 d-none" id="yape-proof-preview">
                                <img src="" alt="Preview" class="img-thumbnail rounded-3" style="max-height: 100px;">
                            </div>
                        </div>

                        <button type="button" class="btn btn-lg w-100 rounded-4 fw-bold shadow-sm transition" 
                                style="background: #6A00FF; color: #fff;"
                                onclick="confirmYapePayment()">
                            YA PAGUÉ, CONFIRMAR PEDIDO
                        </button>
                    </div>
                    <div class="modal-footer border-0 bg-light p-3 justify-content-center">
                        <small class="text-muted"><i class="fas fa-shield-alt text-success me-1"></i> Transacción protegida por StyleBox Security</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Mobile Sticky Footer Button --}}
        <div class="mobile-sticky-footer d-lg-none">
            <div>
                <div class="small opacity-75 fw-bold">A PAGAR</div>
                <div class="fw-bold h4 mb-0 text-dark">S/ {{ number_format($subtotal, 2) }}</div>
            </div>
            <button type="button" onclick="document.getElementById('btn-main-submit').click()"
                class="btn btn-dark btn-lg px-4 rounded-4 fw-bold">
                Pagar ahora
            </button>
        </div>

    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <style>
        #yapeModal .form-control:focus { border-color: #6A00FF; box-shadow: 0 0 0 0.25rem rgba(106, 0, 255, 0.1); }
        #yapeModal .btn:hover { transform: translateY(-2px); filter: brightness(1.1); }
        .qr-container #yape-qr-code img { max-width: 100%; height: auto; }
    </style>
@endsection

@push('scripts')
    <script>
        // ── Delivery Premium Logic ──────────────────────────────────────────
        const radioRecojo = document.getElementById('tipo-recojo');
        const radioDelivery = document.getElementById('tipo-delivery');
        const labelRecojo = document.getElementById('label-recojo');
        const labelDelivery = document.getElementById('label-delivery');
        const repartidorSection = document.getElementById('repartidor-section');

        function updateDeliveryUI() {
            const isMiDelivery = radioDelivery.checked;

            labelRecojo.classList.toggle('selected', radioRecojo.checked);
            labelDelivery.classList.toggle('selected', radioDelivery.checked);

            // Show fields ONLY for Recojo Externo (mi_delivery)
            if (isMiDelivery) {
                repartidorSection.style.display = 'block';
                setTimeout(() => repartidorSection.classList.add('visible'), 10);
            } else {
                repartidorSection.classList.remove('visible');
                setTimeout(() => repartidorSection.style.display = 'none', 500);
            }

            // Sync required status
            repartidorSection.querySelectorAll('input').forEach(input => {
                input.required = isMiDelivery;
            });
        }

        radioRecojo.addEventListener('change', updateDeliveryUI);
        radioDelivery.addEventListener('change', updateDeliveryUI);
        updateDeliveryUI(); // Init

        // Initialize QR Code generator
        const yapeTotal = {{ $subtotal }};
        const yapePhone = '915142871';
        let qrcodeInstance = null;

        function initYapeQR() {
            const container = document.getElementById('yape-qr-code');
            container.innerHTML = '';
            qrcodeInstance = new QRCode(container, {
                text: `yape:pay?cel=${yapePhone}&amt=${yapeTotal}&msg=StyleBox-Order`,
                width: 200,
                height: 200,
                colorDark: "#111111",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        }

        // ── Payment Premium Logic (Refined) ────────────────────────────────
        document.querySelectorAll('.payment-option:not(.pe-none)').forEach(label => {
            label.addEventListener('click', function (e) {
                // Prevent double trigger if clicking near radio
                if (e.target.tagName === 'INPUT') return;

                const radio = this.querySelector('input[type=radio]');
                if (!radio) return;

                const isYape = radio.value == "3"; // ID 3 = Yape
                
                if (isYape && !radio.checked) {
                    const myModal = new bootstrap.Modal(document.getElementById('yapeModal'));
                    myModal.show();
                    initYapeQR();
                }

                radio.checked = true;
                
                // Active class management
                document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // ── Yape Modal Helpers ───────────────────────────────────────────
        function copyYapeNumber() {
            navigator.clipboard.writeText("915142871");
            alert("Número de Yape copiado: 915142871");
        }

        function previewProof(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('yape-proof-preview');
                    preview.classList.remove('d-none');
                    preview.querySelector('img').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function confirmYapePayment() {
            const modalInput = document.getElementById('yape-comprobante-input');
            const mainForm = document.getElementById('checkout-form');
            const btnConfirm = document.querySelector('#yapeModal .btn-lg');
            
            if (!modalInput.files.length) {
                alert("Por favor, sube una captura del pago para continuar.");
                return;
            }

            // Sync file to main form
            const dTransfer = new DataTransfer();
            dTransfer.items.add(modalInput.files[0]);
            
            let mainFileInput = document.getElementById('comprobante-hidden-input');
            if (!mainFileInput) {
                mainFileInput = document.createElement('input');
                mainFileInput.type = 'file';
                mainFileInput.name = 'comprobante';
                mainFileInput.id = 'comprobante-hidden-input';
                mainFileInput.className = 'd-none';
                mainForm.appendChild(mainFileInput);
            }
            mainFileInput.files = dTransfer.files;

            // Visual feedback in modal
            btnConfirm.disabled = true;
            btnConfirm.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>PROCESANDO...';

            mainForm.requestSubmit();
        }

        // Initialize state for old()
        document.addEventListener('DOMContentLoaded', () => {
            const initialPayment = document.querySelector('.payment-radio:checked');
            if (initialPayment) {
                const label = initialPayment.closest('.payment-option');
                if (label) label.classList.add('selected');
            }
        });

        // ── Submit Logic: Ultra Premium Feedback ──────────────────────────
        document.getElementById('checkout-form').addEventListener('submit', function (e) {
            const btn = document.getElementById('btn-main-submit');
            if (btn.disabled) return;
            
            const radio = document.querySelector('input[name="payment_method_id"]:checked');
            if (!radio) {
                e.preventDefault();
                alert("Por favor, selecciona un método de pago.");
                return;
            }

            if (radio.value == "3") { // Yape
                const hiddenInput = document.getElementById('comprobante-hidden-input');
                if (!hiddenInput || !hiddenInput.files.length) {
                    e.preventDefault();
                    const myModal = new bootstrap.Modal(document.getElementById('yapeModal'));
                    myModal.show();
                    initYapeQR();
                    return;
                }
            }

            // High-end processing state
            setTimeout(() => {
                btn.disabled = true;
                btn.style.background = '#6366f1'; // Premium indigo
                btn.innerHTML = `
                    <div class="d-flex align-items-center justify-content-center">
                        <span class="spinner-border spinner-border-sm me-3" role="status"></span>
                        <span class="text-uppercase tracking-wider">Procesando Pago...</span>
                    </div>
                `;
                btn.classList.add('opacity-75');
            }, 50);
        });
    </script>
@endpush