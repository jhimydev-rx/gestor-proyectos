<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GOXU') }} - Árbol de Proyecto</title>

    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=orbitron:400,500,600|rajdhani:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --goxu-gold: #FFD700;
            --goxu-dark: #0A0A0A;
            --goxu-dark-secondary: #1A1A1A;
            --goxu-success: #4CAF50;
            --goxu-warning: #FFA500;
            --goxu-info: #1E90FF;
            --goxu-error: #F44336;
        }

        body {
            background-color: var(--goxu-dark);
            color: white;
            font-family: 'Rajdhani', sans-serif;
            margin: 0;
            padding: 0;
        }

        .goxu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .goxu-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--goxu-gold);
        }

        .goxu-title {
            font-family: 'Orbitron', sans-serif;
            color: var(--goxu-gold);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .goxu-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.2rem;
            font-weight: 500;
        }

        .node circle {
            fill: var(--goxu-dark-secondary);
            stroke: var(--goxu-gold);
            stroke-width: 2px;
            filter: drop-shadow(0 0 4px rgba(255, 215, 0, 0.3));
        }

        .node text {
            font-family: 'Rajdhani', sans-serif;
            font-weight: 500;
            fill: white;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.8);
        }

        .link {
            fill: none;
            stroke: rgba(255, 215, 0, 0.5);
            stroke-width: 1.5px;
        }

        .node-pending circle {
            fill: var(--goxu-warning);
            stroke: darkorange;
        }

        .node-in-progress circle {
            fill: var(--goxu-info);
            stroke: dodgerblue;
        }

        .node-completed circle {
            fill: var(--goxu-success);
            stroke: limegreen;
        }

        .node-error circle {
            fill: var(--goxu-error);
            stroke: darkred;
        }

        .node-clickable {
            cursor: pointer;
        }

        .goxu-tooltip {
            position: absolute;
            padding: 10px;
            background: rgba(10, 10, 10, 0.9);
            border: 1px solid var(--goxu-gold);
            border-radius: 4px;
            pointer-events: none;
            font-size: 14px;
            max-width: 300px;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
        }

        .goxu-tooltip h3 {
            margin: 0 0 5px 0;
            color: var(--goxu-gold);
            font-family: 'Orbitron', sans-serif;
        }

        .goxu-tooltip p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            .goxu-title {
                font-size: 1.8rem;
            }

            .goxu-subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body class="bg-goxu-gradient">
    @include('layouts.navigation')

    <div class="goxu-container">
        <div class="goxu-header">
            <h1 class="goxu-title">Árbol del Proyecto</h1>
            <p class="goxu-subtitle">{{ $arbolDatos['name'] }}</p>
        </div>

        <div id="tree-container" style="overflow: auto; width: 100%;">
            <svg id="tree-svg"></svg>
        </div>
    </div>

    <div id="goxu-tooltip" class="goxu-tooltip" style="display: none;"></div>

    <script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        const datos = @json($arbolDatos);
        const proyectoId = {{ $proyecto->id }};

        const estadoClase = {
            'completada': 'completed',
            'pendiente': 'pending',
            'en_proceso': 'in-progress',
            'error': 'error'
        };

        const margin = { top: 40, right: 120, bottom: 40, left: 120 };
        const width = document.getElementById('tree-container').clientWidth - margin.left - margin.right;
        const height = Math.max(600, datos.children ? datos.children.length * 100 : 600);

        const svg = d3.select("#tree-svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", `translate(${margin.left},${margin.top})`);

        const treeLayout = d3.tree().size([height, width - 200]);
        const root = d3.hierarchy(datos);
        treeLayout(root);

        svg.selectAll(".link")
            .data(root.links())
            .enter().append("path")
            .attr("class", "link")
            .attr("d", d3.linkHorizontal().x(d => d.y).y(d => d.x));

        const node = svg.selectAll(".node")
            .data(root.descendants())
            .enter().append("g")
            .attr("class", d => {
                let nodeClass = "node";
                if (d.data.estado && estadoClase[d.data.estado]) {
                    nodeClass += ` node-${estadoClase[d.data.estado]}`;
                }
                if (d.depth === 0 || d.depth === 1 || d.data.id) {
                    nodeClass += " node-clickable";
                }
                return nodeClass;
            })
            .attr("transform", d => `translate(${d.y},${d.x})`)
            .on("click", (event, d) => {
                if (d.depth === 0) {
                    window.open(`/proyectos/${proyectoId}`, '_blank');
                } else if (d.depth === 1) {
                    window.open(`/proyectos/${proyectoId}/ramas/admin`, '_blank');
                } else if (d.data.id) {
                    window.open(`/admin/tareas/${d.data.id}`, '_blank');
                }
            })
            .on("mouseover", showTooltip)
            .on("mouseout", hideTooltip);

        node.append("circle").attr("r", 8);

        node.append("text")
            .attr("dy", "0.31em")
            .attr("x", d => d.children ? -15 : 15)
            .attr("text-anchor", d => d.children ? "end" : "start")
            .text(d => d.data.name)
            .style("fill", "white")
            .style("font-size", "14px");

        function showTooltip(event, d) {
            const tooltip = d3.select("#goxu-tooltip");
            tooltip.style("display", "block");

            let html = `<h3>${d.data.name}</h3>`;
            if (d.data.estado) {
                html += `<p><strong>Estado:</strong> ${d.data.estado.replace('_', ' ')}</p>`;
            }
            if (d.data.descripcion) {
                html += `<p><strong>Descripción:</strong> ${d.data.descripcion}</p>`;
            }
            if (d.data.fecha_inicio) {
                html += `<p><strong>Inicio:</strong> ${d.data.fecha_inicio}</p>`;
            }
            if (d.data.fecha_fin) {
                html += `<p><strong>Fin:</strong> ${d.data.fecha_fin}</p>`;
            }

            tooltip.html(html)
                .style("left", (event.pageX + 10) + "px")
                .style("top", (event.pageY - 10) + "px");
        }

        function hideTooltip() {
            d3.select("#goxu-tooltip").style("display", "none");
        }

        window.addEventListener('resize', () => {
            const containerWidth = document.getElementById('tree-container').clientWidth;
            const newWidth = containerWidth - margin.left - margin.right;

            d3.select("#tree-svg").attr("width", containerWidth);

            treeLayout.size([height, newWidth - 200]);
            treeLayout(root);

            svg.selectAll(".link").attr("d", d3.linkHorizontal().x(d => d.y).y(d => d.x));
            svg.selectAll(".node").attr("transform", d => `translate(${d.y},${d.x})`);
            svg.selectAll(".node text")
                .attr("x", d => d.children ? -15 : 15)
                .attr("text-anchor", d => d.children ? "end" : "start");
        });
    </script>
</body>
</html>
