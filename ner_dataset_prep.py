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


def normalize(norm):
        norm = norm.replace("ሃ", "ሀ")
        norm = norm.replace("ሐ", "ሀ")
        norm = norm.replace("ሓ", "ሀ")
        norm = norm.replace("ኅ", "ሀ")
        norm = norm.replace("ኻ", "ሀ")
        norm = norm.replace("ኃ", "ሀ")
        norm = norm.replace("ዅ", "ሁ")
        norm = norm.replace("ሗ", "ኋ")
        norm = norm.replace("ኁ", "ሁ")
        norm = norm.replace("ኂ", "ሂ")
        norm = norm.replace("ኄ", "ሄ");
        norm = norm.replace("ዄ", "ሄ");
        norm = norm.replace("ኅ", "ህ");
        norm = norm.replace("ኆ", "ሆ");
        norm = norm.replace("ሑ", "ሁ");
        norm = norm.replace("ሒ", "ሂ");
        norm = norm.replace("ሔ", "ሄ");
        norm = norm.replace("ሕ", "ህ");
        norm = norm.replace("ሖ", "ሆ");
        norm = norm.replace("ኾ", "ሆ");
        norm = norm.replace("ሠ", "ሰ");
        norm = norm.replace("ሡ", "ሱ");
        norm = norm.replace("ሢ", "ሲ");
        norm = norm.replace("ሣ", "ሳ");
        norm = norm.replace("ሤ", "ሴ");
        norm = norm.replace("ሥ", "ስ");
        norm = norm.replace("ሦ", "ሶ");
        norm = norm.replace("ሼ", "ሸ");
        norm = norm.replace("ቼ", "ቸ");
        norm = norm.replace("ዬ", "የ");
        norm = norm.replace("ዲ", "ድ");
        norm = norm.replace("ጄ", "ጀ");
        norm = norm.replace("ፀ", "ጸ");
        norm = norm.replace("ፁ", "ጹ");
        norm = norm.replace("ፂ", "ጺ");
        norm = norm.replace("ፃ", "ጻ");
        norm = norm.replace("ፄ", "ጼ");
        norm = norm.replace("ፅ", "ጽ");
        norm = norm.replace("ፆ", "ጾ");
        norm = norm.replace("ዉ", "ው");
        norm = norm.replace("ዴ", "ደ");
        norm = norm.replace("ቺ", "ች");
        norm = norm.replace("ዪ", "ይ");
        norm = norm.replace("ጪ", "ጭ");
        norm = norm.replace("ዓ", "አ");
        norm = norm.replace("ዑ", "ኡ");
        norm = norm.replace("ዒ", "ኢ");
        norm = norm.replace("ዐ", "አ");
        norm = norm.replace("ኣ", "አ");
        norm = norm.replace("ዔ", "ኤ");
        norm = norm.replace("ዕ", "እ");
        norm = norm.replace("ዖ", "ኦ");
        norm = norm.replace("ኚ", "ኝ");
        norm = norm.replace("ሺ", "ሽ");

        norm = re.sub('(ሉ[ዋአ])', 'ሏ', norm)
        norm = re.sub('(ሙ[ዋአ])', 'ሟ', norm)
        norm = re.sub('(ቱ[ዋአ])', 'ቷ', norm)
        norm = re.sub('(ሩ[ዋአ])', 'ሯ', norm)
        norm = re.sub('(ሱ[ዋአ])', 'ሷ', norm)
        norm = re.sub('(ሹ[ዋአ])', 'ሿ', norm)
        norm = re.sub('(ቁ[ዋአ])', 'ቋ', norm)
        norm = re.sub('(ቡ[ዋአ])', 'ቧ', norm)
        norm = re.sub('(ቹ[ዋአ])', 'ቿ', norm)
        norm = re.sub('(ሁ[ዋአ])', 'ኋ', norm)
        norm = re.sub('(ኑ[ዋአ])', 'ኗ', norm)
        norm = re.sub('(ኙ[ዋአ])', 'ኟ', norm)
        norm = re.sub('(ኩ[ዋአ])', 'ኳ', norm)
        norm = re.sub('(ዙ[ዋአ])', 'ዟ', norm)
        norm = re.sub('(ጉ[ዋአ])', 'ጓ', norm)
        norm = re.sub('(ደ[ዋአ])', 'ዷ', norm)
        norm = re.sub('(ጡ[ዋአ])', 'ጧ', norm)
        norm = re.sub('(ጩ[ዋአ])', 'ጯ', norm)
        norm = re.sub('(ጹ[ዋአ])', 'ጿ', norm)
        norm = re.sub('(ፉ[ዋአ])', 'ፏ', norm)
        norm = re.sub('[ቊ]', 'ቁ', norm)
        norm = re.sub('[ኵ]', 'ኩ', norm)
        norm = re.sub('\s+', ' ', norm)

        return norm


path = '/Users/seidmuhieyimam/ownCloud/Research/2019/amharic/data/amharic/tagged/nmsu-say'
outpath = '/Users/seidmuhieyimam/ownCloud/Research/2019/amharic/data/amharic/tagged'
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
                                    taggedwords.append(token.text +"\tB-"+tag)
                                    first = False
                                else:
                                    taggedwords.append(token.text + "\tI-" + tag)
                        else:
                            for token in amharic_tokenizer(re.sub('\s+', ' ', word)):
                                taggedwords.append(token.text + "\tO")
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
                if taggedword.split("\t")[0] in SENT_PUNC:
                    f.writelines('\n')
            f.writelines('\n')

random.seed(30)
random.shuffle(dataset_list)

splt = len(dataset_list)*0.9
train = dataset_list[:int(splt)]

test = dataset_list[int(splt):]
## path to save the txt file.
train_filepath = 'data/ner_train.txt'
test_filepath = 'data/ner_test.txt'
## creating the file.
create_data(train, train_filepath)
create_data(test, test_filepath)

