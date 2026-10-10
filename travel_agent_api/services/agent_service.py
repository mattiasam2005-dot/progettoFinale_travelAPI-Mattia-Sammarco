from datetime import datetime

from langchain_openai import ChatOpenAI
from langgraph.prebuilt import create_react_agent

from travel_agent_api.config import settings
from travel_agent_api.tools.chain_historical_expert import chain_historical_expert
from travel_agent_api.tools.chain_travel_plan import chain_travel_plan
from travel_agent_api.tools.flights_finder import flights_finder
from travel_agent_api.tools.hotels_finder import hotels_finder


class Agent:
    def __init__(self):
        self.current_datetime = datetime.now()
        self.model = ChatOpenAI(model=settings.openai_model)
        self.tools = [
            chain_historical_expert,
            flights_finder,
            hotels_finder,
            chain_travel_plan,
        ]

        print("*" * 80)
        print("INIT: Travel Agent")
        print(f"MODEL: {settings.openai_model}")
        print(f"TOOLS: {[tool.name for tool in self.tools]}")
        print("*" * 80)

        self.agent_executor = create_react_agent(
            self.model,
            self.tools,
        )

    def run(self, messages: list[dict[str, str]]):
        print("*" * 80)
        print("RUN: Travel Agent")
        print(f"MESSAGES: {len(messages)}")
        print("*" * 80)

        system_prompt = f"""
You are a professional travel planner.
Today is {self.current_datetime}.
Answer in Italian when appropriate and use emojis sparingly.

Decide autonomously which available tool is useful for each request.
Available capabilities:
- historical and cultural information
- flight search
- hotel search
- personalized travel itineraries

Never invent real-time flight or hotel availability when a tool has not returned it.
"""

        conversation = [
            {"role": "system", "content": system_prompt},
            *messages,
        ]

        response = self.agent_executor.invoke({"messages": conversation})

        print("*" * 80)
        print("END: Travel Agent")
        print("*" * 80)

        return response["messages"][1:]
