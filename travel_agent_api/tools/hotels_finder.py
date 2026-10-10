import os
from typing import Optional

from dotenv import load_dotenv
from langchain_core.tools import tool
from pydantic import BaseModel, Field
from serpapi import GoogleSearch

load_dotenv()


class HotelsInput(BaseModel):
    q: str = Field(description="Località dell'hotel.")
    check_in_date: str = Field(description="Data di check-in nel formato YYYY-MM-DD.")
    check_out_date: str = Field(description="Data di check-out nel formato YYYY-MM-DD.")
    adults: Optional[int] = Field(1, description="Numero di adulti.")
    children: Optional[int] = Field(0, description="Numero di bambini.")
    hotel_class: Optional[int] = Field(2, ge=2, le=5, description="Classe dell'hotel da 2 a 5 stelle.")


class HotelsInputSchema(BaseModel):
    params: HotelsInput


@tool(args_schema=HotelsInputSchema)
def hotels_finder(params: HotelsInput):
    """Cerca hotel tramite Google Hotels attraverso SerpAPI."""
    print("*" * 80)
    print("TOOL: hotels_finder")
    print("*" * 80)

    search_params = {
        "api_key": os.getenv("SERPAPI_API_KEY"),
        "engine": "google_hotels",
        "hl": "it",
        "gl": "it",
        "currency": "EUR",
        "q": params.q,
        "check_in_date": params.check_in_date,
        "check_out_date": params.check_out_date,
        "adults": params.adults,
        "children": params.children,
        "hotel_class": params.hotel_class,
        "num": 5,
    }

    try:
        search = GoogleSearch(search_params)
        return search.get_dict().get("properties", [])
    except Exception as exc:
        print(f"[ERROR] hotels_finder: {exc}")
        return str(exc)
