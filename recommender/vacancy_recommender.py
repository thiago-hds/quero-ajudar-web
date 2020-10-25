# recommender.py
#!/usr/bin/python3.8
import json
import os
import sys
import pymysql
import nltk
import scipy
import databaseconfig as cfg
import pandas as pd

from sklearn.feature_extraction.text import TfidfVectorizer
from sklearn.feature_extraction.text import CountVectorizer
from sklearn.compose import ColumnTransformer
from sklearn.metrics.pairwise import cosine_similarity



class VacancyRecommender:
    
    def __init__(self):
        self.connection = None
        self.df_vacancies = None
        self.df_applications = None
        self.tfidf_vacancies = None
        self.user_profiles = None

    def connect_database(self):
        self.connection = pymysql.connect(
            host=cfg.mysql['host'],
            database=cfg.mysql['db'],
            user=cfg.mysql['user'],
            password=cfg.mysql['password'],
            charset='utf8mb4'
        )
    
    def disconnect_database(self):
        self.connection.close()
        self.connection = None


    def load_vacancies_from_database(self):
        self.connect_database()

        if self.connection is None:
            raise Exception('Recommender is not connected to a database')

        vacancies_sql = ("SELECT V.`id`, V.`name`, V.`description`,"
                            "(SELECT GROUP_CONCAT(C.`cause_id`) "
                            "FROM `causeables` as C "
                            "WHERE C.`causeable_id` = V.`id` "
                            "AND C.`causeable_type` = 'App\\\\Vacancy' "
                            "GROUP BY (V.`id`)) AS `causes` "
                        "FROM `vacancies` as V "
                        "ORDER BY V.`id`")

        self.df_vacancies = pd.read_sql(vacancies_sql, self.connection, index_col='id')

        self.disconnect_database()

    def load_applications_from_database(self):
        self.connect_database()

        if self.connection is None:
            raise Exception('Recommender is not connected to a database')

        applications_sql = ("SELECT A.`volunteer_user_id`, A.`vacancy_id`, A.`created_at` "
                            "FROM `applications` as A "
                            "WHERE A.`status` = 1")

        self.df_applications = pd.read_sql(
            applications_sql, self.connection,
            index_col=['volunteer_user_id', 'vacancy_id']
        )

        self.disconnect_database()        
    
    def extract_vacancies_features(self):

        #nltk.download('stopwords')
        stopword_list = nltk.corpus.stopwords.words('portuguese')

        #tokenizers
        def causes_tokenizer(str_input):
            return str_input.split('.')

        def text_tokenizer(str_input):
            tokenizer = nltk.RegexpTokenizer(r'\b[^\d\W]+\b')
            words = tokenizer.tokenize(str_input)
            
            #remocao de stopwords
            words = [w for w in words if w not in stopword_list]
            
            return words

        #vetorização TF-IDF
        text_vectorizer = TfidfVectorizer(tokenizer=text_tokenizer)
        causes_vectorizer = TfidfVectorizer(tokenizer=causes_tokenizer, use_idf=False)

        weights = {'name': 1.4, 'description':1.2, 'causes': 1.0}
        column_transformer = ColumnTransformer(
            [('name', text_vectorizer, 'name'),
            ('description', text_vectorizer, 'description'),
            ('causes', causes_vectorizer, 'causes')],
            remainder='drop',
            transformer_weights=weights)

        self.tfidf_vacancies = column_transformer.fit_transform(self.df_vacancies)

        #save tfidf matrix
        #TODO save in database
        scipy.sparse.save_npz(
            'tfidf_vacancies.npz',
            self.tfidf_vacancies
        )


    def build_user_profile(self, user_id):

        def get_vacancy_profile(vacancy_id):
            idx = self.df_vacancies.index.get_loc(vacancy_id)
            vacancy_profile = self.tfidf_vacancies[idx:idx+1]
            return vacancy_profile


        if(self.tfidf_vacancies is None):
            
            try:
                self.tfidf_vacancies = scipy.sparse.load_npz(
                    'tfidf_vacancsies.npz',
                )
            except FileNotFoundError:
                self.extract_vacancies_features()
        
        #obter descrições de todas as vagas em que o usuário se inscreveu
        user_applications = self.df_applications.loc[user_id].index.get_level_values(
            'vacancy_id'
        ).values
        applied_vacancies_profiles = [get_vacancy_profile(idd) for idd in user_applications]
        applied_vacancies_profiles = scipy.sparse.vstack(applied_vacancies_profiles)
        
        #montar perfil do usuario com media das frequencias
        # dos termos que descrevem as vagas em que ele se inscreveu
        user_vacancy_profile_mean = applied_vacancies_profiles.mean(axis=0)

        return user_vacancy_profile_mean


    def recommend(self, user_id, k=500):

        self.load_applications_from_database()
        self.load_vacancies_from_database()

        try:
            user_profile = self.build_user_profile(user_id)

            #ignorar vagas em que o usuarios ja se inscreveu
            items_to_ignore = self.df_applications.loc[user_id].index.get_level_values(
                'vacancy_id'
            ).values
        except KeyError:
            return None

        
        #calcular similaridades entre perfil do usuario e vagas
        cosine_similarities = cosine_similarity(user_profile, self.tfidf_vacancies)[0]
        
        #ordenar vagas por similaridade
        vacancies_ids = self.df_vacancies.index.values
        similarity_scores = zip(vacancies_ids,cosine_similarities)
        similarity_scores = sorted(similarity_scores, key=lambda x: x[1], reverse=True)
        
        # retornar k mais similares exceto as que o usuario ja se inscreveu
        similarity_scores = list(
            filter(lambda x: x[0] not in items_to_ignore, similarity_scores)
        )
        similarity_scores = similarity_scores[:k]

        vacancies_index = [i[0] for i in similarity_scores]
        return self.df_vacancies.loc[vacancies_index].index.values.tolist()

