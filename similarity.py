import argparse
import io

import pandas as pd
import numpy as np
from scipy.stats import spearmanr
import torch
import flair
device = torch.device('cuda:0' if torch.cuda.is_available() else 'cpu')
flair.device = device

class Dataset():
    def __init__(self, dataset_path, embedding_path, random_state=42):
        self.dataset_path = dataset_path
        self.embedding_path = embedding_path
        self.df = pd.read_csv(self.dataset_path)
        
        print(f'Loading embedding from {self.embedding_path}')
        self.embedding_data = dict()
        fin = io.open(self.embedding_path, encoding='utf-8', newline='\n')
        self.n_tokens, self.dim = map(int, fin.readline().split())
        for line in fin:
            tokens = line.rstrip().split()
            self.embedding_data[tokens[0]] = list(map(float, tokens[1:]))
        self.unk_vec = np.random.rand(self.dim).tolist()
        
    def replace_token_with_embed(self):
        self.n_vec = 0
        self.n_unk_vec = 0
        def get_embed(x):
            if x in self.embedding_data:
                self.n_vec += 1
                return self.embedding_data[x]
            else:
                self.n_unk_vec += 1
                return self.unk_vec
        word1_embeddings = np.array(self.df.word1_amharic.apply(lambda x: get_embed(x)).tolist())
        word2_embeddings = np.array(self.df.word2_amharic.apply(lambda x: get_embed(x)).tolist())
        print(f'% of unk vectors = {float(self.n_unk_vec)/(self.n_vec + self.n_unk_vec)*100}')
        similarity = np.array(self.df.similarity.tolist())
        return (torch.from_numpy(word1_embeddings).float().to(device), torch.from_numpy(word2_embeddings).float().to(device), similarity)

def train_model(dataset, output_path, random_state):
    cos = torch.nn.CosineSimilarity(dim=1, eps=1e-8)
    word1_embeddings, word2_embeddings, similarity = dataset.replace_token_with_embed()
    assert(word1_embeddings.shape == word2_embeddings.shape)
    feature = cos(word1_embeddings, word2_embeddings).cpu().numpy()
    X = pd.DataFrame({'word1_amharic': dataset.df.word1_amharic, 'word2_amharic': dataset.df.word2_amharic, 'feature': feature})
    srcc, p = spearmanr(similarity, X.feature)
    print(f'Spearman correlation coefficient: {srcc}')
    output_df = pd.DataFrame({'word1_amharic': X['word1_amharic'], 'word2_amharic': X['word2_amharic'], 'ground_truth_similarity': X.feature, 'cosine_similarity': similarity})
    output_df.to_csv(output_path, index=False)

    
if __name__ == '__main__':
    random_state = 42
    np.random.seed(random_state)
    parser = argparse.ArgumentParser(description='compute word-sim correlation')
    parser.add_argument('--dataset_path', type=str, required=True)
    parser.add_argument('--embedding_path', type=str, required=True)
    parser.add_argument('--output_path', type=str)
    args = parser.parse_args()

    dataset = Dataset(dataset_path=args.dataset_path, embedding_path=args.embedding_path)
    train_model(dataset, args.output_path, random_state)
