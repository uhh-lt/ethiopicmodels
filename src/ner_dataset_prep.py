import os
from tqdm import tqdm

from bs4 import BeautifulSoup
import pandas as pd
from flair.data import Token
from typing import List
WORD_PUNC = ["።", "፥", "፤", "፨", "?", "!", ":", "፡", "፦", "፣","፣",";","(",")"]
SENT_PUNC = ["።","፥","፨","::","፡፡","?","!"]
import re

import numpy as np

import random

def amharic_tokenizer(text: str) -> List[Token]:

    """
    Tokenizer based on space character and different Amharic punctuation marksonly.
    """
    tokens: List[Token] = []
    word = ""
    index = -1
    previchar = ''
    for index, char in enumerate(text):
        if char == " ":
            if len(word) > 0:
                start_position = index - len(word)
                tokens.append(
                    Token(
                        text=word, start_position=start_position, whitespace_after=True
                    )
                )

            word = ""
            previchar = char
        elif char in WORD_PUNC:
            if len(word) > 0 and previchar != char:
                start_position = index - len(word)
                tokens.append(
                    Token(
                        text=word, start_position=start_position, whitespace_after=True
                    )
                )
                word = ""
            previchar = char
            word += char
        elif previchar in WORD_PUNC:
            if len(word) > 0 and previchar != char:
                start_position = index - len(word)
                tokens.append(
                    Token(
                        text=word, start_position=start_position, whitespace_after=True
                    )
                )
                word = ""
            previchar = char
            word += char
        else:
            word += char
    # increment for last token in sentence if not followed by whitespace
    index += 1
    if len(word) > 0:
        start_position = index - len(word)
        tokens.append(
            Token(text=word, start_position=start_position, whitespace_after=False)
        )
    return tokens



path = './nmsu-say'
outpath = './tagged'
dataset_list = list()

for file in tqdm(os.listdir(path)):
    if not file.endswith('xml'):
        continue
    with open(path + '/' + file, 'r') as f:
        for line in f:
            if line.strip().endswith('<br />'):
                soup = BeautifulSoup(line.strip(), 'lxml')
                text = soup.text.strip()
                annotations = {}
                begins = {}
                index = 0
                for tag in soup.find_all('a'):
                    begin = int(soup.text.index(tag.text,index))
                    end = len(tag.text) + begin
                    if text[begin:end] != tag.string:
                        begin = begin - 1
                        end = end - 1
                    begins[begin] = end
                    annotations[begin] = tag['title']
                    tag.unwrap()
                    index = end
                index = 0
                taggedwords = []
                end = 0
                counttagged = 0
                if (text):
                    for word in text.split(" "):
                        # when mword ne exists
                        if end > index:
                            index = index + len(word) + 1
                            continue
                        if end>0 and end in begins:
                            counttagged += 1
                            nes = text[end:begins[end]]
                            tag = annotations[end]
                            first = True
                            end = begins[end]
                            for token in amharic_tokenizer(re.sub('\s+', ' ', nes)):
                                if first:
                                    taggedwords.append(token.text + "\tB-" + tag)
                                    first = False
                                else:
                                    taggedwords.append(token.text + "\tI-" + tag)
                           # continue
                        # if tagged
                        if index in begins or index+1 in begins:
                            end = begins[index] if index in begins else begins[index+1]
                            counttagged += 1
                            nes = text[index:begins[index]] if index in begins else text[index:begins[index +1]]
                            tag = annotations[index] if index in begins else annotations[index +1 ]
                            first = True
                            for token in amharic_tokenizer(re.sub('\s+', ' ', nes)):
                                if first:
                                    taggedwords.append(token.text +" B-"+tag)
                                    first = False
                                else:
                                    taggedwords.append(token.text + " I-" + tag)
                        else:
                            for token in amharic_tokenizer(re.sub('\s+', ' ', word)):
                                taggedwords.append(token.text + " O")
                        index = index + len(word) +1
                    if counttagged != len(annotations):
                        print("Error in parsing")
                    dataset_list.append(taggedwords)

def create_data(taggedlines, filepath):
    '''
    The function responsible for the creation of data in the said format.
    '''
    with open(filepath, 'w') as f:
        for line in taggedlines:
            for taggedword in line:
                f.writelines(taggedword + '\n')
                if taggedword.split(" ")[0] in SENT_PUNC:
                    f.writelines('\n')
            f.writelines('\n')

random.seed(30)
random.shuffle(dataset_list)

splttest = len(dataset_list)*0.9
spltdev = len(dataset_list)*0.8


train = dataset_list[:int(spltdev)]
dev = dataset_list[int(spltdev):int(splttest)]
test = dataset_list[int(splttest):]

## path to save the txt file.
train_filepath = './data/ner_train.txt'
dev_filepath = './data/ner_dev.txt'
test_filepath = './data/ner_test.txt'

print (len(dataset_list),len(train), len(dev), len(test) )
## creating the file.
create_data(train, train_filepath)
create_data(dev, dev_filepath)
create_data(test, test_filepath)



