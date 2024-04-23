from fastapi import FastAPI
import search
import recommendation as rd

app = FastAPI()

@app.get("/search/{query}")
def api_search(query):
    a = search.search(query)
    return a

@app.get("/recommend/{Id}")
def api_recommend(Id):
    print(type(Id))
    user_id = int(Id)
    print(type(user_id))
    b = rd.decision(user_id,20)
    return b
