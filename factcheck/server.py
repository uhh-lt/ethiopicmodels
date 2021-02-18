#!/usr/bin/python3
# coding: UTF-8
from flask import Flask, jsonify
from flask_restful import Resource, Api
from sqlalchemy import create_engine
import json
import pandas as pd
import io
import configparser
configParser = configparser.RawConfigParser()   
configFilePath = r'config.txt'
configParser.read(configFilePath)
password = configParser.get('mysql', 'password')
user = configParser.get('mysql', 'user')
server =  configParser.get('mysql', 'server')

db_connect = create_engine('mysql+mysqldb://'+password+':'+user+'@'+server+'/amtweet?charset=utf8')
app = Flask(__name__)
api = Api(app)
api.app.config['RESTFUL_JSON'] = {
    'ensure_ascii': False
}
# connect to the database
conn = db_connect.connect()

# Load CSV files
import os
import itertools
list_of_sentences = []
for root, dirs, files in os.walk('../normalization/processed/'):
    for file in files:
        with io.open("../normalization/processed/" + file, "r",encoding="utf-8") as f:
            content = f.read()
            sentences = [s for s in content.splitlines()]
            print (len(sentences))
            list_of_sentences.append([s for s in content.splitlines()])
allsentence = list(itertools.chain(*list_of_sentences))
sentences_series = pd.Series(allsentence)


class Tweets(Resource):
    def get(self, n=10,today=None):
       # conn = db_connect.connect() # connect to database
        if n > 100:
            n = 100
        if not today:
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
    def get(self, user, n=10):
        query = conn.execute("select * from tweet where user = '"+ user +"' limit "+ str(n))
        tweets = [i[1] for i in query.cursor.fetchall()]
        #result = {'data': [dict(zip(tuple (query.keys()) ,i)) for i in query.cursor]}
        print (tweets[0])
        return json.dumps({"Tweets": tweets}, ensure_ascii=False)

    #======NEWS Retrieval ======
class News_Key(Resource):
    def get(self, word=None, n= 10):   
        if word:
            print(word)
            tagret_sentences = sentences_series[sentences_series.str.contains(word)] 
            sents =  [s for s in tagret_sentences.head(n)]
            print (sents[0])
            return json.dumps({"News": sents}, ensure_ascii=False)
        else:
            sents = [s for s in sentences_series.head(n)]
            return json.dumps({"News": sents}, ensure_ascii=False)
        
        
class Hi(Resource):
    def get(self):
        return "It works: ይሠራል!"
api.add_resource(Hi, '/')
api.add_resource(Tweets, '/tweets')
api.add_resource(Tracks, '/tracks')
api.add_resource(User_Name, '/user/<user>')

# News API
api.add_resource(News_Key, '/news/<word>')

if __name__ == '__main__':
    app.run(host= '0.0.0.0')
