<div class="{{ $category->styles['theme'] }} flex flex-col h-screen bg-puesto-app">
<div id="notification-modal" class="fixed hidden inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">

    <div class="bg-white rounded-[2.5rem] shadow-2xl w-full max-w-md overflow-hidden transform transition-all border-4 border-puesto-header">

        <div class="bg-puesto-header p-6 text-white text-center relative">
            <div class="absolute top-4 right-6 animate-ping">
                <span class="block h-3 w-3 rounded-full bg-white opacity-75"></span>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-2 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <h3 class="text-3xl font-black uppercase italic tracking-tighter">¡Vencimiento!</h3>
        </div>

        <div class="p-8 text-center">
            <p class="text-gray-500 font-bold uppercase text-xs tracking-widest mb-1">El siguiente producto está por expirar</p>
            <h4 id="notif-product-name" class="text-4xl font-black text-gray-800 uppercase leading-none mb-4">---</h4>

            <div class="inline-flex items-center px-4 py-2 rounded-full bg-gray-100 text-gray-600 font-bold text-sm mb-6">
                <span id="notif-product-location" class="uppercase">Ubicación desconocida</span>
            </div>

            <button id="closeNotification"
                    class="w-full py-5 bg-puesto-btn text-puesto-btn-text border-b-8 border-puesto-btn-border
                           rounded-2xl text-2xl font-black uppercase tracking-tight
                           active:border-b-0 active:translate-y-2 transition-all duration-100">
                ENTENDIDO
            </button>
        </div>
    </div>
</div>
