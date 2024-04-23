import pandas as pd
from sqlalchemy import create_engine
from sklearn.model_selection import train_test_split
from sklearn.metrics.pairwise import cosine_similarity
from scipy.sparse import csr_matrix

hostname = "localhost"
username = "king"
password = "1234"
port = "3306"
database = "minor"

def new_user(users_df,transactions_df,specific_user_id,k):
    user_age = users_df.loc[users_df['user_id'] == specific_user_id, 'age'].values
    transactions_df['event_type'] = transactions_df['event_type'].map({'view': 1, 'cart': 2, 'purchase': 3})
    min_age = user_age[0] - 5
    max_age = user_age[0] + 5

    # Filter users_df to get user_ids within the specified age range
    users_in_age_range = users_df[(users_df['age'] >= min_age) & (users_df['age'] <= max_age)]

    # Extract user_ids from the filtered users
    user_ids_in_age_range = users_in_age_range['user_id'].tolist()
    
    # Filter transactions_df to get transactions for users in the specified age range
    transactions_in_age_range = transactions_df[transactions_df['user_id'].isin(user_ids_in_age_range)]
    user_item_matrix = pd.pivot_table(transactions_in_age_range, values='event_type', index='user_id', columns='product_id', fill_value=0)
    item_interactions_sum = user_item_matrix.sum(axis=0)
    sorted_items = item_interactions_sum.sort_values(ascending=False)

    top_recommendations = sorted_items.head(k)
    return top_recommendations.index

def exisiting_user(df,k,user_id):
    df['event_type'] = df['event_type'].map({'view': 1, 'cart': 2, 'purchase': 3})
    user_item_matrix = pd.pivot_table(df, values='event_type', index='user_id', columns='product_id', fill_value=0)

    # Convert to sparse matrix for memory efficiency
    sparse_matrix = csr_matrix(user_item_matrix.values)

    # Compute cosine similarity between users
    user_similarity = cosine_similarity(sparse_matrix, dense_output=False)

    # Make predictions on the test set
    user_predictions = user_similarity.dot(user_item_matrix) / user_similarity.sum(axis=1)

    user_predictions_df = pd.DataFrame(user_predictions, index=user_item_matrix.index, columns=user_item_matrix.columns)
    user_row = user_predictions_df.loc[user_id]
    top_products = user_row.sort_values(ascending=False).head(k)
    return top_products.index

def decision(user_id,k):
    cnx = create_engine("mysql+pymysql://" + username + ":" + password + "@" + hostname + ":" + str(port) + "/" + database)
    conn = cnx.connect()

    events = pd.read_sql_query("Select * From events",conn)
    transactions_df = pd.DataFrame(events)
    entries_count = transactions_df[transactions_df['user_id'] == user_id].shape[0]

    if (entries_count<50):
        print('New user')
        users = pd.read_sql_query("Select * From users",conn)
        users_df = pd.DataFrame(users)
        recommendations = new_user(users_df,transactions_df,user_id,k)
    else:
        print('Exisiting user')
        recommendations = exisiting_user(transactions_df,k,user_id)

    products = pd.read_sql_query("Select * From products",conn)
    products_df = pd.DataFrame(products) 
    recommendations_df = pd.DataFrame({'product_id': recommendations})
    result = pd.merge(recommendations_df, products_df, on='product_id')
    result = result.to_json(orient= 'records')

    conn.close()

    return result

if (__name__ == '__main__'):
    import time 
    start = time.time()
    
    #Sample test case
    user_id = 513798370
    print(decision(user_id,20))

    end = time.time()
    print(end - start)
