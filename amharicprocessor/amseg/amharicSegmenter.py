import re
from typing import List
from flair.data import Token

class AmharicSegmenter:
    SENT_PUNC =  []
    WORD_PUNC =  []
    def __init__(self, sent_punct, word_punct):
        if sent_punct:
            self.SENT_PUNC = sent_punct
        else:
            self.SENT_PUNC = ["።","፥","፨","::","፡፡","?","!"]
        if word_punct:
            self.WORD_PUNC = word_punct
        else:
            self.WORD_PUNC =  ["።","፥","፤","፨","?","!",":","፡","፦","፣"]
            
    def amharic_tokenizer(self, text: str) -> List[Token]:
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
            elif char in self.WORD_PUNC:
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
    
    def find_all(self, punct, text):
        return [i + len(punct)-1 for i in range(len(text)) if text.startswith(punct, i)]
        

    def tokenize_sentence(self, text: str):
        text = re.sub("\n", "።",text)
        text = re.sub("\s+", " ",text)
        #text = re.sub("\r", "።",text)
        #text = re.sub("\n\r", "።",text)
        tokenized_text = []
        idxs = [-1] # see below, used to start the next sentence after the index of the sentence segmenter
        for sep in self.SENT_PUNC:
            idx = text.find(sep)
            if idx > 0:
                allidx = self.find_all(sep, text)
                for idx in allidx:
                    idxs.append(idx)
        idxs = sorted(idxs)
        if len(idxs) ==1:
            tokenized_text.append(text)# just one sentence without the punctuation marks
        for i in range(len(idxs)-1): # 
            tokenized_text.append(text[idxs[i]+1:idxs[i+1]+1].strip())
        return tokenized_text

    # apply sentence tokenization
    def window_lines(self, line, window):
        '''
        Some models require the length of the sentence to be moderate, so to avvoid sgorter sentences, append some using some windowing technique
        '''
        try:
            text = re.sub("\s+", " ",line)
            sentences = [s for s in self.tokenize_sentence(text) if len(s) >= 6]
            windowed_sentences = []
            for snt in range(len(sentences)):
                windowed_sentences.append(" ".join(sentences[snt: snt + window]))
            return windowed_sentences
        except:
            # print(f"Could not parse line \n{line}\n")
            return []
        
    # windwoing with segmented sentence
    def window_sents(self, sentences, window):
        '''
        Some models require the length of the sentence to be moderate, so to avvoid sgorter sentences, append some using some windowing technique
        '''
        try:
            windowed_sentences = []
            for snum in range(len(sentences)):
                windowed_sentences.append(" ".join(sentences[snum: snum + window]))
            return windowed_sentences
        except:
            # print(f"Could not parse line \n{line}\n")
            return []

