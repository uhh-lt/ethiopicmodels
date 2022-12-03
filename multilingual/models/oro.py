#!/usr/bin/env python
# coding: utf-8

# In[5]:


import re
import glob
import pandas as pd
import tqdm


# In[6]:


import nltk
from nltk.tokenize import sent_tokenize
nltk.download('punkt')


# In[7]:


import configparser
configParser = configparser.RawConfigParser()   
configFilePath = r'config.txt'
configParser.read(configFilePath)
csvpath = configParser.get('paths', 'csvpath')
outpath = configParser.get('paths', 'outpath')
outpath,csvpath


# In[8]:


all_oro_news = []
for news in glob.glob("oro/*.csv"):
    all_oro_news.append(news)
for news in tqdm.tqdm(all_oro_news,  position=0, leave=True):
    df = pd.read_csv(news, names=["id","url","date","title","text","html"] ,encoding="utf-8")
    files = []
    with open("oro_news.txt","a", encoding="utf-8") as ornews:
        for text in df.text:#tqdm(df['text']):
            if text not in files:
                ornews.write(text+"\n")
                files.append(text)


# In[ ]:





# In[17]:


from nltk.tokenize import word_tokenize, sent_tokenize
with open ('oro_news.txt', 'r', encoding="utf-8") as fin, open(outpath +'/oro_all_sentences.txt','w' , encoding="utf-8") as fout:
    for line in fin:
        tokens = sent_tokenize(line)
        print(' '.join(tokens), end='\n', file=fout)


# In[ ]:





# In[ ]:




