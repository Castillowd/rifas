<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>App de Números Móvil</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-hover: #3a56d4;
            --secondary: #3f37c9;
            --secondary-hover: #3730b4;
            --success: #4cc9f0;
            --success-hover: #38b5db;
            --danger: #f72585;
            --danger-hover: #e5177b;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --border-radius: 12px;
            --box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            --transition: all 0.3s ease;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
            padding-bottom: env(safe-area-inset-bottom);
            -webkit-text-size-adjust: 100%;
        }

        .container {
            width: 100%;
            max-width: 100%;
            padding: 15px;
            margin: 0 auto;
        }

        h1 {
            text-align: center;
            font-size: clamp(1.5rem, 4vw, 2rem);
            margin: 15px 0;
            color: var(--primary);
            font-weight: 600;
        }

        h2 {
            font-size: clamp(1.2rem, 3vw, 1.5rem);
            margin-bottom: 12px;
            color: var(--secondary);
        }

        .panel {
            background-color: white;
            border-radius: var(--border-radius);
            padding: clamp(15px, 3vw, 20px);
            margin-bottom: 20px;
            box-shadow: var(--box-shadow);
            transition: var(--transition);
        }

        .controls {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }

        .control-group {
            flex: 1 1 45%;
            min-width: 0;
        }

        button {
            padding: clamp(12px, 3vw, 14px) 10px;
            border: none;
            border-radius: var(--border-radius);
            background-color: var(--primary);
            color: white;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: clamp(0.9rem, 3vw, 1rem);
            transition: var(--transition);
            box-shadow: var(--box-shadow);
            touch-action: manipulation;
            min-height: 48px;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: var(--gray) !important;
        }

        button:active:not(:disabled) {
            transform: scale(0.98);
        }

        button.secondary {
            background-color: var(--secondary);
        }

        button.success {
            background-color: var(--success);
            color: var(--dark);
        }

        button.danger {
            background-color: var(--danger);
        }

        .search-box {
            padding: clamp(12px, 3vw, 14px) 15px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            width: 100%;
            font-size: clamp(0.9rem, 3vw, 1rem);
            transition: var(--transition);
            margin-bottom: 10px;
        }

        .number-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 10px;
            margin-bottom: 20px;
        }

        .number-card {
            background-color: white;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            padding: 12px 5px;
            text-align: center;
            cursor: pointer;
            transition: var(--transition);
            font-weight: 600;
            aspect-ratio: 1/1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: var(--box-shadow);
            user-select: none;
            font-size: clamp(1rem, 3vw, 1.2rem);
        }

        .number-card.selected {
            background-color: var(--success);
            color: white;
            border-color: var(--success-hover);
        }

        .number-card.marked {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary-hover);
        }

        .number-card .number-name {
            font-size: clamp(0.6rem, 2vw, 0.75rem);
            margin-top: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 90%;
        }

        .selected-list, .marked-list {
            margin-top: 15px;
            max-height: 40vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }

        .selected-item, .marked-item {
            background-color: #f8f9fa;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: var(--transition);
            font-size: clamp(0.9rem, 3vw, 1rem);
        }

        .marked-item {
            background-color: #edf2ff;
        }

        .item-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px 10px;
            font-size: clamp(0.7rem, 2vw, 0.85rem);
            min-width: 0;
            border-radius: 8px;
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            padding: 15px;
            box-sizing: border-box;
            overflow-y: auto;
        }

        .modal-content {
            background-color: white;
            padding: clamp(15px, 3vw, 25px);
            border-radius: var(--border-radius);
            width: 100%;
            max-width: min(95vw, 500px);
            max-height: 85vh;
            overflow-y: auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: modalFadeIn 0.3s ease;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-title {
            margin-bottom: 20px;
            color: var(--primary);
            font-size: 1.5rem;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-group input, 
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }

        .form-group textarea {
            min-height: 120px;
            resize: vertical;
        }

        .console {
            background-color: var(--dark);
            color: #f8f9fa;
            padding: 15px;
            border-radius: var(--border-radius);
            font-family: 'Courier New', Courier, monospace;
            font-size: 0.9rem;
            max-height: 50vh;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 15px;
        }

        .console-entry {
            margin-bottom: 8px;
            border-bottom: 1px solid #495057;
            padding-bottom: 8px;
            line-height: 1.5;
        }

        .console-time {
            color: #adb5bd;
            font-size: 0.8rem;
            margin-bottom: 3px;
        }

        .console-message {
            color: white;
            word-break: break-word;
        }

        .tab-container {
            display: flex;
            margin-bottom: 15px;
            background-color: #f1f3f5;
            border-radius: var(--border-radius);
            padding: 5px;
        }

        .tab {
            padding: 12px 15px;
            background-color: transparent;
            border: none;
            border-radius: 8px;
            margin-right: 5px;
            cursor: pointer;
            font-weight: 600;
            flex: 1;
            text-align: center;
            transition: var(--transition);
        }

        .tab.active {
            background-color: white;
            color: var(--primary);
            box-shadow: var(--box-shadow);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        @media (min-width: 600px) {
            .number-grid {
                grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            }
            
            .control-group {
                flex: 1 1 22%;
            }
        }

        @media (min-width: 1024px) {
            .container {
                max-width: 1200px;
                padding: 25px;
            }
            
            .number-grid {
                grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selección de Números Móvil</h1>
        
        <div class="tab-container">
            <button class="tab active" data-tab="main">Principal</button>
            <button class="tab" data-tab="console">Consola</button>
        </div>
        
        <div id="main-tab" class="tab-content active">
            <div class="panel">
                <div class="controls">
                    <div class="control-group">
                        <input type="text" class="search-box" placeholder="Buscar número..." id="search-input">
                    </div>
                    <div class="control-group">
                        <button id="clear-search" class="secondary">Limpiar</button>
                    </div>
                </div>
                
                <div class="number-grid" id="number-grid">
                    <!-- Los números del 1 al 100 se generarán aquí -->
                </div>
                
                <div class="controls">
                    <div class="control-group">
                        <button id="name-btn" class="secondary">Asignar Nombres</button>
                    </div>
                    <div class="control-group">
                        <button id="export-btn" class="secondary">Exportar</button>
                    </div>
                    <div class="control-group">
                        <button id="save-btn">Guardar</button>
                    </div>
                    <div class="control-group">
                        <button id="clear-btn" class="danger">Limpiar</button>
                    </div>
                </div>
            </div>
            
            <div class="panel">
                <h2>Números Seleccionados (<span id="selected-count">0</span>)</h2>
                <div class="selected-list" id="selected-list">
                    <!-- Los números seleccionados aparecerán aquí -->
                </div>
            </div>
            
            <div class="panel">
                <h2>Números Marcados (<span id="marked-count">0</span>)</h2>
                <div class="marked-list" id="marked-list">
                    <!-- Los números marcados aparecerán aquí -->
                </div>
            </div>
        </div>
        
        <div id="console-tab" class="tab-content">
            <div class="panel">
                <h2>Consola de Registro</h2>
                <div class="console" id="console">
                    <!-- Los registros de la consola aparecerán aquí -->
                </div>
                <div class="controls">
                    <div class="control-group">
                        <button id="clear-console" class="danger">Limpiar Consola</button>
                    </div>
                    <div class="control-group">
                        <button id="export-console" class="secondary">Exportar Consola</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal para asignar nombres -->
    <div class="modal" id="name-modal">
        <div class="modal-content">
            <h3 class="modal-title">Asignar Nombres</h3>
            <div id="name-inputs">
                <!-- Los inputs para nombres se generarán aquí -->
            </div>
            <div class="modal-actions">
                <button id="cancel-names" class="danger">Cancelar</button>
                <button id="save-names">Guardar</button>
            </div>
        </div>
    </div>
    
    <!-- Modal para exportar -->
    <div class="modal" id="export-modal">
        <div class="modal-content">
            <h3 class="modal-title">Exportar Datos</h3>
            <div class="form-group">
                <label for="export-format">Formato:</label>
                <select id="export-format" class="search-box">
                    <option value="csv">CSV (Excel)</option>
                    <option value="json">JSON</option>
                    <option value="text">Texto</option>
                </select>
            </div>
            <div class="form-group">
                <label for="export-data">Datos:</label>
                <textarea id="export-data" rows="8" style="width: 100%;" readonly></textarea>
            </div>
            <div class="modal-actions">
                <button id="copy-export" class="secondary">Copiar</button>
                <button id="download-export">Descargar</button>
                <button id="close-export" class="danger">Cerrar</button>
            </div>
        </div>
    </div>

    <!-- Modal para contraseña -->
    <div class="modal" id="password-modal">
        <div class="modal-content">
            <h3 class="modal-title">Ingrese la contraseña</h3>
            <div class="form-group">
                <input type="password" id="password-input" class="search-box" placeholder="Contraseña">
            </div>
            <div class="modal-actions">
                <button id="cancel-password" class="danger">Cancelar</button>
                <button id="confirm-password">Confirmar</button>
            </div>
        </div>
    </div>

    <script>
        // Variables globales
        let selectedNumbers = new Set();
        let markedNumbers = new Map();
        let numberNames = new Map();
        let consoleLog = [];
        const PASSWORD = "admin123";
        let currentAction = null;
        let saveTimeout = null;
        
        // Elementos del DOM
        const numberGrid = document.getElementById('number-grid');
        const selectedList = document.getElementById('selected-list');
        const markedList = document.getElementById('marked-list');
        const consoleElement = document.getElementById('console');
        const saveBtn = document.getElementById('save-btn');
        const clearBtn = document.getElementById('clear-btn');
        const nameBtn = document.getElementById('name-btn');
        const exportBtn = document.getElementById('export-btn');
        const searchInput = document.getElementById('search-input');
        const clearSearchBtn = document.getElementById('clear-search');
        const nameModal = document.getElementById('name-modal');
        const nameInputs = document.getElementById('name-inputs');
        const saveNamesBtn = document.getElementById('save-names');
        const cancelNamesBtn = document.getElementById('cancel-names');
        const exportModal = document.getElementById('export-modal');
        const exportFormat = document.getElementById('export-format');
        const exportData = document.getElementById('export-data');
        const copyExportBtn = document.getElementById('copy-export');
        const downloadExportBtn = document.getElementById('download-export');
        const closeExportBtn = document.getElementById('close-export');
        const selectedCount = document.getElementById('selected-count');
        const markedCount = document.getElementById('marked-count');
        const clearConsoleBtn = document.getElementById('clear-console');
        const exportConsoleBtn = document.getElementById('export-console');
        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-content');
        const passwordModal = document.getElementById('password-modal');
        const passwordInput = document.getElementById('password-input');
        const confirmPasswordBtn = document.getElementById('confirm-password');
        const cancelPasswordBtn = document.getElementById('cancel-password');

        // Inicialización
        document.addEventListener('DOMContentLoaded', () => {
            generateNumberGrid();
            loadSavedNumbers();
            updateUI();
            renderConsole();
            
            // Configurar listeners para guardado automático
            setupAutoSave();
            
            // Configurar pestañas
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tabContents.forEach(c => c.classList.remove('active'));
                    
                    tab.classList.add('active');
                    document.getElementById(`${tab.dataset.tab}-tab`).classList.add('active');
                });
            });
            
            // Event listeners
            saveBtn.addEventListener('click', saveSelection);
            clearBtn.addEventListener('click', () => {
                currentAction = 'clearSelection';
                showPasswordModal();
            });
            nameBtn.addEventListener('click', showNameModal);
            exportBtn.addEventListener('click', () => {
                currentAction = 'exportData';
                showPasswordModal();
            });
            clearSearchBtn.addEventListener('click', clearSearch);
            searchInput.addEventListener('input', filterNumbers);
            saveNamesBtn.addEventListener('click', saveNames);
            cancelNamesBtn.addEventListener('click', () => nameModal.style.display = 'none');
            exportFormat.addEventListener('change', updateExportData);
            copyExportBtn.addEventListener('click', copyExportData);
            downloadExportBtn.addEventListener('click', downloadExport);
            closeExportBtn.addEventListener('click', () => exportModal.style.display = 'none');
            clearConsoleBtn.addEventListener('click', () => {
                currentAction = 'clearConsole';
                showPasswordModal();
            });
            exportConsoleBtn.addEventListener('click', exportConsole);
            confirmPasswordBtn.addEventListener('click', verifyPassword);
            cancelPasswordBtn.addEventListener('click', () => passwordModal.style.display = 'none');

            // Mejorar feedback táctil
            document.querySelectorAll('button:not(:disabled), .number-card').forEach(el => {
                el.addEventListener('touchstart', function() {
                    this.classList.add('active-touch');
                }, {passive: true});
                
                el.addEventListener('touchend', function() {
                    this.classList.remove('active-touch');
                }, {passive: true});
            });
        });

        // Función para actualizar el estado de los botones
        function updateButtonsState() {
            nameBtn.disabled = selectedNumbers.size === 0;
            exportBtn.disabled = selectedNumbers.size === 0 && markedNumbers.size === 0;
            saveBtn.disabled = selectedNumbers.size === 0 && markedNumbers.size === 0;
            clearBtn.disabled = selectedNumbers.size === 0 && markedNumbers.size === 0;
            clearConsoleBtn.disabled = consoleLog.length === 0;
            exportConsoleBtn.disabled = consoleLog.length === 0;
        }

        // Función para actualizar toda la UI
        function updateUI() {
            updateNumberCards();
            updateSelectedList();
            updateMarkedList();
            updateCounters();
            updateButtonsState();
            saveSelection();
        }

        // Generar la cuadrícula de números del 1 al 100
        function generateNumberGrid() {
            numberGrid.innerHTML = '';
            
            for (let i = 1; i <= 100; i++) {
                const numberCard = document.createElement('div');
                numberCard.className = 'number-card';
                numberCard.dataset.number = i;
                
                const numberElement = document.createElement('div');
                numberElement.className = 'number';
                numberElement.textContent = i;
                
                const nameElement = document.createElement('div');
                nameElement.className = 'number-name';
                nameElement.textContent = numberNames.get(i) || '';
                
                numberCard.appendChild(numberElement);
                numberCard.appendChild(nameElement);
                
                numberCard.addEventListener('click', () => {
                    toggleNumberSelection(i);
                });
                
                numberGrid.appendChild(numberCard);
            }
        }

        // Configurar el guardado automático
        function setupAutoSave() {
            document.addEventListener('click', debounceSave);
            document.addEventListener('input', debounceSave);
            setInterval(saveSelection, 5000);
        }

        function debounceSave() {
            if (saveTimeout) clearTimeout(saveTimeout);
            saveTimeout = setTimeout(saveSelection, 1000);
        }

        function saveSelection() {
            const data = {
                selected: Array.from(selectedNumbers),
                marked: Array.from(markedNumbers.entries()),
                names: Array.from(numberNames.entries()),
                timestamp: new Date().toISOString()
            };
            
            try {
                localStorage.setItem('rifaAppData', JSON.stringify(data));
                logToConsole('Datos guardados automáticamente', 'info');
            } catch (e) {
                logToConsole('Error al guardar: ' + e.message, 'error');
            }
        }

        function loadSavedNumbers() {
            try {
                const savedData = localStorage.getItem('rifaAppData');
                if (!savedData) return;
                
                const data = JSON.parse(savedData);
                
                if (Array.isArray(data.selected)) {
                    selectedNumbers = new Set(data.selected.filter(n => n >= 1 && n <= 100));
                }
                
                markedNumbers = new Map();
                if (Array.isArray(data.marked)) {
                    data.marked.forEach(([number, timestamp]) => {
                        if (number >= 1 && number <= 100) {
                            markedNumbers.set(number, timestamp || new Date().toLocaleString());
                        }
                    });
                }
                
                numberNames = new Map();
                if (Array.isArray(data.names)) {
                    data.names.forEach(([number, name]) => {
                        if (number >= 1 && number <= 100 && typeof name === 'string') {
                            numberNames.set(number, name.trim());
                        }
                    });
                }
                
                updateUI();
                logToConsole('Datos cargados correctamente');
                
            } catch (e) {
                logToConsole('Error al cargar datos: ' + e.message, 'error');
            }
        }

        function toggleNumberSelection(number) {
            if (selectedNumbers.has(number)) {
                selectedNumbers.delete(number);
                logToConsole(`Número ${number} deseleccionado`);
            } else {
                selectedNumbers.add(number);
                logToConsole(`Número ${number} seleccionado`);
            }
            updateUI();
        }

        function updateNumberCards() {
            document.querySelectorAll('.number-card').forEach(card => {
                const number = parseInt(card.dataset.number);
                card.classList.remove('selected', 'marked');
                
                if (selectedNumbers.has(number)) {
                    card.classList.add('selected');
                } else if (markedNumbers.has(number)) {
                    card.classList.add('marked');
                }
                
                const nameElement = card.querySelector('.number-name');
                nameElement.textContent = numberNames.get(number) || '';
            });
        }

        function updateSelectedList() {
            selectedList.innerHTML = '';
            
            Array.from(selectedNumbers).sort((a, b) => a - b).forEach(number => {
                const item = document.createElement('div');
                item.className = 'selected-item';
                
                const itemText = document.createElement('div');
                itemText.textContent = `Número ${number}: ${numberNames.get(number) || 'Sin nombre'}`;
                
                const itemActions = document.createElement('div');
                itemActions.className = 'item-actions';
                
                const markBtn = document.createElement('button');
                markBtn.className = 'action-btn secondary';
                markBtn.textContent = 'Marcar';
                markBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    markNumber(number);
                });
                
                const removeBtn = document.createElement('button');
                removeBtn.className = 'action-btn danger';
                removeBtn.textContent = 'Quitar';
                removeBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    selectedNumbers.delete(number);
                    updateUI();
                    logToConsole(`Número ${number} quitado de seleccionados`);
                });
                
                itemActions.appendChild(markBtn);
                itemActions.appendChild(removeBtn);
                item.appendChild(itemText);
                item.appendChild(itemActions);
                selectedList.appendChild(item);
            });
        }

        function markNumber(number) {
            if (!markedNumbers.has(number)) {
                markedNumbers.set(number, new Date().toLocaleString());
                selectedNumbers.delete(number);
                logToConsole(`Número ${number} marcado`);
                updateUI();
            }
        }

        function updateMarkedList() {
            markedList.innerHTML = '';
            
            Array.from(markedNumbers.entries()).sort((a, b) => a[0] - b[0]).forEach(([number, timestamp]) => {
                const item = document.createElement('div');
                item.className = 'marked-item';
                
                const itemText = document.createElement('div');
                itemText.textContent = `Número ${number}: ${numberNames.get(number) || 'Sin nombre'} (${timestamp})`;
                
                const itemActions = document.createElement('div');
                itemActions.className = 'item-actions';
                
                const unmarkBtn = document.createElement('button');
                unmarkBtn.className = 'action-btn secondary';
                unmarkBtn.textContent = 'Desmarcar';
                unmarkBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    markedNumbers.delete(number);
                    updateUI();
                    logToConsole(`Número ${number} desmarcado`);
                });
                
                itemActions.appendChild(unmarkBtn);
                item.appendChild(itemText);
                item.appendChild(itemActions);
                markedList.appendChild(item);
            });
        }

        function updateCounters() {
            selectedCount.textContent = selectedNumbers.size;
            markedCount.textContent = markedNumbers.size;
        }

        function showNameModal() {
            nameInputs.innerHTML = '';
            
            Array.from(selectedNumbers).sort((a, b) => a - b).forEach(number => {
                const group = document.createElement('div');
                group.className = 'form-group';
                
                const label = document.createElement('label');
                label.textContent = `Número ${number}:`;
                
                const input = document.createElement('input');
                input.type = 'text';
                input.value = numberNames.get(number) || '';
                input.dataset.number = number;
                input.placeholder = 'Nombre del comprador';
                
                group.appendChild(label);
                group.appendChild(input);
                nameInputs.appendChild(group);
            });
            
            nameModal.style.display = 'flex';
        }

        function saveNames() {
            nameInputs.querySelectorAll('input').forEach(input => {
                const number = parseInt(input.dataset.number);
                const name = input.value.trim();
                
                if (name) {
                    numberNames.set(number, name);
                    logToConsole(`Nombre "${name}" asignado al número ${number}`);
                } else {
                    numberNames.delete(number);
                    logToConsole(`Nombre eliminado del número ${number}`);
                }
            });
            
            updateUI();
            nameModal.style.display = 'none';
        }

        function showExportModal() {
            updateExportData();
            exportModal.style.display = 'flex';
        }

        function updateExportData() {
            const format = exportFormat.value;
            let data = '';
            
            switch(format) {
                case 'csv':
                    data = 'Número,Nombre,Estado,Fecha\n';
                    Array.from(selectedNumbers).sort((a, b) => a - b).forEach(number => {
                        data += `${number},"${numberNames.get(number) || ''}","Seleccionado",\n`;
                    });
                    Array.from(markedNumbers.entries()).sort((a, b) => a[0] - b[0]).forEach(([number, timestamp]) => {
                        data += `${number},"${numberNames.get(number) || ''}","Marcado","${timestamp}"\n`;
                    });
                    break;
                    
                case 'json':
                    const exportObj = {
                        selected: Array.from(selectedNumbers).map(number => ({
                            number,
                            name: numberNames.get(number) || '',
                            status: 'selected'
                        })),
                        marked: Array.from(markedNumbers.entries()).map(([number, timestamp]) => ({
                            number,
                            name: numberNames.get(number) || '',
                            status: 'marked',
                            timestamp
                        }))
                    };
                    data = JSON.stringify(exportObj, null, 2);
                    break;
                    
                case 'text':
                    data = 'NÚMEROS SELECCIONADOS:\n';
                    Array.from(selectedNumbers).sort((a, b) => a - b).forEach(number => {
                        data += `${number}: ${numberNames.get(number) || 'Sin nombre'}\n`;
                    });
                    
                    data += '\nNÚMEROS MARCADOS:\n';
                    Array.from(markedNumbers.entries()).sort((a, b) => a[0] - b[0]).forEach(([number, timestamp]) => {
                        data += `${number}: ${numberNames.get(number) || 'Sin nombre'} (${timestamp})\n`;
                    });
                    break;
            }
            
            exportData.value = data;
        }

        function clearSelection() {
            if (confirm('¿Estás seguro de que quieres borrar todos los datos?')) {
                selectedNumbers.clear();
                markedNumbers.clear();
                numberNames.clear();
                updateUI();
                logToConsole('Todos los datos han sido limpiados', 'warning');
            }
        }

        function clearConsole() {
            consoleLog = [];
            renderConsole();
            logToConsole('Consola limpiada', 'warning');
        }

        function copyExportData() {
            exportData.select();
            document.execCommand('copy');
            logToConsole('Datos copiados al portapapeles', 'success');
        }

        function downloadExport() {
            const format = exportFormat.value;
            const data = exportData.value;
            let mimeType, extension;
            
            switch(format) {
                case 'csv':
                    mimeType = 'text/csv';
                    extension = 'csv';
                    break;
                case 'json':
                    mimeType = 'application/json';
                    extension = 'json';
                    break;
                case 'text':
                    mimeType = 'text/plain';
                    extension = 'txt';
                    break;
            }
            
            const blob = new Blob([data], { type: mimeType });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `numeros-rifa-${new Date().toISOString().slice(0, 10)}.${extension}`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            logToConsole(`Datos exportados como ${format}`, 'success');
        }

        function clearSearch() {
            searchInput.value = '';
            filterNumbers();
        }

        function filterNumbers() {
            const searchTerm = searchInput.value.toLowerCase();
            
            document.querySelectorAll('.number-card').forEach(card => {
                const number = card.dataset.number;
                const name = numberNames.get(parseInt(number)) || '';
                
                if (number.includes(searchTerm) || name.toLowerCase().includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function exportConsole() {
            const data = consoleLog.map(entry => {
                return `[${entry.time}] ${entry.message}`;
            }).join('\n');
            
            const blob = new Blob([data], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `consola-rifa-${new Date().toISOString().slice(0, 10)}.txt`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
            
            logToConsole('Consola exportada', 'success');
        }

        function logToConsole(message, type = 'info') {
            const timestamp = new Date();
            const timeStr = timestamp.toLocaleTimeString();
            
            consoleLog.push({
                time: timeStr,
                message: message,
                type: type
            });
            
            renderConsole();
        }

        function renderConsole() {
            consoleElement.innerHTML = '';
            
            consoleLog.forEach(entry => {
                const entryElement = document.createElement('div');
                entryElement.className = 'console-entry';
                
                const timeElement = document.createElement('div');
                timeElement.className = 'console-time';
                timeElement.textContent = entry.time;
                
                const messageElement = document.createElement('div');
                messageElement.className = 'console-message';
                messageElement.textContent = entry.message;
                
                if (entry.type === 'error') {
                    messageElement.style.color = '#e74c3c';
                } else if (entry.type === 'success') {
                    messageElement.style.color = '#2ecc71';
                } else if (entry.type === 'warning') {
                    messageElement.style.color = '#f39c12';
                }
                
                entryElement.appendChild(timeElement);
                entryElement.appendChild(messageElement);
                consoleElement.appendChild(entryElement);
            });
            
            consoleElement.scrollTop = consoleElement.scrollHeight;
        }

        function showPasswordModal() {
            passwordInput.value = '';
            passwordModal.style.display = 'flex';
        }

        function verifyPassword() {
            if (passwordInput.value === PASSWORD) {
                passwordModal.style.display = 'none';
                switch(currentAction) {
                    case 'clearSelection':
                        clearSelection();
                        break;
                    case 'clearConsole':
                        clearConsole();
                        break;
                    case 'exportData':
                        showExportModal();
                        break;
                }
                currentAction = null;
                logToConsole('Acción protegida realizada', 'success');
            } else {
                alert('Contraseña incorrecta');
                logToConsole('Intento fallido de acción protegida', 'error');
            }
        }

        // Cerrar modales al hacer clic fuera
        window.addEventListener('click', (e) => {
            if (e.target === nameModal) nameModal.style.display = 'none';
            if (e.target === exportModal) exportModal.style.display = 'none';
            if (e.target === passwordModal) passwordModal.style.display = 'none';
        });
    </script>
</body>
</html>