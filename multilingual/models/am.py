#!/usr/bin/env python
# coding: utf-8

# In[15]:


import re
import glob
import pandas as pd
import csv
import emoji
from typing import List
import sys,os
import tqdm
import pycld2 as cld2

sys.path.append('../')


# In[16]:


import configparser
configParser = configparser.RawConfigParser()   
configFilePath = r'config.txt'
configParser.read(configFilePath)
csvpath = configParser.get('paths', 'csvpath')
outpath = configParser.get('paths', 'outpath')
outpath,csvpath


# In[2]:


#!pip install amseg
from amseg.amharicSegmenter import AmharicSegmenter
from preprocessing.preprocess import * 


# In[18]:


sent_punct = []
word_punct = []
amseg = AmharicSegmenter(sent_punct,word_punct)


# In[19]:


outfile = outpath +"/am_all_sentences.txt" # use ti_all_sentences.txt for tigregna


# In[20]:


os.remove(outfile) if os.path.exists(outfile) else None
allnews = []
for news in glob.glob(csvpath+"/*.csv"):
    allnews.append(news)
    
# read each files and write to a file system 

with open (outfile,"a", encoding="utf-8") as all_sentences:
    lines_seen = set() # holds lines already seen
    for news in tqdm.tqdm(allnews,  position=0, leave=True):
        data = pd.read_csv(news, names=["id","url","date","title","text","html"] ,encoding="utf-8")
        data = data[data.text.duplicated()==False].reset_index()
        data.text = data.text.apply(lambda x: remove_url(x))
        #data.text = data.text.apply(lambda x: remove_emoji(x))
        #data.text = data.text.apply(lambda x: remove_eng(x))
        for text in data.text:
            for s in amseg.tokenize_sentence(text):
                isReliable, textBytesFound, details  = cld2.detect(s)
                if details[0][1] =='am' and s not in lines_seen: # use ti for tigrenya,                 
                    all_sentences.write(' '.join(t.text for t in amseg.amharic_tokenizer(s))+'\n')
                    lines_seen.add(s)


# In[ ]:




