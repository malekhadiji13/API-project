import mysql.connector
import hashlib

db_config = {
    'host': 'localhost',
    'port': 4306,
    'user': 'root',
    'password': '',
    'database': 'smartcity'
}

def create_connection():
    return mysql.connector.connect(**db_config)

def close_connection(connection, cursor):
    cursor.close()
    connection.close()

def authenticate_user(email, password):
    connection = create_connection()
    cursor = connection.cursor()
    password = hashlib.md5(password.encode("utf-8")).hexdigest()

    query = "SELECT * FROM users WHERE email = %s AND password = %s and role = 'Admin' "
    cursor.execute(query, (email, password))
    user = cursor.fetchone()

    close_connection(connection, cursor)

    return user


def GetAllAlterts():
    connection = create_connection()
    cursor = connection.cursor()

    query = "SELECT * FROM alert a, citizen_alert ca  where a.idAlert = ca.idAlert"
    cursor.execute(query)
    alerts = cursor.fetchall()

    close_connection(connection, cursor)

    return alerts

def GetCitizenFromAltert(a):
   connection = create_connection()
   cursor = connection.cursor()
   query = "SELECT CIN FROM citizen_alert WHERE idAlert = %s"
   cursor.execute(query, (a,))
   cins = cursor.fetchall()
   close_connection(connection, cursor)
   return cins

def GetAllUsers():
    connection = create_connection()
    cursor = connection.cursor()

    query = "SELECT * FROM users"
    cursor.execute(query)
    users = cursor.fetchall()

    close_connection(connection, cursor)

    return users

def GetUserById(user_id):
    connection = create_connection()
    cursor = connection.cursor()

    query = "SELECT * FROM users WHERE id = %s"
    
    cursor.execute(query, (user_id,))
    user = cursor.fetchone()


    close_connection(connection, cursor)

    return user

def Add_user(n,e,p,role):
    connection = create_connection()
    cursor = connection.cursor()
    p = hashlib.md5(p.encode("utf-8")).hexdigest()
    print(p)
    query= "INSERT INTO users (name, email, password, role) VALUES (%s, %s, %s, %s)"
    cursor.execute(query,(n,e,p,role))

    connection.commit()

    resp =cursor.rowcount, "user(s) added"
    close_connection(connection, cursor)

    return resp

def Update_user(n,e,p,id):
    connection = create_connection()
    cursor = connection.cursor()
    p = hashlib.md5(p.encode("utf-8")).hexdigest()
    query = "UPDATE users SET name=%s, email=%s, password=%s WHERE id=%s"
    cursor.execute(query,(n,e,p,id))

    connection.commit()

    resp =cursor.rowcount, "record(s) affected"
    close_connection(connection, cursor)

    return resp

def Delete_user(id):
    connection = create_connection()
    cursor = connection.cursor()

    query = "DELETE FROM users WHERE id=%s"
    cursor.execute(query,(id,))

    connection.commit()

    resp =cursor.rowcount, "user(s) deleted"
    close_connection(connection, cursor)

    return resp

def update_alert_status(idAlert):
    connection = create_connection()
    cursor = connection.cursor()
    query = "UPDATE alert SET status='sent'WHERE idAlert=%s"
    cursor.execute(query,(idAlert,))

    connection.commit()

    resp =cursor.rowcount, "status updated"
    close_connection(connection, cursor)

    return resp

