# Adapted from https://medium.com/thecyphy/training-custom-ner-model-using-flair-df1f9ea9c762

import pandas as pd
from tqdm import tqdm
from difflib import SequenceMatcher
import re
import pickle
import numpy as np
import re
from typing import List
from flair.data import Token

WORD_PUNC = WORD_PUNC = ["።", "፥", "፤", "፨", "?", "!", ":", "፡", "፦", "፣","፣"]

def matcher(string, pattern):
    '''
    Return the start and end index of any pattern present in the text.
    '''
    match_list = []
    pattern = pattern.strip()
    seqMatch = SequenceMatcher(None, string, pattern, autojunk=False)
    match = seqMatch.find_longest_match(0, len(string), 0, len(pattern))
    if (match.size == len(pattern)):
        start = match.a
        end = match.a + match.size
        match_tup = (start, end)
        string = string.replace(pattern, "X" * len(pattern), 1)
        match_list.append(match_tup)

    return match_list, string


def mark_sentence(s, match_list):
    '''
    Marks all the entities in the sentence as per the BIO scheme.
    '''
    word_dict = {}
    for word in s.split():
        word_dict[word] = 'O'

    for start, end, e_type in match_list:
        temp_str = s[start:end]
        tmp_list = temp_str.split()
        if len(tmp_list) > 1:
            word_dict[tmp_list[0]] = 'B-' + e_type
            for w in tmp_list[1:]:
                word_dict[w] = 'I-' + e_type
        else:
            word_dict[temp_str] = 'B-' + e_type
    return word_dict


def clean(text):
    text = ' '.join([token.text for token in amharic_tokenizer(re.sub('\s+',' ',text))])

    return normalize(text)


def create_data(df, filepath):
    '''
    The function responsible for the creation of data in the said format.
    '''
    with open(filepath, 'w') as f:
        for text, annotation in zip(df.text, df.annotation.apply(eval)):
            text = clean(text)
            text_ = text
            match_list = []
            for i in annotation:
                a, text_ = matcher(clean(text), clean(i[0]))
                print(text_, a)
                match_list.append((a[0][0], a[0][1], clean(i[1])))

            d = mark_sentence(text, match_list)

            for i in d.keys():
                f.writelines(i + ' ' + d[i] + '\n')
            f.writelines('\n')


def main():
    ## An example dataframe.
   # data = pd.DataFrame([["Horses are too tall and they pretend to care about your feelings", [("Horses", "ANIMAL")]],
    #                     ["Who is Shaka Khan?", [("Shaka Khan", "PERSON")]],
     #                    ["I like London and Berlin.", [("London", "LOCATION"), ("Berlin", "LOCATION")]],
      #                   ["There is a banyan tree in the courtyard", [("banyan tree", "TREE")]]],
       #                 columns=['text', 'annotation'])

    data = pd.read_csv('../data/ner_data.csv',encoding='utf8')
    msk = np.random.rand(len(data)) < 0.9

    train = data[msk]

    test = data[~msk]
    ## path to save the txt file.
    train_filepath = '../data/ner_train.txt'
    test_filepath = '../data/ner_test.txt'
    ## creating the file.
    create_data(train, train_filepath)
    create_data(test, test_filepath)


import re


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

if __name__ == '__main__':
    main()