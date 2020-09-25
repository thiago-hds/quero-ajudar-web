# recommender.py
#!/usr/bin/python3

import sys
import pymysql.cursors
from vacancy import Vacancy
import databaseconfig as cfg

from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import RSLPStemmer 




def updateVacancyDescription(dbConnection, vacancyId):
    vacancy = Vacancy.load(dbConnection, vacancyId)
    print(vacancy.name, vacancy.description, vacancy.causes, vacancy.skills)

    # 1 - remocao de stopwords
    stopwords_list = stopwords.words('portuguese')
    print(stopwords_list)
    import nltk
    nltk.download('punkt')

    stop_words = set(stopwords_list) 
    
    word_tokens = word_tokenize(vacancy.description.lower(), language='portuguese') 
    
    filtered_sentence = [w for w in word_tokens if not w in stop_words] 
    
    filtered_sentence = [] 
    
    for w in word_tokens: 
        if w not in stop_words: 
            filtered_sentence.append(w) 
    
    print(word_tokens) 
    print(filtered_sentence) 

    print(len(vacancy.description.split()))
    print(len(filtered_sentence))

    # 2 - stemming
    nltk.download('rslp')
    stemmer = RSLPStemmer()
    filtered_sentence = [stemmer.stem(w) for w in filtered_sentence]
    print(filtered_sentence)






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
