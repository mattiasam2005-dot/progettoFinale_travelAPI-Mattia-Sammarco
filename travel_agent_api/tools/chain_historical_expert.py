from langchain_core.tools import tool
from langchain_openai import ChatOpenAI
from langchain_core.prompts import ChatPromptTemplate

from travel_agent_api.config import settings


@tool
def chain_historical_expert(input_text: str) -> str:
    """Fornisce informazioni storiche e culturali sulla destinazione richiesta."""
    print("*" * 80)
    print("TOOL: chain_historical_expert")
    print("*" * 80)

    model = ChatOpenAI(model=settings.openai_model)

    system_prompt = """
You are an historical expert and travel culture assistant.
Provide accurate, useful and approachable information about the historical topic.
Use Italian when the user writes in Italian.
Use emojis sparingly to make the answer friendly.
"""

    prompt = ChatPromptTemplate.from_messages(
        [
            ("system", system_prompt),
            ("user", "{input}"),
        ]
    )

    chain = prompt | model
    result = chain.invoke({"input": input_text})

    return result.content
