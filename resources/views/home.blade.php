<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cementerio El Sepulturero Juan</title>
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link
        href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700;900&family=EB+Garamond:ital,wght@0,400;0,500;1,400&family=Raleway:wght@300;400;500;600&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}?v=2">

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

</head>

<body>
    <!-- ═══ HEADER ═══ -->
    <header>
        <nav>
            <a href="{{ route('home') }}" class="logo">
                <div class="logo-icon"><i class="fas fa-monument"></i></div>
                <div>
                    <span class="logo-text">El Sepulturero Juan</span>

                </div>
            </a>

            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>

            <div class="nav-links">
                <a href="{{ route('home') }}#inicio">Inicio</a>
                <a href="{{ route('home') }}#sobre-nosotros">Nosotros</a>
                <a href="{{ route('home') }}#servicios">Servicios</a>
                <a href="{{ route('home') }}#espacios">Espacios</a>
                <a href="{{ route('home') }}#beneficios">Beneficios</a>
                <a href="{{ route('home') }}#galeria">Galería</a>

                <a href="{{ route('home') }}#contacto">Contacto</a>

                @auth
                <!-- Usuario autenticado -->
                @php
                $user = Auth::user();
                $esCliente = $user->hasRole('Cliente');
                @endphp
                <div class="user-menu-container">
                    <a href="#" class="user-btn">
                        <i class="fas fa-user-circle"></i>
                        {{ Auth::user()->username }}
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="user-dropdown">
                        @if(!$esCliente)
                        <a href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a href="{{ route('perfil.index') }}">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                        @else
                        <a href="{{ route('cliente.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Mi Portal
                        </a>
                        <a href="{{ route('cliente.perfil') }}">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('cliente.login') }}" class="nav-link-login">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                @endauth
            </div>
        </nav>
    </header>

    <!-- ═══ HERO ═══ -->
    <section id="inicio" class="hero">
        <div class="hero-bg"></div>
        <div class="hero-content">
            <div class="hero-badge">
                <i class="fas fa-star" style="font-size: 0.55rem"></i>
                Más de 50 años de servicio
            </div>
            <h1>El <span>Sepulturero</span> Juan</h1>
            <div class="hero-divider"></div>
            <p>Donde el descanso eterno encuentra paz y serenidad</p>
            <p>
                Un lugar digno y tranquilo para honrar la memoria de sus seres
                queridos
            </p>
            <div class="hero-buttons">
                <a href="#servicios" class="btn btn-primary"><i class="fas fa-monument"></i> Nuestros Servicios</a>
                <a href="#contacto" class="btn btn-outline"><i class="fas fa-envelope"></i> Contáctenos</a>
            </div>

            <!-- BUSCADOR -->
            <div class="hero-search">
                <div class="search-title">
                    <i class="fas fa-search"></i> Buscar Espacios Disponibles
                </div>
                <div class="search-bar">
                    <select id="buscar-tipo">
                        <option value="">Todos los tipos</option>
                        <option value="nicho">Nichos</option>
                        <option value="mausoleo">Mausoleos</option>
                        <option value="lote">Lotes Familiares</option>
                        <option value="individual">Espacios Individuales</option>
                    </select>
                    <button onclick="buscarEspacios()">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
                <div id="search-results" class="search-results" style="display:none;"></div>
            </div>
        </div>
    </section>

    <!-- ═══ STAT BAR ═══ -->
    <div class="stat-bar">
        <div class="stat-bar-inner">
            <div class="stat-item">
                <span class="stat-num">50+</span>
                <span class="stat-label">Años de Trayectoria</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">10</span>
                <span class="stat-label">Hectáreas de Jardines</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">5K+</span>
                <span class="stat-label">Familias Atendidas</span>
            </div>
            <div class="stat-item">
                <span class="stat-num">24/7</span>
                <span class="stat-label">Seguridad Permanente</span>
            </div>
        </div>
    </div>

    <!-- ═══ SOBRE NOSOTROS ═══ -->
    <section id="sobre-nosotros">
        <div class="container">
            <div class="about-grid">
                <div>
                    <div class="section-header">
                        <div class="section-tag">Nuestra Historia</div>
                        <h2>Sobre <span>Nosotros</span></h2>
                    </div>
                    <div class="about-text">
                        <p>
                            Fundado hace más de 50 años por Juan Martínez, "El Sepulturero
                            Juan" nació de un profundo respeto por la dignidad humana y el
                            deseo de ofrecer un lugar de descanso eterno que transmitiera
                            paz y serenidad.
                        </p>
                        <p>
                            Lo que comenzó como un pequeño cementerio familiar, hoy es un
                            espacio de 10 hectáreas cuidadosamente diseñado para honrar la
                            memoria de quienes partieron.
                        </p>
                        <p>
                            Nuestra historia está marcada por el compromiso con las familias
                            que confían en nosotros en sus momentos más difíciles,
                            ofreciendo no solo un lugar de descanso, sino un espacio donde
                            el recuerdo florece.
                        </p>
                    </div>
                    <div class="values-row">
                        <div class="value-card">
                            <i class="fas fa-heart"></i>
                            <h4>Misión</h4>
                            <p>
                                Brindar espacios dignos y servicios respetuosos para el
                                descanso eterno
                            </p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-eye"></i>
                            <h4>Visión</h4>
                            <p>
                                Ser el cementerio de referencia en tranquilidad y servicio
                                humano
                            </p>
                        </div>
                        <div class="value-card">
                            <i class="fas fa-hand-holding-heart"></i>
                            <h4>Valores</h4>
                            <p>Respeto, empatía, profesionalismo y compromiso</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img
                        src="https://images.unsplash.com/photo-1604537529428-15bcbeecfe4d?auto=format&fit=crop&w=900&q=80"
                        alt="Cementerio" />
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ SERVICIOS ═══ -->
    <section id="servicios">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Lo Que Ofrecemos</div>
                <h2>Nuestros <span>Servicios</span></h2>
                <p class="section-desc">
                    Cada servicio está diseñado con el máximo respeto y profesionalismo
                    para acompañarle en todo momento.
                </p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-file-contract"></i></div>
                    <h3>Contratos Funerarios</h3>
                    <p>
                        Planes personalizados para espacios funerarios con total
                        transparencia y seguridad jurídica.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-dove"></i></div>
                    <h3>Inhumaciones</h3>
                    <p>
                        Servicio completo de inhumación con respeto y dignidad,
                        coordinando todos los detalles.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-leaf"></i></div>
                    <h3>Mantenimiento</h3>
                    <p>
                        Cuidado permanente de espacios funerarios, jardinería y limpieza
                        diaria.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-archway"></i></div>
                    <h3>Venta de Nichos</h3>
                    <p>
                        Nichos, terrenos y mausoleos en diferentes sectores del
                        cementerio.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-coins"></i></div>
                    <h3>Ventas al Contado</h3>
                    <p>
                        Precios especiales para compras de contado con descuentos
                        significativos.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-credit-card"></i></div>
                    <h3>Planes de Pago</h3>
                    <p>
                        Facilidades de crédito con plazos flexibles para adquirir espacios
                        funerarios.
                    </p>
                </div>
                <div class="service-card">
                    <div class="service-icon"><i class="fas fa-hands-helping"></i></div>
                    <h3>Asesoramiento</h3>
                    <p>
                        Acompañamiento profesional en todo el proceso, resolviendo todas
                        sus dudas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ ESPACIOS ═══ -->
    <section id="espacios">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Áreas Disponibles</div>
                <h2>Espacios <span>Funerarios</span></h2>
                <p class="section-desc">
                    Contamos con diferentes tipos de espacios para cada necesidad y
                    presupuesto.
                </p>
            </div>
            <div class="spaces-grid">
                <a href="{{ route('home.espacios', ['tipo' => 'nicho']) }}" style="text-decoration:none;">
                    <div class="space-card">
                        <img src="https://i.postimg.cc/9fpHkk2C/nicho.png" alt="Nichos">
                        <span class="space-tag">Disponible</span>
                        <div class="space-info">
                            <h3>Nichos</h3>
                            <p>Espacios individuales en nuestros jardines verticales, rodeados de áreas verdes</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('home.espacios', ['tipo' => 'mausoleo']) }}" style="text-decoration:none;">
                    <div class="space-card">
                        <img src="https://i.postimg.cc/N0Ywpc30/ausoles.png" alt="Mausoleos">
                        <span class="space-tag">Exclusivo</span>
                        <div class="space-info">
                            <h3>Mausoleos</h3>
                            <p>Estructuras privadas y familiares con diseños arquitectónicos personalizados</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('home.espacios', ['tipo' => 'lote']) }}" style="text-decoration:none;">
                    <div class="space-card">
                        <img src="https://i.postimg.cc/MGx8dSCv/lotes-familiares.png" alt="Lotes Familiares">
                        <span class="space-tag">Disponible</span>
                        <div class="space-info">
                            <h3>Lotes Familiares</h3>
                            <p>Terrenos espaciosos para varias generaciones, con posibilidad de jardinería propia</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('home.espacios', ['tipo' => 'individual']) }}" style="text-decoration:none;">
                    <div class="space-card">
                        <img src="https://i.postimg.cc/VN1cD8x6/espacios-individuales.png" alt="Espacios Individuales">
                        <span class="space-tag">Disponible</span>
                        <div class="space-info">
                            <h3>Espacios Individuales</h3>
                            <p>Tumbas tradicionales en áreas tranquilas con mantenimiento incluido</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══ BENEFICIOS ═══ -->
    <section id="beneficios">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">¿Por Qué Elegirnos?</div>
                <h2>Nuestros <span>Beneficios</span></h2>
            </div>
            <div class="benefits-grid">
                <div class="benefit-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Ubicación Accesible</h3>
                    <p>
                        A solo 15 minutos del centro, con fácil acceso en transporte
                        público y privado
                    </p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-shield-alt"></i>
                    <h3>Seguridad 24/7</h3>
                    <p>Vigilancia permanente y cámaras en todo el perímetro</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-tree"></i>
                    <h3>Mantenimiento Constante</h3>
                    <p>Jardinería y limpieza diaria en todas las áreas</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-peace"></i>
                    <h3>Ambiente Tranquilo</h3>
                    <p>Espacios diseñados para la meditación y el recuerdo</p>
                </div>
                <div class="benefit-card">
                    <i class="fas fa-user-tie"></i>
                    <h3>Atención Personalizada</h3>
                    <p>Asesores dedicados para acompañarle en todo momento</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ GALERÍA ═══ -->
    <section id="galeria">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Nuestros Espacios</div>
                <h2>Galería de <span>Imágenes</span></h2>
            </div>
            <div class="gallery-grid">
                <div class="gallery-item">
                    <a href="https://i.postimg.cc/7LDymkpR/1.png" target="_blank">
                        <img src="https://i.postimg.cc/7LDymkpR/1.png" alt="" />
                    </a>

                </div>
                <div class="gallery-item">
                    <a href="https://i.postimg.cc/pdxtqHg6/2.png" target="_blank">
                        <img src="https://i.postimg.cc/pdxtqHg6/2.png" alt="" />
                    </a>

                </div>
                <div class="gallery-item">
                    <a href="https://i.postimg.cc/d0vK4YzH/3.png" target="_blank">
                        <img src="https://i.postimg.cc/d0vK4YzH/3.png" alt="" />
                    </a>

                </div>
                <div class="gallery-item">
                    <a href="https://i.postimg.cc/Xv30QbT2/4.png" target="_blank">
                        <img src="https://i.postimg.cc/Xv30QbT2/4.png" alt="" />
                    </a>

                </div>
                <div class="gallery-item">
                    <a href="https://i.postimg.cc/TPGXC6zG/5.png" target="_blank">
                        <img src="https://i.postimg.cc/TPGXC6zG/5.png" alt="" />
                    </a>

                </div>
                <div class="gallery-item">
                    <a href="https://i.postimg.cc/DzFKBT9y/6.png" target="_blank">
                        <img src="https://i.postimg.cc/DzFKBT9y/6.png" alt="" />
                    </a>

                </div>
            </div>
        </div>
    </section>

    <!-- ═══ FAQ ═══ -->
    <section id="faq">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Consultas Comunes</div>
                <h2>Preguntas <span>Frecuentes</span></h2>
            </div>
            <div class="faq-grid">
                <div class="faq-card">
                    <h3>
                        <span><i class="fas fa-chevron-right"></i></span> ¿Cómo adquirir
                        un espacio funerario?
                    </h3>
                    <p>
                        Puede contactarnos directamente, visitar nuestras instalaciones o
                        llenar el formulario de contacto. Un asesor le guiará en todo el
                        proceso sin compromiso.
                    </p>
                </div>
                <div class="faq-card">
                    <h3>
                        <span><i class="fas fa-chevron-right"></i></span> ¿Se puede
                        comprar al crédito?
                    </h3>
                    <p>
                        Sí, ofrecemos planes de financiamiento de hasta 36 meses con tasas
                        preferenciales. Consulte con nuestros asesores para encontrar el
                        plan ideal.
                    </p>
                </div>
                <div class="faq-card">
                    <h3>
                        <span><i class="fas fa-chevron-right"></i></span> ¿Qué incluye el
                        mantenimiento?
                    </h3>
                    <p>
                        Incluye limpieza diaria, jardinería, riego automático, iluminación
                        y seguridad permanente en todas las áreas del cementerio.
                    </p>
                </div>
                <div class="faq-card">
                    <h3>
                        <span><i class="fas fa-chevron-right"></i></span> ¿Cómo se realiza
                        una inhumación?
                    </h3>
                    <p>
                        Coordinamos todos los detalles con la familia, incluyendo
                        horarios, servicio religioso si se desea, y todos los trámites
                        necesarios.
                    </p>
                </div>
            </div>
        </div>
    </section>



    <!-- ═══ CONTACTO ═══ -->
    <section id="contacto">
        <div class="container">
            <div class="section-header">
                <div class="section-tag">Estamos Para Usted</div>
                <h2>Póngase en <span>Contacto</span></h2>
            </div>
            <div class="contact-grid">
                <div>
                    <div class="contact-info-list">
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-item-text">
                                <strong>Dirección</strong>
                                <p>Camino de la Paz 123, Colina del Descanso, Ciudad</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-phone"></i></div>
                            <div class="contact-item-text">
                                <strong>Teléfono</strong>
                                <p>+591 70899084</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div class="contact-item-text">
                                <strong>Correo Electrónico</strong>
                                <p>info@sepulturerojuan.xyz</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon"><i class="fas fa-clock"></i></div>
                            <div class="contact-item-text">
                                <strong>Horario de Atención</strong>
                                <p>
                                    Lunes a Viernes: 8:00 – 18:00<br />Sábados: 9:00 – 14:00<br />Domingos:
                                    Solo visitas
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="map-wrap">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.9663095343005!2d-73.98510768458426!3d40.74881797932769!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b30eac9f%3A0xaca05ca48ab5ac2c!2sEmpire%20State%20Building!5e0!3m2!1ses!2smx!4v1620000000000!5m2!1ses!2smx"
                            allowfullscreen
                            loading="lazy"></iframe>
                    </div>
                </div>
                <div class="contact-form">
                    <h3>Envíenos un Mensaje</h3>

                    @if(session('contacto_ok'))
                    <div style="background:rgba(74,222,128,0.1); border:1px solid #4ade80; border-radius:8px; padding:1rem; margin-bottom:1rem; color:#4ade80; font-size:0.9rem;">
                        <i class="fas fa-check-circle me-2"></i> Mensaje enviado. Le responderemos pronto.
                    </div>
                    @endif

                    <form method="POST" action="{{ route('home.contacto') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nombre Completo *</label>
                                <input type="text" name="nombre" value="{{ old('nombre') }}"
                                    placeholder="Juan Pérez" required />
                                @error('nombre')<span style="color:#f87171; font-size:0.8rem;">{{ $message }}</span>@enderror
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="tel" name="telefono" value="{{ old('telefono') }}"
                                    placeholder="+591 70899084" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Correo Electrónico *</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="correo@ejemplo.com" required />
                            @error('email')<span style="color:#f87171; font-size:0.8rem;">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Servicio de Interés</label>
                            <select name="servicio">
                                <option value="">Seleccionar servicio...</option>
                                <option>Contratos Funerarios</option>
                                <option>Inhumaciones</option>
                                <option>Venta de Nichos</option>
                                <option>Mausoleos</option>
                                <option>Lotes Familiares</option>
                                <option>Planes de Pago</option>
                                <option>Asesoramiento</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Mensaje *</label>
                            <textarea name="mensaje" rows="5"
                                placeholder="Escriba su consulta aquí..." required>{{ old('mensaje') }}</textarea>
                            @error('mensaje')<span style="color:#f87171; font-size:0.8rem;">{{ $message }}</span>@enderror
                        </div>

                        {{-- reCAPTCHA --}}
                        @error('captcha')
                        <div style="color:#f87171; font-size:0.8rem; margin-bottom:0.75rem;">
                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                        </div>
                        @enderror
                        <div class="g-recaptcha"
                            data-sitekey="{{ config('services.recaptcha.site_key') }}"
                            style="margin-bottom:1rem;">
                        </div>

              

                        <button type="submit" class="btn btn-primary"
                            style="width:100%; justify-content:center; font-size:0.8rem;">
                            <i class="fas fa-paper-plane"></i> Enviar Mensaje
                        </button>
                     
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ FOOTER ═══ -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a
                        href="#inicio"
                        class="logo"
                        style="margin-bottom: 0.5rem; display: inline-flex">
                        <div class="logo-icon"><i class="fas fa-monument"></i></div>
                        <div style="margin-left: 0.75rem">
                            <span class="logo-text">El Sepulturero Juan</span>
                            <span class="logo-sub">Cementerio y Jardines de Paz</span>
                        </div>
                    </a>
                    <p>
                        Donde el descanso eterno encuentra paz y serenidad desde hace más
                        de 50 años. Siempre a su lado.
                    </p>
                    <div class="social-row">
                        <a href="#" class="social-btn"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-btn"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="footer-col">
                    <h4>Navegación</h4>
                    <a href="#inicio">Inicio</a>
                    <a href="#sobre-nosotros">Sobre Nosotros</a>
                    <a href="#servicios">Servicios</a>
                    <a href="#espacios">Espacios</a>
                    <a href="#galeria">Galería</a>
                    <a href="#contacto">Contacto</a>
                </div>
                <div class="footer-col">
                    <h4>Servicios</h4>
                    <a href="#servicios">Contratos Funerarios</a>
                    <a href="#servicios">Inhumaciones</a>
                    <a href="#servicios">Venta de Nichos</a>
                    <a href="#servicios">Mausoleos</a>
                    <a href="#servicios">Planes de Pago</a>
                    <a href="#servicios">Asesoramiento</a>
                </div>
                <div class="footer-col">
                    <h4>Contacto</h4>
                    <a href="tel:+521234567890">+52 (123) 456-7890</a>
                    <a href="mailto:info@elsepulturerojuan.com">info@elsepulturerojuan.com</a>
                    <p>Camino de la Paz 123<br />Colina del Descanso, Ciudad</p>
                    <p style="margin-top: 0.5rem">
                        Lun–Vie: 8:00 – 18:00<br />Sáb: 9:00 – 14:00
                    </p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>
                    © 2026 Cementerio El Sepulturero Juan. Todos los derechos
                    reservados.
                </p>
                <p>Diseñado con respeto y profesionalismo</p>
            </div>
        </div>

        <div style="text-align:center; padding:1rem; color:#8a8a9a; font-size:0.78rem; border-top:1px solid rgba(201,168,76,0.1);">
            <i class="fas fa-eye me-1"></i>
            Esta página ha sido visitada
            <strong style="color:#c9a84c;">{{ number_format($visitas_pagina ?? 0) }}</strong>
            {{ ($visitas_pagina ?? 0) == 1 ? 'vez' : 'veces' }}
        </div>

    </footer>

    <script>
        // ========== MENÚ MÓVIL ==========
        const menuToggle = document.querySelector('.menu-toggle');
        const navLinks = document.querySelector('.nav-links');

        if (menuToggle) {
            menuToggle.addEventListener('click', function() {
                navLinks.classList.toggle('open');
            });
        }

        // ========== MENÚ DESPLEGABLE DEL USUARIO (VERSIÓN CORREGIDA) ==========
        const userBtn = document.querySelector('.user-btn');
        const userDropdown = document.querySelector('.user-dropdown');

        if (userBtn && userDropdown) {
            userBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                userDropdown.classList.toggle('show');
            });

            // Cerrar dropdown al hacer clic fuera
            document.addEventListener('click', function(e) {
                if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                    userDropdown.classList.remove('show');
                }
            });

            // Prevenir que el dropdown se cierre al hacer clic dentro
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // ========== HEADER SCROLL EFFECT ==========
        window.addEventListener('scroll', function() {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(13, 18, 32, 0.98)';
                header.style.padding = '0.5rem 2rem';
            } else {
                header.style.background = 'rgba(13, 18, 32, 0.96)';
                header.style.padding = '0.8rem 2rem';
            }
        });

        // ========== SMOOTH SCROLL PARA ENLACES ==========
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#' || targetId === '#inicio') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Cerrar menú móvil si está abierto
                    if (navLinks && navLinks.classList.contains('open')) {
                        navLinks.classList.remove('open');
                    }
                }
            });
        });

        // ========== ANIMACIÓN AL HACER SCROLL ==========
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Aplicar animación a elementos
        document.querySelectorAll('.service-card, .space-card, .benefit-card, .testimonial-card, .faq-card, .gallery-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

       

        // ========== CERRAR MENÚ MÓVIL AL REDIMENSIONAR ==========
        window.addEventListener('resize', function() {
            if (window.innerWidth > 640 && navLinks && navLinks.classList.contains('open')) {
                navLinks.classList.remove('open');
            }
        });

        console.log('Sitio El Sepulturero Juan - Cargado correctamente');


        async function buscarEspacios() {
            const tipo = document.getElementById('buscar-tipo').value;
            const resultsDiv = document.getElementById('search-results');

            resultsDiv.style.display = 'block';
            resultsDiv.innerHTML = '<div class="result-empty"><i class="fas fa-spinner fa-spin"></i> Buscando...</div>';

            const url = `{{ route('home.buscar') }}?tipo=${tipo}`;
            const response = await fetch(url);
            const espacios = await response.json();

            if (espacios.length === 0) {
                resultsDiv.innerHTML = '<div class="result-empty">No hay espacios disponibles para ese tipo.</div>';
                return;
            }

            resultsDiv.innerHTML = espacios.slice(0, 5).map(e => `
                <div class="result-item">
                    <div>
                        <span class="result-tipo">${e.tipo_inhumacion?.nombre ?? 'Espacio'}</span>
                        <span style="color:#8a8a9a; margin-left:0.5rem;">${e.cementerio?.nombre ?? ''}</span>
                    </div>
                    <span class="result-precio">Bs. ${parseFloat(e.precio_m2).toFixed(2)}/m²</span>
                </div>
            `).join('') + (espacios.length > 5 ? `<div class="result-empty">Y ${espacios.length - 5} más disponibles. <a href="{{ route('cliente.login') }}" style="color:#c9a84c;">Contáctenos</a></div>` : '');
        }



    </script>
</body>

</html>