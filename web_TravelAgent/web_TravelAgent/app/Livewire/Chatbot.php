<?php
namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class Chatbot extends Component
{
    public $currentMessage = '';
    public $userPrompt = '';
    public $chatMessages = [];

    protected $rules = [
        'currentMessage' => 'required'
    ];

    protected $messages = [
        'currentMessage.required' => 'Please enter a message'
    ];

    public function ask()
    {
        $this->validate();

        $this->chatMessages[] = [
            'type' => 'human',
            'content' => $this->currentMessage
        ];

        $this->userPrompt = $this->currentMessage;
        $this->currentMessage = '';

        $this->js('$wire.generateResponse');
    }

    public function generateResponse()
    {
        $response = Http::timeout(120)->post(
            'http://127.0.0.1:8080/chat/travel-agent',
            [
                'messages' => $this->chatMessages
            ]
        );

        if (!$response->successful()) {
            $this->chatMessages[] = [
                'type' => 'ai',
                'content' => 'Si è verificato un errore durante la richiesta. Riprova.'
            ];

            return;
        }

        $content = $response->json();

        if (!is_array($content)) {
            $this->chatMessages[] = [
                'type' => 'ai',
                'content' => 'La risposta ricevuta non è valida. Riprova.'
            ];

            return;
        }

        $this->chatMessages = collect($content)
            ->filter(function ($message) {
                return is_array($message)
                    && isset($message['type'], $message['content'])
                    && in_array($message['type'], ['human', 'ai'])
                    && $message['content'] !== '';
            })
            ->map(function ($message) {
                return [
                    'type' => $message['type'],
                    'content' => $message['content']
                ];
            })
            ->values()
            ->toArray();
    }

    public function render()
    {
        $this->dispatch('scrollChatToBottom');

        return view('livewire.chatbot');
    }
}
