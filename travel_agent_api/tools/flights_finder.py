import os
from typing import Optional

from dotenv import load_dotenv
from langchain_core.tools import tool
from pydantic import BaseModel, Field
from serpapi import GoogleSearch

load_dotenv()


class FlightsInput(BaseModel):
    departure_airport: str = Field(description="Codice IATA dell'aeroporto di partenza.")
    arrival_airport: str = Field(description="Codice IATA dell'aeroporto di arrivo.")
    outbound_date: str = Field(description="Data di andata nel formato YYYY-MM-DD.")
    return_date: str = Field(description="Data di ritorno nel formato YYYY-MM-DD.")
    adults: Optional[int] = Field(1, description="Numero di adulti.")
    children: Optional[int] = Field(0, description="Numero di bambini.")


class FlightsInputSchema(BaseModel):
    params: FlightsInput


@tool(args_schema=FlightsInputSchema)
def flights_finder(params: FlightsInput):
    """Cerca voli tramite Google Flights attraverso SerpAPI."""
    print("*" * 80)
    print("TOOL: flights_finder")
    print("*" * 80)

    search_params = {
        "api_key": os.getenv("SERPAPI_API_KEY"),
        "engine": "google_flights",
        "hl": "it",
        "gl": "it",
        "currency": "EUR",
        "stops": "1",
        "departure_id": params.departure_airport,
        "arrival_id": params.arrival_airport,
        "outbound_date": params.outbound_date,
        "return_date": params.return_date,
        "adults": params.adults,
        "children": params.children,
    }

    try:
        search = GoogleSearch(search_params)
        return search.get_dict()
    except Exception as exc:
        print(f"[ERROR] flights_finder: {exc}")
        return str(exc)
