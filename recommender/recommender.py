# recommender.py
#!/usr/bin/python3

import sys
import pymysql.cursors
from vacancy import Vacancy
import databaseconfig as cfg


def updateVacancyDescription(dbConnection, vacancyId):
    vacancy = Vacancy.load(dbConnection, vacancyId)
    print(vacancy.name, vacancy.description, vacancy.causes, vacancy.skills)




if __name__ == "__main__":
    args = sys.argv[1:]

    print(args)

    dbConnection = pymysql.connect(host=cfg.mysql['host'],
                             user=cfg.mysql['user'],
                             password=cfg.mysql['password'],
                             db=cfg.mysql['db'],
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)

    if(args[0] == "update-vacancy-features"):

        if(len(args) != 2):
            raise Exception("Wrong number of parameters")
        
        updateVacancyDescription(dbConnection, args[1])
