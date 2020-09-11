# vacancy.py
#!/usr/bin/python3

import pymysql.cursors

class Vacancy:
    
    def __init__(self, connection, name, description, causes, skills):
        self.connection = connection
        self.name = name
        self.description = description
        self.causes = causes
        self.skills = skills

    @staticmethod
    def load(connection, vacancyId):
        with connection.cursor() as cursor:
            # Read a single record
            #sql = "SELECT `name`,`description` FROM `vacancies` WHERE `id`=%s;"
            sql =   "SELECT V.`id`, V.`name`, V.`description`, \
                    (SELECT GROUP_CONCAT(C.`cause_id`) \
                     FROM `causeables` as C \
                     WHERE C.`causeable_id` = V.`id` \
                     AND C.`causeable_type` = 'App\\Vacancy' \
                     GROUP BY (V.`id`)) AS `causes`,\
                    (SELECT GROUP_CONCAT(S.`skill_id`) \
                     FROM `skillables` as S \
                     WHERE S.`skillable_id` = V.`id` \
                     AND S.`skillable_type` = 'App\\Vacancy' \
                     GROUP BY (V.`id`)) AS `skills` \
                    FROM `vacancies` as V \
                    WHERE V.`id` = %s"
            """
            sql =   "SELECT GROUP_CONCAT(C.`cause_id`) \
                     FROM `causeables` as C \
                     WHERE C.`causeable_id` = %s \
                     AND C.`causeable_type` = 'App\\Vacancy' \
                     GROUP BY C.`causeable_id`"
            """
            print(sql)
            cursor.execute(sql, (vacancyId))
            result = cursor.fetchone()
            print(result)
            title = result['name']
            description = result['description']
            skills = result['causes']
            causes = result['skills']

            print(result)

            return Vacancy(connection, title, description, causes, skills)

    