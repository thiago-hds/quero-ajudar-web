# recommender.py
#!/usr/bin/python

import sys
from  vacancy import Vacancy

args = sys.argv[1:]

print(args)

if(args[0] == "update-vacancy-features"):

    if(len(args) != 2):
        raise Exception("Wrong number of parameters")

    vacancy_id = args[1]
    vacancy = Vacancy(vacancy_id)
    vacancy.connect()

    print("id da vaga", vacancy_id)
