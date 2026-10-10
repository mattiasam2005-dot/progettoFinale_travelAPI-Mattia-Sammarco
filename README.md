# Travel Agent API

Progetto finale della Specializzazione Coding AI.

## Obiettivo

Travel Agent è un assistente di viaggio conversazionale realizzato con Python, FastAPI, LangChain e LangGraph.

L'API espone un endpoint che riceve una conversazione e delega al sistema AI la scelta dello strumento più adatto:

- informazioni storiche e culturali;
- ricerca voli tramite SerpAPI;
- ricerca hotel tramite SerpAPI;
- creazione di itinerari personalizzati.

Il progetto Laravel fornito dal docente funziona come client web e comunica con questa API tramite:

`POST http://127.0.0.1:8080/chat/travel-agent`

## Struttura

```text
travel-agent-api/
├── travel_agent_api/
│   ├── config.py
│   ├── main.py
│   ├── routes/
│   │   └── chat_router.py
│   ├── services/
│   │   └── agent_service.py
│   └── tools/
│       ├── chain_historical_expert.py
│       ├── chain_travel_plan.py
│       ├── flights_finder.py
│       └── hotels_finder.py
├── tests/
├── .env.example
├── .gitignore
├── pyproject.toml
└── README.md
```

## Modifiche e refactoring

Rispetto alla traccia del docente sono state introdotte piccole modifiche per rendere il progetto più leggibile e manutenibile:

1. configurazione delle chiavi e del modello centralizzata in `config.py`;
2. modello OpenAI configurabile tramite `OPENAI_MODEL`;
3. validazione della classe hotel tra 2 e 5 stelle;
4. validazione della richiesta API con Pydantic;
5. gestione dell'errore dell'endpoint con HTTP 500;
6. tracing tramite `print` nei punti principali del flusso;
7. prompt e output strutturato del piano di viaggio resi più espliciti.

## Installazione

Requisiti:

- Python 3.9 o superiore e inferiore a 4.0;
- Poetry;
- una chiave OpenAI;
- una chiave SerpAPI per le ricerche di voli e hotel.

Installazione:

```bash
poetry install
```

## Avvio API

```bash
poetry run uvicorn travel_agent_api.main:app --reload --port 8080
```

Documentazione Swagger:

`http://127.0.0.1:8080/docs`

## Test manuale

Nel pannello Swagger aprire:

`POST /chat/travel-agent`

e provare:

```json
{
  "messages": [
    {
      "role": "user",
      "content": "Raccontami la storia del Rinascimento a Firenze."
    }
  ]
}
```

Per verificare il routing verso altri tool:

```text
Cerco un hotel 4 stelle a Roma dal 15 al 20 maggio 2027 per due adulti.
```

```text
Cerco voli da FCO a CDG per due adulti, partenza 2027-07-05 e ritorno 2027-07-12.
```

```text
Organizza un viaggio a Firenze dal 2027-09-10 al 2027-09-13, viaggio culturale per due adulti, budget 1000 euro.
```

## Tracing

Durante l'esecuzione il terminale mostra messaggi come:

```text
INIT: Travel Agent
TOOLS: [...]
RUN: Travel Agent
TOOL: flights_finder
TOOL: hotels_finder
TOOL: chain_travel_plan
END: Travel Agent
```

Questo permette di osservare il percorso seguito dalla richiesta.

## Collegamento con Laravel

Avviare separatamente il client web fornito dal docente.

```bash
composer install
npm install
npm run dev
php artisan serve
```

Il client Laravel invia le richieste all'endpoint FastAPI sulla porta `8080`.

## Sicurezza

Il file `.env` non deve essere committato.

Le chiavi API devono essere inserite solo localmente nel file `.env`.

Prima della pubblicazione su GitHub controllare:

```bash
git status
```

e verificare che `.env` non venga incluso.

## Flusso dell'applicazione

```text
Utente
  ↓
Laravel / Livewire
  ↓
POST /chat/travel-agent
  ↓
FastAPI Router
  ↓
Agent
  ↓
LangGraph / ReAct
  ↓
Scelta del Tool
  ├── Historical Expert → OpenAI
  ├── Flights Finder → SerpAPI
  ├── Hotels Finder → SerpAPI
  └── Travel Plan → OpenAI + Pydantic parser
  ↓
Risposta
  ↓
Laravel
  ↓
Utente
```

## Tecnologie

- Python
- Poetry
- FastAPI
- Pydantic
- LangChain
- LangGraph
- OpenAI
- SerpAPI
- Laravel
- Livewire
# progettoFinale_travelAPI-Mattia-Sammarco
