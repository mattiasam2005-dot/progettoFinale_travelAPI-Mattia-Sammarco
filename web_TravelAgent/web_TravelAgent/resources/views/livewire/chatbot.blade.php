<div class="chat-container d-flex flex-column vh-100 justify-content-between bg-body">
    <!-- Header della Chat -->
    <div class="chat-header py-3 px-4 border-bottom d-flex align-items-center justify-content-between bg-body-surface">
        <div class="d-flex align-items-center gap-2 text-truncate">
            <i class="bi bi-chat-left-text text-muted fs-5"></i>
            <h2 class="fs-5 fw-semibold mb-0 text-truncate">{{ $chatTitle ?? 'Nuova Conversazione' }}</h2>
        </div>
        <div class="d-flex align-items-center gap-2">
            <!-- Pulsanti di utility opzionali (es. svuota chat, info) -->
            <button class="btn btn-sm btn-link link-secondary p-1" title="Info"><i class="bi bi-info-circle fs-5"></i></button>
        </div>
    </div>

    <!-- Box dei Messaggi (Scrollabile) -->
    <div class="chat-box flex-grow-1 overflow-y-auto px-3 px-md-5 py-4 d-flex flex-column gap-4">
        @forelse ($chatMessages as $key => $chatMessage)
            
            <!-- MESSAGGIO UTENTE (Umano) -->
            @if ($chatMessage['type'] == 'human')
                <div wire:key="{{ $key }}" class="d-flex gap-3 align-items-start justify-content-end max-w-75 ms-auto">
                    <div class="bg-primary text-white py-2 px-3 rounded-4 shadow-sm" style="border-top-right-radius: 4px !important;">
                        <p class="mb-0 text-break font-sans" style="white-space: pre-wrap;">{{ $chatMessage['content'] }}</p>
                    </div>
                    <div class="chat-message-avatar flex-shrink-0">
                        <img src="/user.png" alt="User" class="rounded-circle border border-2 border-primary-subtle object-fit-cover" width="32" height="32">
                    </div>
                </div>
            @endif

            <!-- MESSAGGIO AI (RagsAI) -->
            @if ($chatMessage['type'] == 'ai' && $chatMessage['content'])
                <div wire:key="{{ $key }}" class="d-flex gap-3 align-items-start me-auto w-100 max-w-100 pb-3 border-bottom border-translucent">
                    <div class="chat-message-avatar flex-shrink-0">
                        <img src="/RagsAI-LOGO.png" alt="RagsAI" class="rounded-circle border object-fit-cover bg-light p-1" width="32" height="32">
                    </div>
                    <div class="flex-grow-1 overflow-x-auto text-body font-sans style-markdown-container">
                        <x-markdown class="lh-lg">{{ $chatMessage['content'] }}</x-markdown>
                    </div>
                </div>
            @endif

        @empty
            <!-- Schermata di Benvenuto / Stato Vuoto -->
            <div class="my-auto text-center py-5">
                <img src="/RagsAI-LOGO.png" alt="Logo" class="mb-3 opacity-75 animation-pulse" style="height: 64px; width: auto;">
                <h3 class="fs-2 fw-bold tracking-tight mb-2">Di cosa hai bisogno oggi?</h3>
                <p class="text-muted mx-auto" style="max-width: 400px;">Chiedimi che tipo di viaggio stai cercando.</p>
            </div>
        @endforelse
    </div>

    <!-- Area Input Messaggio (Fissa in basso) -->
    <div class="px-3 px-md-5 pb-4 bg-gradient-to-t">
        <form id="submitForm" wire:submit.prevent="ask" class="position-relative bg-body-tertiary border rounded-4 shadow-sm p-2 transition-all container-input-focus">
            
            <div class="w-100 px-2 pt-1">
                <!-- Sostituito input con una textarea ad altezza dinamica (o input pulito) -->
                <textarea 
                    class="form-control border-0 bg-transparent p-0 shadow-none resize-none font-sans" 
                    placeholder="Chiedi qualcosa a RagsAI..."
                    wire:model.live="currentMessage" 
                    rows="2"
                    style="min-height: 48px; max-height: 200px;"
                    id="chatInputTextarea"
                ></textarea>
                
                @error('currentMessage')
                    <span class="text-danger small d-block mt-1 ps-1"><i class="bi bi-exclamation-circle"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Toolbar inferiore interna alla bolla di input -->
            <div class="d-flex align-items-center justify-content-between pt-2 border-top border-translucent mt-2 px-1"> 
                <!-- Pulsante di Invio -->
                <button type="submit" class="btn btn-primary btn-icon rounded-3 px-3 py-1.5 d-flex align-items-center gap-1 fw-medium shadow-sm transition-all" @disabled(empty($currentMessage))>
                    <span>Invia</span> <i class="bi bi-arrow-up-short fs-5 lh-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@script
    <script>
        const chatBox = document.querySelector('.chat-box');
        const textarea = document.querySelector('#chatInputTextarea');

        // Autoscroll fluido quando arriva un messaggio
        $wire.on('scrollChatToBottom', () => {
            setTimeout(() => {
                chatBox.scrollTo({
                    top: chatBox.scrollHeight,
                    behavior: 'smooth'
                });
            }, 100);
        });

        // Invio con il tasto Invio (e a capo con Shift+Invio)
        textarea?.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                document.getElementById('submitForm').dispatchEvent(new Event('submit'));
            }
        });
    </script>
@endscript
