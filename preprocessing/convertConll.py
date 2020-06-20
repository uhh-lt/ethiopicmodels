# Adapted from https://medium.com/thecyphy/training-custom-ner-model-using-flair-df1f9ea9c762

import pandas as pd
from tqdm import tqdm
from difflib import SequenceMatcher
import re
import pickle
import numpy as np


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
    text = re.sub('\s+',' ',text)

    return text


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
                a, text_ = matcher(text, clean(i[0]))
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


if __name__ == '__main__':
    main()