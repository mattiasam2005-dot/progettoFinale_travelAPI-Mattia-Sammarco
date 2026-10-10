
from typing import Optional

from langchain_core.output_parsers import PydanticOutputParser
from langchain_core.prompts import ChatPromptTemplate
from langchain_core.tools import tool
from langchain_openai import ChatOpenAI
from pydantic import BaseModel, Field

from travel_agent_api.config import settings


class TravelPlanInput(BaseModel):
    start_date: str = Field(description="Data di inizio del viaggio, YYYY-MM-DD.")
    end_date: str = Field(description="Data di fine del viaggio, YYYY-MM-DD.")
    destination: str = Field(description="Destinazione del viaggio.")
    adults: Optional[int] = Field(1, description="Numero di adulti.")
    children: Optional[int] = Field(0, description="Numero di bambini.")
    travel_style: str = Field(description="Stile del viaggio.")
    budget: Optional[int] = Field(None, description="Budget totale.")
    activities: str = Field(description="Attività preferite.")
    food_restriction: str = Field(description="Restrizioni alimentari.")


class TravelPlanInputSchema(BaseModel):
    params: TravelPlanInput


class TravelDayOutput(BaseModel):
    morning: str = Field(description="Attività della mattina.")
    afternoon: str = Field(description="Attività del pomeriggio.")
    evening: str = Field(description="Attività della sera.")


class TravelPlanOutput(BaseModel):
    travel_plan: list[TravelDayOutput]


@tool(args_schema=TravelPlanInputSchema)
def chain_travel_plan(params: TravelPlanInput) -> TravelPlanOutput:
    """Genera un itinerario personalizzato e strutturato."""
    print("*" * 80)
    print("TOOL: chain_travel_plan")
    print("*" * 80)

    model = ChatOpenAI(model=settings.openai_model)
    parser = PydanticOutputParser(pydantic_object=TravelPlanOutput)

    system_prompt = f"""
You are a travel expert.
Create a practical and personalized travel plan.

Start date: {params.start_date}
End date: {params.end_date}
Destination: {params.destination}
Adults: {params.adults}
Children: {params.children}
Travel style: {params.travel_style}
Budget: {params.budget}
Preferred activities: {params.activities}
Food restrictions: {params.food_restriction}

Return only information compatible with this output format:
{parser.get_format_instructions()}
"""

    prompt = ChatPromptTemplate.from_messages(
        [
            ("system", "{system_prompt}"),
            ("human", "{input}"),
        ]
    )

    chain = prompt | model | parser

    return chain.invoke({
        "system_prompt": system_prompt,
        "input": "Genera il piano di viaggio richiesto."
    })
