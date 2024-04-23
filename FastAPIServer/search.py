from sqlalchemy import create_engine
import pandas as pd
from fuzzywuzzy import fuzz

hostname = "localhost"
username = "king"
password = "1234"
port = "3306"
database = "minor"

def search(reference_string):
    cnx = create_engine("mysql+pymysql://" + username + ":" + password + "@" + hostname + ":" + str(port) + "/" + database)
    conn = cnx.connect()

    sql = pd.read_sql_query("Select * From products",conn)
    products_df = pd.DataFrame(sql)

    products_df['a'] = (
        products_df['category_code'] + ' ' +
        products_df['brand'] + ' ' +
        products_df['product_name'] + ' ' +
        products_df['description'] + ' '
    ).str.lower()

    # Apply the fuzz ratio function to calculate matching scores
    products_df['matching_score'] = products_df['product_name'].apply(lambda x: fuzz.ratio(reference_string, x))

    sorted_products_df = products_df.sort_values(by='matching_score', ascending=False)
    sorted_products_df
    columns_to_drop = ['a', 'matching_score']
    sorted_products_df = sorted_products_df.drop(columns=columns_to_drop)
    sorted_products_df = sorted_products_df.head(20)
    result = sorted_products_df.to_json(orient = 'records')

    conn.close()

    return result

if (__name__ == '__main__'):
    import time 
    start = time.time()
    s = 'ASUS'
    print(search(s))
    end = time.time()
    print(end - start)
