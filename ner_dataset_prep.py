import os
from tqdm import tqdm

from bs4 import BeautifulSoup
import pandas as pd

path = '/raid/seid/par4sem/amharic/COLING/ner/nmsu-say'
dataset_list = list()

for file in tqdm(os.listdir(path)):
    if not file.endswith('xml'):
        continue
    with open(path+'/'+file, 'r') as f:
        for line in f:
            if line.strip().endswith('<br />'):
                soup = BeautifulSoup(line.strip(), 'lxml')
                text = soup.text.strip()
                annotations = list()
                for tag in soup.find_all('a'):
                    annotations.append((tag.string, tag['title']))
                    tag.unwrap()
                if(text and annotations):
                    dataset_list.append([text, annotations])

df = pd.DataFrame(dataset_list, columns=['text', 'annotation'])
df.to_csv('ner_data.csv', index=False)
