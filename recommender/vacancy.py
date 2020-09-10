import pymysql.cursors
from mysql import MySql
class Vacancy:

    def __init__(self, idd):
        self.id = idd

    def connect(self): 
        connection = pymysql.connect(host='localhost',
                             user='',
                             password='',
                             db='',
                             charset='utf8mb4',
                             cursorclass=pymysql.cursors.DictCursor)

        with connection.cursor() as cursor:
            # Read a single record
            sql = "SELECT `description` FROM `vacancies` WHERE `id`=44;"
            cursor.execute(sql)
            result = cursor.fetchone()
            
            description = result['description']
            print(description)

        