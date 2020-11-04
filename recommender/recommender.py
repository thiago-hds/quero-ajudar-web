#!/virtualenv/bin/python

import sys
import json
from vacancy_recommender import VacancyRecommender


if __name__ == "__main__":
    args = sys.argv[1:]
    
    recommender = VacancyRecommender()

    if(args[0] == "recommend"):
        if(len(args) < 2):
            raise Exception("invalid number of parameters")
        
        user_id = args[1]
        recommendations = recommender.recommend(int(user_id))
        print(json.dumps(recommendations))