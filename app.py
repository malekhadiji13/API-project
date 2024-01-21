from flask import Flask, jsonify,send_from_directory, request, abort
from flask_swagger_ui import get_swaggerui_blueprint
from db import *
import uuid
app=Flask(__name__)
import smtplib, ssl

@app.route('/static/<path:path>')
def send_static(path):
    return send_from_directory('static', path)

SWAGGER_URL= '/swagger'
API_URL= '/static/swagger.json'
swaggerui_blueprint= get_swaggerui_blueprint(
    SWAGGER_URL,
    API_URL,
    config={
        'app_name':"seans-Python-Flask-REST-Boilertplate"
    }
)
app.register_blueprint(swaggerui_blueprint, url_prefix=SWAGGER_URL)
if __name__ == '__main__':
    app.run(debug=True)


@app.route('/login', methods=['POST'])
def login():
   
    data = request.get_json()
    email = data.get('email')
    password = data.get('password')

    user = authenticate_user(email, password)

    if user:
        return jsonify({'status': 'success', 'message': 'Login successful','id':user})
    else:
        return jsonify({'status': 'error', 'message': 'Invalid email or password'})

if __name__ == '__main__':
    app.run(debug=True)

@app.route("/GetAllalerts",methods=['GET'])
def get_alerts():
    alerts = list( GetAllAlterts())

    unique_elements = {}

    for element in alerts:
        id = element[0]  
        unique_elements[id] = element

    unique_elements_list = list(unique_elements.values())
    cins = []
    for a in alerts:
        cins.append(GetCitizenFromAltert(a[0]))
    
    return {"alerts": unique_elements_list,"citizens":cins}

@app.route("/GetAllusers",methods=['GET'])
def get_users():
    users = GetAllUsers()   
    return {"users": list(users)}

@app.route("/GetUserById", methods=['GET'])
def get_user_by_id():
    user_id = request.json.get('user_id')

    if user_id is None:
        return jsonify({"message": "User ID not provided"}), 400  
    
    user = GetUserById(user_id)

    if user is None:
        return jsonify({"message": "User not found"}), 404 

    return {"user": user}

@app.route("/AddUser",methods=['POST'])
def add_user():
    data = request.get_json()
    name=data.get('name')
    email = data.get('email')
    password = data.get('password')
    role=data.get('role')

    user = Add_user(name, email, password, role)

    if user:
        return jsonify({'status': 'success', 'message': 'User added successfully'})
    else:
        return jsonify({'status': 'error', 'message': 'Invalid email or password'}), 401
    
@app.route("/UpdateInfo",methods=['PUT'])
def update_info():
    data = request.get_json()
    id = data.get('id')
    name = data.get('name')
    email = data.get('email')
    password = data.get('password')
    resp = Update_user(name,email, password,id)

    return jsonify({'status': resp})

@app.route("/Delete",methods=['DELETE'])
def delete_user():
    data = request.get_json()
    id = data.get('id')
    resp = Delete_user(id)

    return jsonify({'status': resp})

@app.route("/send",methods=['POST'])
def send_email():
    data = request.get_json()
    msg = data.get('msg')
    email = data.get('email')

    smtp_address = 'smtp.gmail.com'
    smtp_port = 465
    # enter info of the sender
    email_address = 'zainebchabeni03@gmail.com'
    email_password = 'vrfsvsplbicjvddj'

    # enter info of the receiver
    email_receiver = email
    #create connection
    context = ssl.create_default_context()
    with smtplib.SMTP_SSL(smtp_address, smtp_port, context=context) as server:
        #connection
        server.login(email_address, email_password)
        #sending the email
        server.sendmail(email_address, email_receiver, msg)
    
    return jsonify({'status': 'sent'})

@app.route("/UpdateStatus",methods=['PUT'])
def UpdateStatus():
    data = request.get_json()
    idAlert = data.get('idAlert')
    print(idAlert)
    resp = update_alert_status(idAlert)

    return jsonify({'status': resp})



    
