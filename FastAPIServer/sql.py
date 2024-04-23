from sqlalchemy import create_engine
import pandas as pd

hostname = "localhost"
username = "king"
password = "1234"
port = "3306"
database = "minor"

# print("mysql+pymysql://" + username + ":" + password + "@" + hostname + ":" + port + "/" + database)
# mysql+pymysql://king:1234@localhost:3306/minor

cnx = create_engine("mysql+pymysql://" + username + ":" + password + "@" + hostname + ":" + str(port) + "/" + database)

conn = cnx.connect()

sql = pd.read_sql_query("Select * From Users",conn)

df = pd.DataFrame(sql)

print(df.size)

conn.close()
