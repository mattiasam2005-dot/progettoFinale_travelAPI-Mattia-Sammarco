from fastapi import APIRouter, HTTPException
from pydantic import BaseModel, Field

from travel_agent_api.services.agent_service import Agent

router = APIRouter()


class ChatCompletionRequest(BaseModel):
    messages: list[dict[str, str]] = Field(
        min_length=1,
        description="Conversazione composta da messaggi con role e content.",
    )

    model_config = {
        "json_schema_extra": {
            "example": {
                "messages": [
                    {
                        "role": "user",
                        "content": "Vorrei organizzare un viaggio a Roma.",
                    }
                ]
            }
        }
    }


@router.post("/travel-agent")
def chat_completion(request: ChatCompletionRequest):
    print("*" * 80)
    print("chat_completion")
    print("*" * 80)

    try:
        agent = Agent()
        response = agent.run(messages=request.messages)
        return response
    except Exception as exc:
        print(f"[ERROR] chat_completion: {exc}")
        raise HTTPException(
            status_code=500,
            detail="Errore durante l'elaborazione della richiesta.",
        ) from exc
