<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goxu - Organización colaborativa</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #9D4EDD;
            --secondary: #7B2CBF;
            --accent: #E0AAFF;
            --dark: #0a0a0a;
            --light: #121212;
            --text: #F3F3F3;
        }

        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: var(--dark);
            color: var(--text);
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            background-color: #0f0f0f;
            box-shadow: 0 1px 3px rgba(0,0,0,0.4);
            padding: 1rem 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            font-weight: 600;
            font-size: 1.5rem;
            background: linear-gradient(to right, #9D4EDD, #C77DFF);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .nav-links a {
            margin-left: 1.5rem;
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-primary {
            background: linear-gradient(to right, #6A0DAD, #3A006D);
            color: white;
        }

        .btn-primary:hover {
            opacity: 0.9;
        }

        .btn-outline {
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline:hover {
            background-color: rgba(157, 78, 221, 0.1);
        }

        .hero {
            text-align: center;
            padding: 4rem 0;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(to right, #9D4EDD, #C77DFF);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 700px;
            margin: 0 auto 2rem;
            color: #d1d5db;
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 4rem 0;
        }

        .feature-card {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid #3A006D;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.5);
        }

        .feature-icon {
            width: 3rem;
            height: 3rem;
            background-color: #2A003F;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: var(--primary);
            font-size: 1.5rem;
        }

        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #EDEDEC;
        }

        footer {
            background-color: #1A1A1A;
            color: #CCCCCC;
            padding: 3rem 0;
            margin-top: 4rem;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .footer-column h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: white;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
        }

        .footer-column ul li {
            margin-bottom: 0.5rem;
        }

        .footer-column ul li a {
            color: #aaa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: white;
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid #333;
            color: #777;
        }

        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .nav-container {
                flex-direction: column;
            }

            .nav-links {
                margin-top: 1rem;
            }

            .nav-links a {
                margin: 0 0.75rem;
            }
        }
    </style>
</head>
<body>
<!-- CONTENIDO TUYO ORIGINAL AQUÍ (NO SE MODIFICÓ) -->
    <header>
        <div class="nav-container">
            <div class="logo">Goxu</div>
            <div class="nav-links">
                <a href="#features">Características</a>
                <a href="#mission">Misión</a>
                <a href="#vision">Visión</a>
                <a href="#values">Valores</a>
                @auth
                @php
                    $perfil = session('perfil_activo_tipo');
                @endphp


                    @if ($perfil === 'creador')
                        <a href="{{ route('panel.creador') }}" class="btn btn-outline">Ir al panel (Creador)</a>
                    @elseif ($perfil === 'colaborador')
                        <a href="{{ route('panel.colaborador') }}" class="btn btn-outline">Ir al panel (Colaborador)</a>
                    @else
                        <a href="{{ route('perfil.crear') }}" class="btn btn-outline">Completar perfil</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">Iniciar sesión</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>
                @endauth


            </div>
        </div>
    </header>
    
    <main class="container">
        <section class="hero">
            <h1>Organiza, colabora y alcanza tus metas</h1>
            <p>Goxu es la plataforma de gestión de proyectos colaborativa que ayuda a equipos a trabajar de manera más inteligente y eficiente.</p>
            <div>
                <a href="#" class="btn btn-primary">Comenzar ahora</a>
                <a href="#features" class="btn btn-outline">Conocer más</a>
            </div>
        </section>
        
        <section id="features" class="features">
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>Tableros intuitivos</h3>
                <p>Organiza tus proyectos en tableros visuales con listas y tarjetas personalizables.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Colaboración en equipo</h3>
                <p>Trabaja junto a tu equipo en tiempo real con comentarios y asignaciones claras.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Seguimiento de progreso</h3>
                <p>Visualiza el avance de tus proyectos con gráficos y métricas en tiempo real.</p>
            </div>
        </section>
        
        <section id="mission" class="feature-card">
            <h2>Nuestra Misión</h2>
            <p>En Goxu, nos comprometemos a simplificar la gestión de proyectos mediante herramientas intuitivas que fomentan la colaboración, mejoran la productividad y ayudan a los equipos a alcanzar sus objetivos de manera eficiente.</p>
        </section>
        
        <section id="vision" class="feature-card">
            <h2>Nuestra Visión</h2>
            <p>Ser la plataforma líder en gestión colaborativa de proyectos, reconocida por su simplicidad, flexibilidad y capacidad para adaptarse a las necesidades cambiantes de equipos y organizaciones en todo el mundo.</p>
        </section>
        
        <section id="values" class="feature-card">
            <h2>Nuestros Valores</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div>
                    <h3>Colaboración</h3>
                    <p>Creemos en el poder del trabajo en equipo y la sinergia que se crea cuando las personas trabajan juntas.</p>
                </div>
                <div>
                    <h3>Innovación</h3>
                    <p>Buscamos constantemente nuevas formas de mejorar y simplificar la gestión de proyectos.</p>
                </div>
                <div>
                    <h3>Simplicidad</h3>
                    <p>Nos esforzamos por crear herramientas poderosas pero fáciles de usar.</p>
                </div>
                <div>
                    <h3>Transparencia</h3>
                    <p>Fomentamos la comunicación abierta y el acceso a la información relevante.</p>
                </div>
            </div>
        </section>
    </main>
    
    <footer>
        <div class="footer-content">
            <div class="footer-column">
                <h3>Goxu</h3>
                <p>La plataforma de gestión de proyectos diseñada para equipos que quieren trabajar mejor juntos.</p>
            </div>
            
            <div class="footer-column">
                <h3>Producto</h3>
                <ul>
                    <li><a href="#">Características</a></li>
                    <li><a href="#">Precios</a></li>
                    <li><a href="#">Integraciones</a></li>
                    <li><a href="#">Actualizaciones</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Recursos</h3>
                <ul>
                    <li><a href="#">Centro de ayuda</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Tutoriales</a></li>
                    <li><a href="#">API</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h3>Empresa</h3>
                <ul>
                    <li><a href="#mission">Misión</a></li>
                    <li><a href="#vision">Visión</a></li>
                    <li><a href="#values">Valores</a></li>
                    <li><a href="#">Carreras</a></li>
                </ul>
            </div>
        </div>
        
        <div class="copyright">
            &copy; 2023 Goxu. Todos los derechos reservados.
        </div>
    </footer>
</body>
</html>