#!/usr/bin/python3
# coding: UTF-8
from flask import Flask, jsonify
from flask_restful import Resource, Api
from sqlalchemy import create_engine
import json

db_connect = create_engine('mysql+mysqldb://password:User@server/amtweet?charset=utf8')
app = Flask(__name__)
api = Api(app)
api.app.config['RESTFUL_JSON'] = {
    'ensure_ascii': False
}
# connect to the database
conn = db_connect.connect()

# Load CSV files

class Tweets(Resource):
    def get(self, n=10):
       # conn = db_connect.connect() # connect to database
        if n > 100:
            n = 100
        from datetime import datetime
        today = datetime.today().strftime('%Y-%m-%d')
        query = conn.execute("select * from tweet where date = '"+ today +"' limit "+ str(n) ) 
        tweets = [i[1] for i in query.cursor.fetchall()]
        print (tweets[0])
        return json.dumps({"Tweets": tweets}, ensure_ascii=False)
    
class Tracks(Resource):
    def get(self):
        query = conn.execute("select trackid, name, composer, unitprice from tracks;")
        result = {'data': [dict(zip(tuple (query.keys()) ,i)) for i in query.cursor]}
        return jsonify(result)

    
class User_Name(Resource):
    def get(self, tweet_id):
        query = conn.execute("select * from tweet where id =%d "  %int(tweet_id))
        result = {'data': [dict(zip(tuple (query.keys()) ,i)) for i in query.cursor]}
        return jsonify(result)

class Hi(Resource):
    def get(self):
        return "It works: ይሠራል!"
api.add_resource(Hi, '/')
api.add_resource(Tweets, '/tweets')
api.add_resource(Tracks, '/tracks')
api.add_resource(User_Name, '/employees/<tweet_id>')

if __name__ == '__main__':
    app.run(host= '0.0.0.0')
